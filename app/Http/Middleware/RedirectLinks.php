<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectLinks
{
    public function handle(Request $request, Closure $next)
    {
        // Clean entries recorded by older versions, including each upload chunk URL.
        $links = array_values(array_filter(session('links', []), function ($link) {
            return is_string($link)
                && !str_ends_with(rtrim(parse_url($link, PHP_URL_PATH) ?? '', '/'), '/stream/upload');
        }));
        session(['links' => $links]);

        // Only page visits belong in back-navigation history.
        if (!$request->isMethod('GET') || $request->expectsJson() || $request->ajax()) {
            return $next($request);
        }

        $currentLink = $request->fullUrl(); // or $request->path()

        // Insert at the beginning
        array_unshift($links, $currentLink);

        // Remove duplicates & limit history
        $links = array_values(array_unique($links));
        $links = array_slice($links, 0, 10);

        session(['links' => $links]);

        return $next($request);
    }
}
