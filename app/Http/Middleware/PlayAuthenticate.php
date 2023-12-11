<?php

namespace App\Http\Middleware;

use App\AdminHandler;
use App\Services\AuthHandler;
use App\Services\Daisy\DaisyAPI;
use App\System;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $system = (new AuthHandler())->authorize();
        // If system is running locally
        if ($system->global->app_env == 'local') {
            $this->setLocalBindings();
            $adminhandler = AdminHandler::where('Shib_Session_ID', '9999')->first();
            $this->setShibbolethBindings(null, $system, $adminhandler);
            return $next($request);
        }

        if (!$this->validateAuthorizationParameter($system)) {
            return Redirect::guest(route('sulogin'));
        }

        // Settings for SU Shibboleth SSO
        $this->initializeSystem();

        // Set remote bindings
        $this->setRemoteBindings();
        $serverEntitlements = $this->getServerEntitlements($system->global->authorization_parameter);
        $adminhandler = AdminHandler::where('Shib_Session_ID', $request->server('Shib_Session_ID'))->first();
        $this->setShibbolethBindings($serverEntitlements, $system, $adminhandler);

        return $next($request);
    }

    protected function setLocalBindings()
    {
        app()->bind('play_user', function () {
            return 'Developer';
        });

        app()->bind('play_auth', function () {
            return 'Administrator';
        });

        app()->bind('play_email', function () {
            return 'developer@dsv.su.se';
        });
    }

    protected function setRemoteBindings()
    {
        app()->bind('play_user', function () {
            return $_SERVER['displayName'];
        });

        app()->bind('play_username', function() {
            return substr($_SERVER['REMOTE_USER'], 0, strpos($_SERVER['REMOTE_USER'], "@"));
        });

        app()->bind('play_email', function() {
            return $_SERVER['mail'];
        });
    }

    protected function initializeSystem()
    {
        if (!System::find(1)) {
            app()->make('init')->check_system();
        }
    }

    protected function validateAuthorizationParameter($system)
    {
        if (!isset($_SERVER[$system->global->authorization_parameter])) {
            abort(511);
            return false;
        }

        return true;
    }

    protected function getServerEntitlements($authParam)
    {
        return explode(";", $_SERVER[$authParam]);
    }

    protected function setShibbolethBindings($serverEntitlements, $system, $adminhandler)
    {
        // Roles
        $role_admin = $system->global->admin;
        $role_uploader = $system->global->uploader;
        $role_staff = $system->global->staff;
        $server = $serverEntitlements;

        if($server) {

            // Get Shibboleth entitlements
            if (!isset($_SERVER[$system->global->authorization_parameter])) {
                return redirect()->guest(route('sulogin'))->abort(511);
            }

            // Get user DaisyID
            $daisy = new DaisyAPI();
            $daisyPersonID = $daisy->getDaisyPersonId(substr($_SERVER['REMOTE_USER'], 0, strpos($_SERVER['REMOTE_USER'], "@")));

            // Determine user role
            $playAuth = $playRole = '';

            if (in_array($role_admin, $server)) {
                $playAuth = 'Administrator';
                $playRole = $this->handleAdminRole($adminhandler);
            } elseif (in_array($role_staff, $server)) {
                $playAuth = 'Staff';
                $playRole = $this->handleStaffRole($daisy, $daisyPersonID, $role_uploader, $server);
            } else {
                $playAuth = 'Student';
                $playRole = in_array($role_uploader, $server) ? 'Uploader' : 'Student';
            }

            // Bind values to the container
            app()->bind('play_auth', fn() => $playAuth);
            app()->bind('play_role', fn() => $playRole);

        } else {

            $defaultRole = 'Administrator';
            $defaultUsername = 'dsv-dev';

            if ($adminhandler && $adminhandler->override) {
                $roleBindings = [
                    'Courseadmin' => [
                        'custom' => false,
                        'user' => 'CourseAdmin',
                        'username' => 'gwett',
                    ],
                    'Student1' => [
                        'user' => 'Student 1',
                        'username' => 'stud1111',
                    ],
                    'Student2' => [
                        'user' => 'Student 2',
                        'username' => 'stud2222',
                    ],
                    'Student3' => [
                        'user' => 'Student 3',
                        'username' => 'stud3333',
                    ],
                    'CourseadminCustom' => [
                        'custom' => true,
                    ],
                ];

                $role = $adminhandler->role;

                if (isset($roleBindings[$role])) {
                    $binding = $roleBindings[$role];

                    app()->bind('play_role', function () use ($adminhandler, $role) {
                        return $role;
                    });

                    app()->bind('play_user', function () use ($binding) {
                        return $binding['user'] ?? '';
                    });

                    app()->bind('play_username', function () use ($binding) {
                        return $binding['username'] ?? '';
                    });

                    if ($binding['custom'] ?? false) {
                        app()->bind('play_user', function () use ($adminhandler) {
                            return $adminhandler->user;
                        });

                        app()->bind('play_username', function () use ($adminhandler) {
                            return $adminhandler->username;
                        });
                    }
                } else {
                    app()->bind('play_role', function () use ($adminhandler) {
                        return $adminhandler->role;
                    });

                    app()->bind('play_username', function () {
                        return 'dsv-dev';
                    });
                }
            } else {
                app()->bind('play_role', function () {
                    return 'Administrator';
                });

                app()->bind('play_username', function () {
                    return 'dsv-dev';
                });
            }
        }

        return true;
    }

    protected function handleAdminRole($adminHandler)
    {
        if ($adminHandler) {
            if ($adminHandler->override) {
                return $this->handleAdminOverride($adminHandler);
            }

            return $adminHandler->role;
        }

        return 'Administrator';
    }

    protected function handleAdminOverride($adminHandler)
    {
        if($adminHandler->custom) {
            //Impersonate user
            app()->bind('play_user', fn() => $adminHandler->user);
            app()->bind('play_username', fn() => $adminHandler->username);
        } else {
            //Static TestUsers
            switch($adminHandler->role) {
                case('Courseadmin'):
                    app()->bind('play_user', fn() => 'CourseAdmin');
                    app()->bind('play_username', fn() => 'gwett');
                    break;
                case('Student1'):
                    app()->bind('play_user', fn() => 'Student 1');
                    app()->bind('play_username', fn() => 'stud1111');
                    break;
                case('Student2'):
                    app()->bind('play_user', fn() => 'Student 2');
                    app()->bind('play_username', fn() => 'stud2222');
                    break;
                case('Student3'):
                    app()->bind('play_user', fn() => 'Student 3');
                    app()->bind('play_username', fn() => 'stud3333');
                    break;
            }
        }
        return $adminHandler->role;
    }

    protected function handleStaffRole($daisy, $daisyPersonID, $roleUploader, $server)
    {
        if ($daisy->checkCourseAdmin($daisyPersonID)) {
            return 'Courseadmin';
        } elseif (in_array($roleUploader, $server)) {
            return 'Uploader';
        }
        return 'Staff';
    }

}
