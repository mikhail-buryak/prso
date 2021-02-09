<?php

namespace App\Services\Tax;

use App\Services\Sign\Sign;
use GuzzleHttp\Client;

abstract class Tax
{
    protected Sign $sign;

    protected Client $client;

    public function __construct($config, Sign $sign)
    {
        $this->sign = $sign;
        $this->client = new Client(['base_uri' => $config['dsn']]);
    }
}
