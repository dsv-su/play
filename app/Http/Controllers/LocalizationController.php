<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocalizationController extends Controller
{
    public function index(Request $request, $locale)
    {
        App::setlocale($locale);
        session()->put('locale', $locale);
        session(['localisation' => App::getLocale()]);

        if($locale == 'swe') {
            return back()->withInput()->cookie(
                'language', 'se', 0, null, null, false, false
            );
        }
        return back()->withInput()->cookie(
            'language', 'en', 0, null, null, false, false
        );
    }
}
