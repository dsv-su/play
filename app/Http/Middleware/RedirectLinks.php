<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectLinks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $links = session()->has('links') ? session('links') : [];

        // Store current URI
        $currentLink = request()->path();

        // Putting it in the beginning of links array
        array_unshift($links, $currentLink);

        // Saving links array to the session
        session(['links' => $links]);

        return $next($request);
    }
}
