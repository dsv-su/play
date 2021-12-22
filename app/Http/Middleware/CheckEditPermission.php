<?php

namespace App\Http\Middleware;

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

            //Check if user is courseadmin
            // This should be changed to 'play_auth' for production
            if (app()->make('play_role') == 'Courseadmin') {
                return $next($request);
            }

            //Check if user is in Coursesetting users list
            foreach ($video->courses() as $course) {
                if (count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                    foreach ($course_user_admins as $course_user_admin) {
                        if ($course_user_admin->username . '@su.se' == $_SERVER['eppn']) {
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
                    if ($iper->username . '@su.se' == $_SERVER['eppn']) {
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
