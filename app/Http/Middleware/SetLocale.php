<?php

namespace App\Http\Middleware;

use App;

class SetLocale
{
    public function handle($request, \Closure $next)
    {
        $locale = $request->cookie('locale')
            ?? ($request->hasSession() ? $request->session()->get('locale') : null)
            ?? config('app.locale');

        app()->setLocale($locale);
        return $next($request);
    }
}
