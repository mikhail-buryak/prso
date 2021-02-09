<?php

namespace App\Services\Tax;

use App\Models\Legal;
use App\Models\Receipt;
use App\Models\Registrar;
use App\Models\Transaction;
use App\Models\Transaction\Sub\Validate;
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

    public function __construct(array $config, Sign $sign)
    {
        parent::__construct($config, $sign);

        $this->timezone = $config['timezone'];
    }

    private function send(Transaction $transaction): bool
    {
        try {
            $response = $this->client->post('fs/doc', [
                'body' => $this->sign->sign(mb_convert_encoding($transaction->makeRequest(), 'Windows-1251'), $transaction->legal),
                'headers' => [
                    'Content-Type' => 'application/octet-stream'
                ]
            ]);

            $transaction->status = $response->getStatusCode();

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new TransferException($response->getBody()->getContents());
            }

            $response = $this->sign->decrypt($response->getBody()->getContents());
            $transaction->response = $response;

            $response = new SimpleXMLElement($response);
            $transaction->number_fiscal = (string)$response->ORDERTAXNUM;
            $transaction->fiscal_at = Carbon::createFromFormat(
                'dmY His',
                "{$response->ORDERDATE} {$response->ORDERTIME}",
                $this->timezone)
                ->setTimezone(env('APP_TIMEZONE'));
            $transaction->save();
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            $transaction->status = $response->getStatusCode();
            $transaction->response = $response->getBody()->getContents();
            $transaction->save();

            throw new TransferException($response->getBody());
        } catch (ConnectException $exception) {
            // Here offline mode begins
            $transaction->status = Response::HTTP_SERVICE_UNAVAILABLE;
            $transaction->response = $exception->getMessage();
            $transaction->save();
            throw new ConnectException($exception->getMessage(), $exception->getRequest());
        }

        return true;
    }

    public function shiftOpen()
    {
    }

    public function validate(Receipt $receipt, Registrar $registrar): Transaction
    {
        /** @var Legal $legal */
        $legal = $receipt->legal;

        if ($legal->total_max &&
            $legal->total + $receipt->sum > $legal->total_max) {
            throw new TransferException('The maximum amount for a legal person has been exceeded');
        }

        $transaction = new Validate();
        $transaction->registrar()->associate($registrar);
        $transaction->legal()->associate($legal);

        $receipt->save();
        $transaction->receipt()->associate($receipt);

        if ($this->send($transaction)) {
            $legal->total += $receipt->sum;
            $legal->save();
        }

        return $transaction;
    }

    public function refund()
    {
    }

    public function cancel()
    {
    }

    public function zReport()
    {
    }

    public function shiftClose()
    {
    }
}
