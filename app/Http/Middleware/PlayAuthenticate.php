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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $system = new AuthHandler();
        $system = $system->authorize();
        if(!$system->global->app_env == 'local') {
            if($request->server('REMOTE_USER')) {
                return $next($request);
            }
            return redirect($system->global->login_route);
        }
        else {
            return $next($request);
        }

    }
}
