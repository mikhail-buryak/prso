<?php

namespace App\Services\Tax;

use App\Services\Sign\Sign;
use GuzzleHttp\Client;

abstract class Tax
{
    const CLIENT_ERROR_REGISTRAR_ABSENT = '1 TransactionsRegistrarAbsent';
    const CLIENT_ERROR_SHIFT_OPENED = '4 ShiftAlreadyOpened';
    const CLIENT_ERROR_SHIFT_NOT_OPENED = '5 ShiftNotOpened';
    const CLIENT_ERROR_LAST_MUST_BE_Z_REPORT = '6 LastDocumentMustBeZRep';
    const CLIENT_ERROR_LOCAL_NUM_INVALID = '7 CheckLocalNumberInvalid';
    const CLIENT_ERROR_Z_REPORT_REGISTERED = '8 ZRepAlreadyRegistered';
    const CLIENT_ERROR_DOCUMENT_VALIDATION = '9 DocumentValidationError';

    protected Sign $sign;

    protected Client $client;

    public function __construct($config, Sign $sign)
    {
        $this->sign = $sign;
        $this->client = new Client(['base_uri' => $config['dsn']]);
    }
}
