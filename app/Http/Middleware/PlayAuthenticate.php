<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
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
            app()->bind('play_role', function() {
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
            $role_admin = 'urn:mace:swami.se:gmai:dsv-user:play-admin';
            $role_uploader = 'urn:mace:swami.se:gmai:dsv-user:play-uploader';
            $role_staff = 'urn:mace:swami.se:gmai:dsv-user:staff';
            foreach($server as $entitlement) {
                if($entitlement == $role_admin) {
                    app()->bind('play_role', function () {
                        return 'Administrator';
                    });
                }
                elseif($entitlement == $role_uploader) {
                    app()->bind('play_role', function() {
                        return 'Uploader';
                    });
                }
                elseif($entitlement == $role_staff) {
                    app()->bind('play_role', function() {
                        return 'Staff';
                    });
                }
                else {
                    app()->bind('play_role', function() {
                        return 'Student';
                    });
                }
            }

            return $next($request);
        }

    }
}
