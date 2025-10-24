<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\Filters\VisibilityFilter;
use Illuminate\Http\Request;

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
