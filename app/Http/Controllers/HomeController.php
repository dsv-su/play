<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('redirect-links');
    }

    public function index()
    {
        return view('index');
    }

    public function pending()
    {
        return view('pending.index');
    }
}
