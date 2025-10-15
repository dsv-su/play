<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectLinks
{
    public function handle(Request $request, Closure $next)
    {
        $links = session('links', []);
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
