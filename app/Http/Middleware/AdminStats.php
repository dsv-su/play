<?php

namespace App\Http\Middleware;

use App\Services\CountPresentations;
use Closure;
use Illuminate\Http\Request;

class AdminStats
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
        app()->bind('total_videos', function() {
            $videos = new CountPresentations();
            return $videos->latest();
        });
        return $next($request);
    }
}
