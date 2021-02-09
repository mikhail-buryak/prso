<?php

namespace App\Services\Sign;

use App\Models\Legal;
use Exception;
use GuzzleHttp\Client;

class Sign
{
    protected Client $client;

    public function __construct($config)
    {
        $this->client = new Client(['base_uri' => $config['host']]);
    }

    public function sign($data, Legal $legal): string
    {
        $data = [
            [
                'name' => 'content',
                'contents' => $data,
                'filename' => 'content'
            ],
            [
                'name' => 'password',
                'contents' => $legal->passphrase,
            ],
            [
                'name' => 'key',
                'contents' => $legal->key,
                'filename' => 'key'
            ],
            [
                'name' => 'cert',
                'contents' => $legal->cert,
                'filename' => 'cert'
            ],
        ];

        $response = $this->client
            ->post('/', ['multipart' => $data]);

        return $response->getBody()->getContents();
    }

    public function decrypt(string $data): bool|string
    {
        try {
            $response = $this->client->post('/decrypt', [
                'multipart' => [
                    [
                        'name' => 'content',
                        'contents' => $data,
                        'filename' => 'content'
                    ]
                ]
            ]);
        } catch (Exception) {
            return false;
        }

        return $response->getBody()->getContents();
    }
}
