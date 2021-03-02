<?php

namespace App\Services\Daisy;

use App\System;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class DaisyIntegration extends Model
{
    protected $system, $res, $client;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    public function getResource($endpoint)
    {
        $this->client = new Client();
        return $this->client->request('GET', $this->system->daisy_url.$endpoint, [
            'auth' => [$this->system->daisy_username, $this->system->daisy_password]
        ]);

    }
}
