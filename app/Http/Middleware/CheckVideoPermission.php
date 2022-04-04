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
        if(!empty($request->has('p'))) {
            $permission = VideoPermission::where('video_id', $request->p)->firstOrFail();
            //Public Course setting
            $presentation = Video::find($request->p);

            if($presentation) {
                if(!$request->server('REMOTE_USER')) {
                    //If presentation permisson setting is not default
                    //Check the Presentationsetting
                    if ($permission->permission_id == 4) {
                        //Presentation is public
                        return $next($request);
                    }
                    //If not the presentation has default setting
                    if($permission->permission_id != 1) {
                        if($system->global->app_env == 'local') {
                            return $next($request);
                        } else {
                            return redirect()->guest(route('sulogin'));
                        }
                    }

                    //Coursesetting for each course
                    if(count($presentation->courses())>=1 ) {
                        //If presentation is associated with one or several course
                        foreach($presentation->courses() as $course) {
                            if($coursepersmission = CoursePermissions::where('course_id', $course->id)->pluck('permission_id')->first()) {
                                if($coursepersmission != 4) {
                                    if($system->global->app_env == 'local') {
                                        return $next($request);
                                    } else {
                                        return redirect()->guest(route('sulogin'));
                                    }
                                }
                            }
                        }
                    }
                }

                return $next($request);
            }
        }
        //Presentation is missing
        abort(404);
    }
}
