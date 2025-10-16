<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $allowed = config('app.supported_locales', ['en']);
        abort_unless(in_array($locale, $allowed, true), 404);

        // Persist in session and apply immediately
        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        cookie()->queue(cookie()->forever('locale', $locale));
        // Set the language cookie ('se' or 'en')
        $language = $locale === 'se' ? 'se' : 'en';
        cookie()->queue(cookie('language', $language, 0, null, null, false, false));

        return back()->with('status', __('messages.welcome'));
    }

}
