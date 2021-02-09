<?php

namespace App\Services\Tax;

use App\Models\Legal;
use App\Models\Registrar;
use App\Services\Sign\Sign;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use Exception;
use Windwalker\Structure\Format;

class Command extends Tax
{
    private Legal $legal;

    public function __construct($config, Sign $sign)
    {
        parent::__construct($config, $sign);
    }

    public function setLegal(Legal $legal): static
    {
        $this->legal = $legal;

        return $this;
    }

    private function send(array $data, $responseType = Format::JSON)
    {
        if (!$this->legal) {
            throw new Exception('Legal person not specified. Please, specify it before requesting data');
        }

        try {
            $response = $this->client->post('fs/cmd', [
                'body' => $this->sign->sign(json_encode($data, JSON_PRETTY_PRINT), $this->legal),
                'headers' => [
                    'Content-Type' => 'application/octet-stream'
                ]
            ]);
        } catch (ClientException $exception) {
            throw new TransferException($exception->getResponse()->getBody());
        }

        if ($responseType == Format::XML) {
            return $response->getBody()->getContents();
        } else {
            return json_decode($response->getBody()->getContents(), true);
        }
    }

    public function serverState()
    {
        return $this->send(['Command' => 'ServerState']);
    }

    public function objects()
    {
        return $this->send(['Command' => 'Objects']);
    }

    public function transactionsRegistrarState(Registrar $registrar)
    {
        return $this->send([
            'Command' => 'TransactionsRegistrarState',
            'NumFiscal' => $registrar->number_fiscal,
        ]);
    }

    public function shifts(Registrar $registrar, $from = null, $to = null)
    {
        $to = Carbon::parse($to);

        if (!$from) {
            $from = Carbon::parse($to)->startOfMonth();
        } else {
            $from = Carbon::parse($from);
        }

        return $this->send([
            'Command' => 'Shifts',
            'NumFiscal' => $registrar->number_fiscal,
            'From' => $from->toIso8601String(),
            'To' => $to->toIso8601String(),
        ]);
    }

    public function documents(Registrar $registrar, $shiftAttribute)
    {
        $command = [
            'Command' => 'Documents',
            'NumFiscal' => $registrar->number_fiscal
        ];

        $command['ShiftId'] = $shiftAttribute;

        return $this->send($command);
    }

    public function lastShiftTotals(Registrar $registrar)
    {
        return $this->send([
            'Command' => 'LastShiftTotals',
            'NumFiscal' => $registrar->number_fiscal,
        ]);
    }
}
