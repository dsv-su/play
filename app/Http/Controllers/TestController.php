<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {

    }

    public function server()
    {
        dd($_SERVER);
    }
}

