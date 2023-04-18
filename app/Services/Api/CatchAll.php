<?php

namespace App\Services\Api;

use App\ApiLog;
use Illuminate\Database\Eloquent\Model;

class CatchAll
{
    protected $request, $api;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function catch()
    {
        $this->api = new ApiLog;
        $this->api->catch = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->api->save();

        return response()->json('Logged');
    }
}
