<?php

namespace App\Http\Middleware;

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
                //return $next($request);
            }
        }
        else {
            //If user is Admin
            // This should be changed to 'play_auth' for production
            if(app()->make('play_role')  == 'Administrator' )  {
                return $next($request);
            }

            //Check if user is courseadmin
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
        if($video->visability == true) {
            return $next($request);
        }


        return redirect()->route('home');

    }
}
