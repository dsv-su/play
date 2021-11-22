<?php

namespace App\Http\Middleware;

use App\CoursePermissions;
use App\Services\AuthHandler;
use App\Video;
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
        //Public Course setting
        /*$presentation = Video::find($request->p);
        foreach($presentation->courses() as $course) {
            $coursepersmission = CoursePermissions::where('course_id', $course->id)->pluck('permission_id');
            dd($course->id);
        }*/
        //<-
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
