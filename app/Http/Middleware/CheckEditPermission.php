<?php

namespace App\Http\Middleware;

use App\CourseadminPermission;
use App\CoursesettingsUsers;
use App\Services\AuthHandler;
use App\Video;
use Closure;
use Illuminate\Http\Request;

class CheckEditPermission
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
        if (!$request->server('REMOTE_USER')) {
            if ($system->global->app_env == 'local') {
                return $next($request);
            } else {
                return redirect()->guest(route('sulogin'));
            }
        } else {
            $video = Video::find(basename($request->getUri()));

            //If user is Admin
            // This should be changed to 'play_auth' for production
            if (app()->make('play_role') == 'Administrator') {
                return $next($request);
            }

            // Check if user is in courseadmin_permissions
            if (CourseadminPermission::where('username', app()->make('play_username'))->where('video_id', $video->id)->whereIn('permission', ['delete', 'edit'])->count()) {
                return $next($request);
            }

            //Check if user is courseadmin
            if (app()->make('play_role') == 'Courseadmin') {
                $courseadmin = new \App\Services\Course\CourseAdmin();
                if($courseadmin->check(app()->make('play_username').'@su.se' , $video)) {
                    return $next($request);
                }
            }

            //Check if user is in Coursesetting users list
            foreach ($video->courses() as $course) {
                if (count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                    foreach ($course_user_admins as $course_user_admin) {
                        if ($course_user_admin->username == app()->make('play_username')) {
                            //Check if user correct permissions
                            if (in_array($course_user_admin->permission, ['edit', 'delete'])) {
                                return $next($request);
                            }
                        }
                    }
                }
            }

            //Check if individual permissions has been set for presentation
            if ($individuals = $video->ipermissions ?? false) {
                foreach ($individuals as $iper) {
                    //Check if user is listed
                    if ($iper->username == app()->make('play_username')) {
                        //Check if user has set permissions
                        if (in_array($iper->permission, ['edit', 'delete'])) {
                            return $next($request);
                        }
                    }

                }
            }
        }

        return redirect()->route('home');

    }
}
