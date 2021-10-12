<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use App\Video;
use Closure;
use Illuminate\Http\Request;

class CheckEditPermission
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
        if(!$request->server('REMOTE_USER'))
        {
            if($system->global->app_env == 'local') {
                return $next($request);
            } else {
                return redirect()->guest(route('sulogin'));
            }
        }
        else {
            $video = Video::find(basename($request->getUri()));

            //Check if user is courseadmin
            if($courseadmins = $video->coursepermissions ?? false) {
                foreach($courseadmins as $cper) {
                    //Check if user is listed
                    if($cper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($cper->permission, ['edit', 'delete'])) {
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
                        if(in_array($iper->permission, ['edit', 'delete'])) {
                            return $next($request);
                        }
                    }

                }
            }
        }

        return redirect()->route('home');

    }
}
