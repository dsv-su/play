<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminManage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(app()->make('play_role') != 'Administrator') {
            return redirect()->route('user_manage');
        } else {
            return $next($request);
        }
    }
}
