<?php

namespace App\Http\Middleware;

use App\CoursesettingsPermissions;
use App\CoursesettingsUsers;
use App\Services\AuthHandler;
use App\Video;
use Closure;
use Illuminate\Http\Request;

class Playback
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
        /***
         * Middleware for restricting hidden presentations from playback
         */
        $system = new AuthHandler();
        $system = $system->authorize();
        if($video = Video::find(basename($request->getUri()))) {

        }
        else {
            $video = Video::find($request->p);
        }

        //Check if user is through SU SSO
        if(!$request->server('REMOTE_USER'))
        {
            //Local dev enviroment
            if($system->global->app_env == 'local') {
                return $next($request);
            }
        }
        else {
            //If user is Admin
           //TODO

            //Check if user is in Coursesetting users list
            foreach($video->courses() as $course) {
                if(count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                    foreach($course_user_admins as $course_user_admin) {
                        if($course_user_admin . '@su.se' == $_SERVER['eppn']) {
                            //Check if user correct permissions
                            if(in_array($course_user_admin->permission, ['read', 'edit', 'delete'])) {
                                return $next($request);
                            }
                        }
                    }
                }
            }
            //Check if user is in CourseAdmin list
            if($courseadmins = $video->coursepermissions ?? false) {
                foreach($courseadmins as $cper) {
                    //Check if user is listed
                    if($cper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($cper->permission, ['read', 'edit', 'delete'])) {
                            return $next($request);
                        }
                    }

                }
            }

            //Check if individual permissions has been set for presentation
            if($individuals = $video->ipermissions ?? false) {
                foreach($individuals as $iper) {
                    //Check if user is listed
                    if($iper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($iper->permission, ['read', 'edit', 'delete'])) {
                            return $next($request);
                        }
                    }

                }
            }
        }

        //Check if video is hidden
        if($video ?? false) {
            if($video->visability == true) {
                foreach($video->courses() as $course) {
                    if($coursesetting = CoursesettingsPermissions::where('course_id', $course->id)->first()) {
                        if($coursesetting->visibility == true) {
                            return $next($request);
                        } else {
                            return redirect()->route('home');
                        }
                    }
                }

                return $next($request);
            }
        }

        return redirect()->route('home');

    }
}
