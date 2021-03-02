<?php

namespace App\Services\Store;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class CheckPlayStoreApi extends Model
{
    public function call($uri)
    {
        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('GET', $uri, [
                'headers' => $headers,
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();

                return $response = $e->getResponse()->getBody();
            }
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['base_uri'];
    }
}
