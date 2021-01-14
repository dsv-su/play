<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PlayAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!app()->environment('local')) {
            if($request->server('REMOTE_USER')) {
                return $next($request);
            }
        }
        else {
            return $next($request);
        }

    }
}
