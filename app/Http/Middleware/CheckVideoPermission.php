<?php

namespace App\Http\Middleware;

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
        $permission = VideoPermission::where('video_id', $request->p)->first();
        if(!$permission->permission_id == 4) {
            return redirect()->guest(route('sulogin'));
        }
        return $next($request);
    }
}
