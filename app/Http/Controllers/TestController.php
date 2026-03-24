<?php

namespace App\Http\Controllers;

use App\Services\Daisy\DaisyHealthChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;
use Prism\Prism\ValueObjects\Media\Document;

class TestController extends Controller
{
    public function index()
    {

    }

    public function server()
    {
        //dd($_SERVER);
    }

    public function health(DaisyHealthChecker $checker)
    {
        $data = $checker->call();
        return response()->json($data);
    }
}
