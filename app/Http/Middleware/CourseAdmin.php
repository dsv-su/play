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
        if( ! in_array(app()->make('play_role'),['Courseadmin', 'Administrator'])) {
            return redirect('/');
        }
        return $next($request);
    }
}
