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
        if($locale == 'swe') {
            $minutes = 3600;
            return back()->withInput()->cookie(
                'language', 'se', $minutes
            );
        }
        Cookie::expire('language');
        return back()->withInput();
    }
}
