<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use App\Services\Course\CourseAdminList;
use App\Services\Course\CourseSettingVisibility;
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
        if(!$request->server('REMOTE_USER')) {
            //Local dev enviroment
            if($system->global->app_env == 'local') {
                return $next($request);
            }
            //If Shibboleth session is missing
            return redirect()->route('home');
        }
        else {
            //Shibboleth

            //If user is Admin
            if(app()->make('play_role') == 'Administrator') {
                return $next($request);
            }


            //Check if video belongs to course
            if(count($video->courses()) >= 1) {
                //Associated to one or more course
                $courseadmin_list = new CourseAdminList();
                $coursesetting = new CourseSettingVisibility();

                // (1) Check if user is courseAdmin
                if(app()->make('play_role') == 'Courseadmin') {
                    //User is courseadmin
                    $courseadmin = new \App\Services\Course\CourseAdmin();
                    if($courseadmin->check(app()->make('play_username'), $video)) {

                        return $next($request);
                    }
                }

                // (2) Check if user exist in coursesettings list
                if($courseadmin_list->check(app()->make('play_username'), $video)) {
                    //User exist in CourseAdmin List

                    return $next($request);
                }

                // (3) Check if Individual presentation settings allows playback
                //Check if individual permissions has been set for presentation
                if($individuals = $video->ipermissions ?? false) {
                    foreach($individuals as $iper) {
                        //Check if user is listed
                        if($iper->username == app()->make('play_username')) {
                            //Check if user has set permissions
                            if(in_array($iper->permission, ['read', 'edit', 'delete'])) {

                                return $next($request);
                            }
                        }

                    }
                }

                // (4) Check if Course visibility allows playback
                if($coursesetting->check($video)) {

                    return $next($request);
                } else {

                    return redirect()->route('home');
                }

                // (5) **Disabled** Check if Presentation visibility allows playback
                if($video->visibility) {
                    return $next($request);
                }

                return redirect()->route('home');

            } else {

                //Not associated to a course

                if($video->visibility) {

                    return $next($request);
                }
                else {

                    //Check individual settings
                    //Check if individual permissions has been set for presentation
                    if($individuals = $video->ipermissions ?? false) {
                        foreach($individuals as $iper) {
                            //Check if user is listed
                            if($iper->username == app()->make('play_username')) {
                                //Check if user has set permissions
                                if(in_array($iper->permission, ['read', 'edit', 'delete'])) {

                                    return $next($request);
                                }
                            }

                        }
                    }

                    return redirect()->route('home');
                }
            }
        //End Shibboleth
        }

        //If none of the above handles the request
        return redirect()->route('home');

    }
}
