<?php

namespace App\Services\Api;

use App\Models\ApiLog;
use Illuminate\Http\Request;

class CatchAll
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function logRequest()
    {
        $apiLog = new ApiLog();
        $apiLog->payload = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $apiLog->jobid = $this->request->input('jobid');
        $apiLog->pk_id = $this->request->input('package.pkg_id');

        $apiLog->save();

        return response()->json(['message' => 'Logged successfully']);
    }
}

