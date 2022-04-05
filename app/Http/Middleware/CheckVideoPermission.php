<?php

namespace App\Http\Middleware;

use App\CoursePermissions;
use App\Services\AuthHandler;
use App\Services\Course\CourseSettingPublic;
use App\Video;
use App\VideoPermission;
use Closure;
use Illuminate\Http\Request;

class CheckVideoPermission
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

        //Presentation setting
        if(!empty($request->has('p'))) {
            $permission = VideoPermission::where('video_id', $request->p)->firstOrFail();
            //Public Course setting
            $presentation = Video::find($request->p);

            if($presentation) {
                if(!$request->server('REMOTE_USER')) {

                    //Check the Presentationsetting
                    if ($permission->permission_id == 4) {
                        //Presentation is public
                        return $next($request);
                        }

                    //Check default setting
                    if($permission->permission_id != 1) {
                        if($system->global->app_env == 'local') {
                            return $next($request);
                        } else {
                            return redirect()->guest(route('sulogin'));
                        }
                    }

                    //Check if coursesettings is public
                    $course_permission = new CourseSettingPublic();
                    if($course_permission->check($presentation) == 4) {
                        //Course is public
                        return $next($request);
                    } else {
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
        //Presentation is missing
        abort(404);
    }
}
