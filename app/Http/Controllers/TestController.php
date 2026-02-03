<?php

namespace App\Http\Controllers;

use App\Services\Daisy\DaisyHealthChecker;

class TestController extends Controller
{
    public function index()
    {
        //return view('faq.faq_student');
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

