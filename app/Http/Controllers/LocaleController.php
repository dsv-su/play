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

        // Persist the choice and apply immediately for this request
        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        // Optional: also persist in a cookie for guests
        cookie()->queue(cookie()->forever('locale', $locale));

        return back()->with('status', __('messages.welcome')); // example flash msg
    }
}
