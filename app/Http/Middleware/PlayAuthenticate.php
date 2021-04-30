<?php

namespace App\Http\Middleware;

use App\AdminHandler;
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

            app()->bind('play_auth', function () {
                return 'Administrator';
            });

            if($adminhandler = AdminHandler::where('Shib_Session_ID', '9999')->first()) {
                if($adminhandler->override == true) {
                    //Override
                    if($adminhandler->role == 'Student1') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_username', function() {
                            return 'stud1111'; //TestStudent username 1
                        });
                    }
                    elseif ($adminhandler->role == 'Student2') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_username', function() {
                            return 'stud2222'; //TestStudent username 2
                        });
                    }
                    elseif ($adminhandler->role == 'Student3') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_username', function() {
                            return 'stud3333'; //TestStudent username 3
                        });
                    }
                    else {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_username', function() {
                            return 'dsv-dev';
                        });
                    }

                }
                else{
                    app()->bind('play_role', function () {
                        return 'Administrator';
                    });
                    app()->bind('play_username', function() {
                        return 'dsv-dev';
                    });
                }
            } else {
                app()->bind('play_role', function () {
                    return 'Administrator';
                });
                app()->bind('play_username', function() {
                    return 'dsv-dev';
                });
            }

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
                if($adminhandler = AdminHandler::where('Shib_Session_ID', $request->server('Shib_Session_ID'))->first()) {
                    if($adminhandler->override == true) {
                        //Override
                        if($adminhandler->role == 'Student1') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_username', function() {
                                return 'stud1111'; //TestStudent username 1
                            });
                        }
                        elseif ($adminhandler->role == 'Student2') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_username', function() {
                                return 'stud2222'; //TestStudent username 2
                            });
                        }
                        elseif ($adminhandler->role == 'Student3') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_username', function() {
                                return 'stud3333'; //TestStudent username 3
                            });
                        }
                        else {
                            app()->bind('play_role', function () use ($adminhandler) {
                                return $adminhandler->role;
                            });
                        }
                    }
                        else{
                            app()->bind('play_role', function () {
                                return 'Administrator';
                            });
                        }
                } else {
                    app()->bind('play_role', function () {
                        return 'Administrator';
                    });
                }

            }
            elseif (in_array($role_uploader, $server)) {
                app()->bind('play_auth', function () {
                    return 'Uploader';
                });
                app()->bind('play_role', function () {
                    return 'Uploader';
                });
            }
            elseif (in_array($role_staff, $server)) {
                app()->bind('play_auth', function () {
                    return 'Staff';
                });
                app()->bind('play_role', function () {
                    return 'Staff';
                });
            }
            else  {
                app()->bind('play_auth', function () {
                    return 'Student';
                });
                app()->bind('play_role', function () {
                    return 'Student';
                });
            }

            return $next($request);
        }

    }
}
