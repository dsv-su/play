<?php

namespace App\Http\Middleware;

use App\CoursePermissions;
use App\Services\AuthHandler;
use App\Video;
use App\VideoPermission;
use Closure;
use Illuminate\Http\Request;

class CheckPresentationPermission
{
    /**
     * Handle an incoming request and check if the requested presentation
     * is public.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $system = new AuthHandler();
        $system = $system->authorize();
        if ($request->is('presentation/*')) {
            $id = substr($request->path(), strrpos($request->path(), '/') + 1);
            $permission = VideoPermission::where('video_id', $id)->firstOrFail();
            $presentation = Video::find($id);

            if(!$request->server('REMOTE_USER')) {

                // Check the Presentationsetting
                if ($permission->permission_id == 4) {
                    //Presentation is public
                    return $next($request);
                }

                // Check default setting
                if($permission->permission_id != 1) {
                    if($system->global->app_env == 'local') {
                        return $next($request);
                    } else {
                        return redirect()->guest(route('sulogin'));
                    }
                }

                // Course settings
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
        }
        else {
            return redirect()->guest(route('sulogin'));
        }
        return $next($request);
    }
}
