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
        //Presentation setting
        $permission = VideoPermission::where('video_id', $request->p)->firstOrFail();
        //Public Course setting
        $presentation = Video::find($request->p);

        if(!$request->server('REMOTE_USER')) {
            //Coursesetting
            foreach($presentation->courses() as $course) {
                $coursepersmission = CoursePermissions::where('course_id', $course->id)->pluck('permission_id');
                if(count($coursepersmission) == 1) {
                    if($coursepersmission[0] == 4 and ($permission->permission_id == 2 or $permission->permission_id == 3 or $permission->permission_id > 4)) {
                        if($system->global->app_env == 'local') {
                            return $next($request);
                        } else {
                            return redirect()->guest(route('sulogin'));
                        }
                    }
                } else {
                    //Presentationsetting
                    if($permission->permission_id != 4) {
                        if($system->global->app_env == 'local') {
                            return $next($request);
                        } else {
                            return redirect()->guest(route('sulogin'));
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
