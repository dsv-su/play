<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use App\System;
use Closure;
use Illuminate\Http\Request;

class PlayAuthenticate
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

        if($system->global->app_env == 'local') {
            app()->bind('play_user', function() {
                return 'Developer';
            });
            app()->bind('play_username', function() {
                return 'dsv-dev';
            });

            app()->bind('play_auth', function () {
                return 'Administrator';
            });

            app()->bind('play_role', function () {
                return 'Administrator';
            });

            return $next($request);
        }
        else {
            app()->bind('play_user', function() {
                return $_SERVER['displayName'];
            });
            app()->bind('play_username', function() {
                return substr($_SERVER['eppn'], 0, strpos($_SERVER['eppn'], "@"));
            });

            // Get Shibboleth entitlements
            $server = explode(";", $_SERVER['entitlement']);

            // Roles
            $role_admin = $system->global->admin;
            $role_uploader = $system->global->uploader;
            $role_staff = $system->global->staff;

            // Assign role to user
            if(in_array($role_admin, $server)) {
                app()->bind('play_auth', function () {
                    return 'Administrator';
                });
                /*app()->bind('play_role', function () {
                    return 'Administrator';
                });*/
            }
            elseif (in_array($role_uploader, $server)) {
                app()->bind('play_auth', function () {
                    return 'Uploader';
                });
                /*app()->bind('play_role', function () {
                    return 'Uploader';
                });*/
            }
            elseif (in_array($role_staff, $server)) {
                app()->bind('play_auth', function () {
                    return 'Staff';
                });
                /*app()->bind('play_role', function () {
                    return 'Staff';
                });*/
            }
            else  {
                app()->bind('play_auth', function () {
                    return 'Student';
                });
                /*app()->bind('play_role', function () {
                    return 'Student';
                });*/
            }

            return $next($request);
        }

    }
}
