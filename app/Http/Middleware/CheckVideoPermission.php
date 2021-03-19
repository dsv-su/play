<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use App\VideoPermission;
use Closure;
use Illuminate\Http\Request;

class CheckVideoPermission
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
        $permission = VideoPermission::where('video_id', $request->p)->firstOrFail();
        if(!$request->server('REMOTE_USER')) {
            if($permission->permission_id != 4) {
                if($system->global->app_env == 'local') {
                    return $next($request);
                } else {
                    return redirect()->guest(route('sulogin'));
                }
            }
        }

        return $next($request);
    }
}
