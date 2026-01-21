<?php

namespace App\Services\Store;

use GuzzleHttp\Client;

class DownloadResource
{
    public function __construct(private string $token) {}

    public function getFile(string $storage, string $url): void
    {
        $client   = new Client();
        $resource = storage_path('app/public/'.$storage);

        //\Log::notice('preparing get request', ['token' => $this->token]);

        $client->request('GET', $url, [
            'cache' => 'no-cache',
            'query' => ['token' => $this->token],
            'sink'  => $resource,
        ]);
    }
}
