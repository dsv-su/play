<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
        $minutes = 3600;
        if($locale == 'swe') {
            return back()->withInput()->cookie(
                'language', 'se', $minutes, null, null, false, false
            );
        }
        return back()->withInput()->cookie(
            'language', 'en', $minutes, null, null, false, false
        );
    }
}
