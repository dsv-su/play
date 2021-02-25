<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use Closure;
use Illuminate\Http\Request;

class PlayAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $system = new AuthHandler();
        $system = $system->authorize();
        if($system->global->app_env == 'local') {
            app()->bind('play_user', function() {
                return 'Developer';
            });
            app()->bind('play_username', function() {
                return 'dsv-dev';
            });
            return $next($request);
        }
        else {
            app()->bind('play_user', function() {
                return $_SERVER['displayName'];
            });
            app()->bind('play_username', function() {
                return substr($_SERVER['eppn'], 0, strpos($_SERVER['eppn'], "@"));
            });
            return $next($request);
        }

    }
}
