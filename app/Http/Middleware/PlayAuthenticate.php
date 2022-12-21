<?php

namespace App\Http\Middleware;

use App\AdminHandler;
use App\Services\AuthHandler;
use App\Services\Daisy\DaisyAPI;
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

        //If system is running local
        if($system->global->app_env == 'local') {
            app()->bind('play_user', function() {
                return 'Developer';
            });

            app()->bind('play_auth', function () {
                return 'Administrator';
            });

            app()->bind('play_email', function() {
                return 'developer@dsv.su.se';
            });
            //Enable role emulation
            if($adminhandler = AdminHandler::where('Shib_Session_ID', '9999')->first()) {
                if($adminhandler->override) {
                    //Override
                    if($adminhandler->role == 'Courseadmin' && $adminhandler->custom == false) {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_user', function() {
                            return 'CourseAdmin'; //Courseadmin
                        });
                        app()->bind('play_username', function() {
                            return 'gwett'; //Courseadmin
                        });
                    }
                    elseif($adminhandler->role == 'Student1') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_user', function() {
                            return 'Student 1'; //Teststudent 1
                        });
                        app()->bind('play_username', function() {
                            return 'stud1111'; //TestStudent username 1
                        });
                    }
                    elseif ($adminhandler->role == 'Student2') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_user', function() {
                            return 'Student 2'; //Teststudent 2
                        });
                        app()->bind('play_username', function() {
                            return 'stud2222'; //TestStudent username 2
                        });
                    }
                    elseif ($adminhandler->role == 'Student3') {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_user', function() {
                            return 'Student 3'; //Teststudent 3
                        });
                        app()->bind('play_username', function() {
                            return 'stud3333'; //TestStudent username 3
                        });
                    }
                    elseif ($adminhandler->role == 'Courseadmin' && $adminhandler->custom == true) {
                        app()->bind('play_role', function () use($adminhandler){
                            return $adminhandler->role;
                        });
                        app()->bind('play_user', function() use($adminhandler){
                            return $adminhandler->user;
                        });
                        app()->bind('play_username', function() use($adminhandler){
                            return $adminhandler->username;
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
        //Settings for SU Shibboleth SSO
        else {
            if (!System::find(1)) {
                //Initiate system
                app()->make('init')->check_system();
            }

            app()->bind('play_user', function() {
                return $_SERVER['displayName'];
            });
            app()->bind('play_username', function() {
                return substr($_SERVER['REMOTE_USER'], 0, strpos($_SERVER['REMOTE_USER'], "@"));
            });
            app()->bind('play_email', function() {
                return $_SERVER['mail'];
            });

            // Get Shibboleth entitlements
            if(isset($_SERVER[$system->global->authorization_parameter])) {
                $server = explode(";", $_SERVER[$system->global->authorization_parameter]);
            } else {
                return redirect()->guest(route('sulogin'));
                abort(511);
            }


            // Roles
            $role_admin = $system->global->admin;
            $role_uploader = $system->global->uploader;
            $role_staff = $system->global->staff;

            $daisy = new DaisyAPI();
            //Get user DaisyID
            $daisyPersonID = $daisy->getDaisyPersonId(substr($_SERVER['REMOTE_USER'], 0, strpos($_SERVER['REMOTE_USER'], "@")));

            // Assign role to user
            //If user is system administrator
            if(in_array($role_admin, $server)) {
                app()->bind('play_auth', function () {
                    return 'Administrator';
                });
                //Enable role emulation
                if($adminhandler = AdminHandler::where('Shib_Session_ID', $request->server('Shib_Session_ID'))->first()) {
                    if($adminhandler->override) {
                        //Override
                        if($adminhandler->role == 'Courseadmin') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_user', function() {
                                return 'CourseAdmin'; //Courseadmin
                            });
                            app()->bind('play_username', function() {
                                return 'andan'; //Courseadmin
                            });
                        }
                        elseif($adminhandler->role == 'Student1') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_user', function() {
                                return 'Student 1'; //Teststudent 1
                            });
                            app()->bind('play_username', function() {
                                return 'stud1111'; //TestStudent username 1
                            });
                        }
                        elseif ($adminhandler->role == 'Student2') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_user', function() {
                                return 'Student 2'; //Teststudent 2
                            });
                            app()->bind('play_username', function() {
                                return 'stud2222'; //TestStudent username 2
                            });
                        }
                        elseif ($adminhandler->role == 'Student3') {
                            app()->bind('play_role', function () use($adminhandler){
                                return $adminhandler->role;
                            });
                            app()->bind('play_user', function() {
                                return 'Student 3'; //Teststudent 3
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
                    //Default fallback while enabled
                        else{
                            app()->bind('play_role', function () {
                                return 'Administrator';
                            });
                        }
                }
                //Default fallback while disabled
                else {
                    app()->bind('play_role', function () {
                        return 'Administrator';
                    });
                }

            }

            //If user is not system administrator -> check role

            //User is Course Admin
            elseif (in_array($role_staff, $server)) {
                if($daisy->checkCourseAdmin($daisyPersonID)) {
                    app()->bind('play_auth', function () {
                        return 'Courseadmin';
                    });
                    app()->bind('play_role', function () {
                        return 'Courseadmin';
                    });
                }
                //User is Uploader
                elseif (in_array($role_uploader, $server)) {
                    app()->bind('play_auth', function () {
                        return 'Staff';
                    });
                    app()->bind('play_role', function () {
                        return 'Uploader';
                    });
                }
                else {
                    //User is Staff
                    app()->bind('play_auth', function () {
                        return 'Staff';
                    });
                    app()->bind('play_role', function () {
                        return 'Staff';
                    });
                }
            }

            //User is Student
            else  {
                    //Check if student is uploader
                    if (in_array($role_uploader, $server)) {
                        app()->bind('play_auth', function () {
                            return 'Student';
                        });
                        app()->bind('play_role', function () {
                            return 'Uploader';
                        });
                    } else {
                        app()->bind('play_auth', function () {
                            return 'Student';
                        });
                        app()->bind('play_role', function () {
                            return 'Student';
                        });
                    }
            }

            return $next($request);
        }

    }
}
