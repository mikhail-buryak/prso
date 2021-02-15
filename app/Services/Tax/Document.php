<?php

namespace App\Services\Tax;

use App\Models\Receipt;
use App\Models\Registrar;
use App\Models\Transaction;
use App\Models\Transaction\ShiftOpen;
use App\Models\Transaction\Sub\Validate;
use App\Models\Transaction\Sub\Refund;
use App\Models\Transaction\Sub\Cancel;
use App\Models\Transaction\ZReport;
use App\Models\Transaction\ShiftClose;
use App\Services\Sign\Sign;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Response;
use SimpleXMLElement;

class Document extends Tax
{
    private $timezone;
    private $encoding;

    public function __construct(array $config, Sign $sign)
    {
        parent::__construct($config, $sign);

        $this->timezone = $config['timezone'];
        $this->encoding = $config['encoding'];
    }

    private function send(Transaction $transaction): bool
    {
        try {
            $response = $this->client->post('fs/doc', [
                'body' => $this->sign->sign(
                    mb_convert_encoding("<?xml version=\"1.0\" encoding=\"{$this->encoding}\"?>{$transaction->makeRequest()}", $this->encoding),
                    $transaction->legal
                ),
                'headers' => [
                    'Content-Type' => 'application/octet-stream'
                ]
            ]);

            $transaction->status = $response->getStatusCode();

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new TransferException($response->getBody()->getContents());
            }

            $transaction->response = $this->sign->decrypt($response->getBody()->getContents());

            $response = new SimpleXMLElement($transaction->response);
            $transaction->number_fiscal = (string)$response->ORDERTAXNUM;
            $transaction->fiscal_at = Carbon::createFromFormat(
                'dmY His', "{$response->ORDERDATE} {$response->ORDERTIME}", $this->timezone)->setTimezone(env('APP_TIMEZONE'));
            $transaction->number_local = $transaction->registrar->next_number_local++;
            $transaction->registrar->save();
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            $transaction->status = $response->getStatusCode();
            $transaction->response = $response->getBody()->getContents();

            return $this->handleClientException($exception, $transaction);
        } catch (ConnectException $exception) {
            // Here offline mode begins
            $transaction->status = Response::HTTP_SERVICE_UNAVAILABLE;
            $transaction->response = $exception->getMessage();

            throw new ConnectException($exception->getMessage(), $exception->getRequest());
        } finally {
            $transaction->save();
        }

        return true;
    }

    private function handleClientException(ClientException $exception, Transaction $transaction): bool
    {
        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $exception->getResponse();

        // ShiftNotOpened
        if (strripos($response->getBody(), self::CLIENT_ERROR_SHIFT_NOT_OPENED)) {
            if ($transaction->type == Transaction::TYPE_Z_REPORT || $transaction->type == Transaction::TYPE_SHIFT_CLOSE) {
                $transaction->registrar->closed = true;
                $transaction->registrar->save();
                return false;
            }

            $this->shiftOpen($transaction->registrar);
            return $this->send($transaction);
        }

        // CheckLocalNumberInvalid
        if (strripos($response->getBody(), self::CLIENT_ERROR_LOCAL_NUM_INVALID)) {
            $this->syncRegistrar($transaction->registrar);
            return $this->send($transaction);
        }

        throw new TransferException($response->getBody());
    }

    private function syncRegistrar(Registrar $registrar): Registrar
    {
        /** @var Command $command */
        $command = app(Command::class)
            ->setLegal($registrar->legal);

        $registrarState = $command->transactionsRegistrarState($registrar);
        $registrar->next_number_local = $registrarState['NextLocalNum'];
        $registrar->save();

        return $registrar;
    }

    public function shiftOpen(Registrar $registrar): ShiftOpen
    {
        $transaction = new ShiftOpen();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($registrar->legal);

        if ($this->send($transaction)) {
            $registrar->closed = false;
            $registrar->opened_at = Carbon::now();
            $registrar->save();
        }

        return $transaction;
    }

    public function validate(Receipt $receipt, Registrar $registrar): Transaction
    {
        $transaction = new Validate();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($receipt->legal);

        if ($duplicate = $this->findDuplicate($transaction, $receipt)) {
            return $duplicate;
        }

        $receipt->save();
        $transaction->receipt()->associate($receipt);

        $this->send($transaction);

        return $transaction;
    }

    public function refund(Receipt $receipt, Registrar $registrar, int $refundNumberFiscal): Transaction
    {
        $transaction = new Refund();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($receipt->legal);
        $transaction->refundNumberFiscal = $refundNumberFiscal;

        if ($duplicate = $this->findDuplicate($transaction, $receipt)) {
            return $duplicate;
        }

        $receipt->save();
        $transaction->receipt()->associate($receipt);

        $this->send($transaction);

        return $transaction;
    }

    public function cancel(int $cancelNumberFiscal): Cancel
    {
        /** @var Transaction $transactionOriginal */
        $transactionOriginal = Transaction::with(['legal', 'registrar'])
            ->where('number_fiscal', $cancelNumberFiscal)
            ->firstOrFail();

        $transaction = new Cancel();
        $transaction->cancelNumberFiscal = $cancelNumberFiscal;
        $transaction->receipt()->associate($transactionOriginal->receipt);
        $transaction->registrar()->associate($transactionOriginal->registrar);
        $transaction->legal()->associate($transactionOriginal->legal);

        $this->send($transaction);

        return $transaction;
    }

    public function zReport(Registrar $registrar): ZReport
    {
        $transaction = new ZReport();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($registrar->legal);

        $this->send($transaction);

        return $transaction;
    }

    public function shiftClose(Registrar $registrar): ShiftClose
    {
        $transaction = new ShiftClose();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($registrar->legal);

        if ($this->send($transaction)) {
            $registrar->closed = true;
            $registrar->closed_at = Carbon::now();
            $registrar->save();
        }

        return $transaction;
    }

    protected function findDuplicate(Transaction $transaction, Receipt $receipt): Transaction|bool
    {
        $duplicate = Transaction::where('legal_id', $transaction->legal->getKey())
            ->where('type', $transaction->type)
            ->where('sub_type', $transaction->sub_type)
            ->whereHas('receipt', function ($query) use ($receipt) {
                $query
                    ->where('order_code', $receipt->order_code)
                    ->where('sum', $receipt->sum);
            })
            ->first();

        if (!$duplicate) {
            return false;
        }

        if ($duplicate->status !== Response::HTTP_OK) {
            return $this->restore($duplicate);
        }

        return $duplicate;
    }

    protected function restore(Transaction $transaction): Transaction|bool
    {
        /** @var Command $command */
        $command = app(Command::class)
            ->setJuridicalPerson($transaction->juridicalPerson);

        $info = $command->documentInfoByLocalNum($transaction);

        if (!$info) {
            return false;
        }

        $transaction->number_fiscal = $info['NumFiscal'];
        $transaction->status = Response::HTTP_OK;
        $transaction->response = $command->check($transaction);
        $transaction->save();

        return $transaction;
    }
}
