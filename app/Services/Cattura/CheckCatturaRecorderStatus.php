<?php

namespace App\Services\Cattura;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class CheckCatturaRecorderStatus extends Model
{
    public function call($base_uri, $uri)
    {
        $client = new Client(['base_uri' => $base_uri]);
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('GET', $uri, [
                'headers' => $headers,'verify' => false
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                return $response = $e->getResponse()->getBody();
            }
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
