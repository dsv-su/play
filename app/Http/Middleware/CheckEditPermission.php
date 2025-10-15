<?php

namespace App\Http\Middleware;

use App\Models\CourseadminPermission;
use App\Models\CoursesettingsUsers;
use App\Models\Video;
use App\Services\AuthHandler;
use App\Services\Course\CourseAdmin;
use Closure;
use Illuminate\Http\Request;

class CheckEditPermission
{
    public function handle(Request $request, Closure $next)
    {
        // Ensure auth context is established (kept from your code)
        $system = (new AuthHandler())->authorize();

        // If not SSO-authenticated, allow in local env; otherwise send to login
        if (!$request->server('REMOTE_USER')) {
            $isLocal = app()->environment('local')
                || (isset($system->global->app_env) && $system->global->app_env === 'local');

            return $isLocal ? $next($request) : redirect()->guest(route('sulogin'));
        }

        // Cache frequently used values
        $username = (string) app('play_username');
        $role     = (string) app('play_role');

        // Resolve the video target robustly
        $video = $this->resolveVideo($request);
        if (!$video) {
            // No valid target -> treat as unauthorized to avoid leaking info
            return redirect()->route('home');
        }

        // 1) Global admin
        if ($role === 'Administrator') {
            return $next($request);
        }

        // 2) Explicit per-video permission (courseadmin_permissions table)
        $hasDirectPermission = CourseadminPermission::query()
            ->where('username', $username)
            ->where('video_id', $video->id)
            ->whereIn('permission', ['edit', 'delete'])
            ->exists();

        if ($hasDirectPermission) {
            return $next($request);
        }

        // 3) Courseadmin role, validated via CourseAdmin service
        if ($role === 'Courseadmin') {
            $courseAdmin = app(CourseAdmin::class); // DI-friendly
            if ($courseAdmin->check($username.'@su.se', $video)) {
                return $next($request);
            }
        }

        // 4) Course-scoped permissions (CoursesettingsUsers)
        $courseIds = collect($video->courses())->pluck('id')->filter()->unique()->all();

        if (!empty($courseIds)) {
            $hasCoursePermission = CoursesettingsUsers::query()
                ->whereIn('course_id', $courseIds)
                ->where('username', $username)
                ->whereIn('permission', ['edit', 'delete'])
                ->exists();

            if ($hasCoursePermission) {
                return $next($request);
            }
        }

        // 5) Individual presentation permissions ($video->ipermissions)
        if (!empty($video->individualPermissions)) {
            $hasIndividualPermission = collect($video->individualPermissions)->contains(function ($perm) use ($username) {
                return ($perm->username ?? null) === $username
                    && in_array(($perm->permission ?? ''), ['edit', 'delete'], true);
            });

            if ($hasIndividualPermission) {
                return $next($request);
            }
        }

        // Fallback: not authorized
        return redirect()->route('home');
    }

    /**
     * Try to resolve a Video model from request input or URL.
     * Accepts:
     *  - query param "p"
     *  - last URI segment (numeric)
     */
    protected function resolveVideo(Request $request): ?Video
    {
        // Prefer explicit query parameter
        $id = $request->input('p');

        // Fallback: last path segment if numeric (avoid using full URI which may include query string)
        if (!$id) {
            $lastSegment = (string) str($request->path())->explode('/')->last();
            if (ctype_digit($lastSegment)) {
                $id = $lastSegment;
            }
        }

        // Final safety: only attempt integer IDs
        if ($id && ctype_digit((string) $id)) {
            return Video::find((int) $id);
        }

        return null;
    }
}

