<?php

namespace App\Http\Middleware;

use App\Services\Daisy\CheckDaisyApi;
use Closure;
use Illuminate\Http\Request;

class StatusDaisy
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
        $daisy = new CheckDaisyApi();
        $check = $daisy->call();
        if($check['database'] == true) {
            app()->bind('daisy_db_status', function() {
                return 'on';
            });
        }
        else {
            app()->bind('daisy_db_status', function() {
                return 'off';
            });
        }
        if($check['ok'] == true) {
            app()->bind('daisy_ok_status', function() {
                return 'on';
            });
        }
        else {
            app()->bind('daisy_ok_status', function() {
                return 'off';
            });
        }
        return $next($request);
    }
}
