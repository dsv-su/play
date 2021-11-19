<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CourseAdmin
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
        if(app()->make('play_role') != 'Courseadmin') {
            return redirect('/');
        }
        return $next($request);
    }
}
