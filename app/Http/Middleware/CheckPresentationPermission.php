<?php

namespace App\Http\Middleware;

use App\Models\CoursePermissions;
use App\Services\AuthHandler;
use App\Models\Video;
use App\Models\VideoPermission;
use Closure;
use Illuminate\Http\Request;

class CheckPresentationPermission
{
    /**
     * Handle an incoming request and check if the requested presentation
     * is public.
     */
    public function handle(Request $request, Closure $next)
    {
        /*$system = new AuthHandler();
        $system = $system->authorize();
        if ($request->is('presentation/*')) {
            $id = substr($request->path(), strrpos($request->path(), '/') + 1);
            $permission = VideoPermission::where('video_id', $id)->firstOrFail();
            $presentation = Video::find($id);

            if(!$request->server('REMOTE_USER')) {

                // Check the Presentationsetting
                if ($permission->permission_id == 4) {
                    //Presentation is public
                    return $next($request);
                }

                // Check default setting
                if($permission->permission_id != 1) {
                    if($system->global->app_env == 'local') {
                        return $next($request);
                    } else {
                        return redirect()->guest(route('sulogin'));
                    }
                }

                // Course settings
                //Coursesetting for each course
                if(count($presentation->courses())>=1 ) {
                    //If presentation is associated with one or several course
                    foreach($presentation->courses() as $course) {
                        if($coursepersmission = CoursePermissions::where('course_id', $course->id)->pluck('permission_id')->first()) {
                            if($coursepersmission != 4) {
                                if($system->global->app_env == 'local') {
                                    return $next($request);
                                } else {
                                    return redirect()->guest(route('sulogin'));
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            return redirect()->guest(route('sulogin'));
        }
        return $next($request);*/
        // Authorize via your existing handler
        $system = (new AuthHandler())->authorize();

        // Only guard presentation routes
        if (!$request->is('presentation/*')) {
            return redirect()->guest(route('sulogin'));
        }

        // Extract the video id from the path (last segment)
        $id = (string) substr($request->path(), strrpos($request->path(), '/') + 1);

        // Load the presentation + its courses
        $presentation = Video::with('courses')->find($id);
        if (!$presentation) {
            // If video not found, let downstream handle (404) or redirect; here we redirect to login
            return redirect()->guest(route('sulogin'));
        }

        // Presentation-level permission row (fail closed if missing)
        $permission = VideoPermission::where('video_id', $id)->first();
        if (!$permission) {
            return $this->redirectOrNext($system, $next, $request, $requireLogin = true);
        }

        // If user is unauthenticated via REMOTE_USER checks
        if (!$request->server('REMOTE_USER')) {
            // 1) Presentation setting: if public, allow
            if ((int) $permission->permission_id === 4) {
                return $next($request);
            }

            // 2) Default setting: if not default (=1), require login unless local
            if ((int) $permission->permission_id !== 1) {
                return $this->redirectOrNext($system, $next, $request, $requireLogin = true);
            }

            // 3) Course settings: if any related course is NOT public (id != 4), require login unless local
            $courses   = $presentation->courses; // Collection
            if ($courses->isNotEmpty()) {
                $courseIds = $courses->pluck('id');
                // [course_id => permission_id]
                $coursePerms = CoursePermissions::whereIn('course_id', $courseIds)
                    ->pluck('permission_id', 'course_id');

                // If any course is not public (i.e., id != 4), require login
                $anyNonPublic = $coursePerms->contains(fn ($pid) => (int) $pid !== 4);
                if ($anyNonPublic) {
                    return $this->redirectOrNext($system, $next, $request, $requireLogin = true);
                }
            }
        }

        // All checks passed (or user authenticated)
        return $next($request);
    }

    private function redirectOrNext($system, Closure $next, Request $request, bool $requireLogin)
    {
        if ($requireLogin && ($system->global->app_env ?? null) !== 'local') {
            return redirect()->guest(route('sulogin'));
        }
        return $next($request);
    }
}
