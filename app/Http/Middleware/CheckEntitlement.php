<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use Closure;
use Illuminate\Http\Request;


class CheckEntitlement
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
        $auth_param = $system->global->authorization_parameter;
        $authstring = $system->global->authorization; //For multiple entitlements
        //$entitlement = $system->global->authorization;
        $auth = explode(";", $authstring); //For multiple entitlements
        $match = false;
        if (!$request->server('REMOTE_USER')) {
            if ($system->global->app_env == 'local') {
                return $next($request);
            } else {
                return redirect()->guest(route('sulogin'));
            }
        } else {
            if (isset($_SERVER[$auth_param])) {
                $server_entitlements = explode(";", $_SERVER[$auth_param]);
                foreach ($server_entitlements as $server_entitlement) {
                    if (in_array($server_entitlement, $auth)) {
                        $match = true;
                    }
                }
            }
        }

        if (!$match) {
            abort(401);
        }

        return $next($request);
    }
}
