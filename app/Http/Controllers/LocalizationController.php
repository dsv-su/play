<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
    public function index(Request $request, $locale)
    {
        App::setlocale($locale);
        session()->put('locale', $locale);
        return back()->withInput();
    }
}
