<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


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
        $authHandler = new AuthHandler();
        $system = $authHandler->authorize();

        $authParam = $system->global->authorization_parameter;
        $authString = $system->global->authorization;
        $auth = explode(";", $authString);

        if (!$request->server('REMOTE_USER')) {
            if ($system->global->app_env == 'local') {
                return $next($request);
            } else {
                return Redirect::guest(route('sulogin'));
            }
        } else {
            $serverEntitlements = $this->getServerEntitlements($authParam);

            if (!$this->checkEntitlementMatch($serverEntitlements, $auth)) {
                abort(401);
            }
        }

        return $next($request);
    }

    protected function getServerEntitlements($authParam)
    {
        if (isset($_SERVER[$authParam])) {
            return explode(";", $_SERVER[$authParam]);
        }

        return [];
    }

    protected function checkEntitlementMatch($serverEntitlements, $auth)
    {
        foreach ($serverEntitlements as $serverEntitlement) {
            if (in_array($serverEntitlement, $auth)) {
                return true;
            }
        }

        return false;
    }
}
