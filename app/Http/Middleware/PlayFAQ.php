<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PlayFAQ
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
        app()->bind('play_faq', function() {
            return false;
        });
        if(in_array(session('localisation'), ['en', 'swe'])) {
            app()->bind('play_faq_url', function() {
                return session('faq_url');
            });
            session()->forget('localisation');
        } else {
            app()->bind('play_faq_url', function() {
                return str_replace(url('/'), '', url()->previous());

            });
        }


        return $next($request);
    }
}
