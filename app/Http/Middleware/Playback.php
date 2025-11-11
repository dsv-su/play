<?php

namespace App\Http\Middleware;

use App\Models\Video;
use App\Models\VideoPermission;
use App\Services\AuthHandler;
use App\Services\Course\CourseAdminList;
use App\Services\Course\CourseSettingPublic;
use App\Services\Course\CourseSettingVisibility;
use App\Services\Staff\AdminCheck;
use App\Services\Staff\StaffCheck;
use Closure;
use Illuminate\Http\Request;

class Playback
{
    public function __construct(
        private AuthHandler $authHandler,
        private AdminCheck $adminCheck,
        private StaffCheck $staffCheck,
        private \App\Services\Course\CourseAdmin $courseAdmin,
        private CourseAdminList $courseAdminList,
        private CourseSettingPublic $courseSettingPublic,
        private CourseSettingVisibility $courseSettingVisibility,
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Initialize/authorize session context
        $this->authHandler->authorize();

        $video = $this->resolveVideo($request);
        if (!$video) {
            return redirect()->route('home');
        }

        // Ensure relationships for checks are available
        $video->loadMissing(['courses:id', 'individualPermissions']);

        $remoteUser = $request->server('REMOTE_USER');
        $username   = $remoteUser ? strtok($remoteUser, '@') : null;

        // Anonymous flow (no Shibboleth/SSO)
        if (!$remoteUser) {
            // Allow everything locally to not hinder dev
            if (config('app.env') === 'local') {
                return $next($request);
            }

            // Otherwise only allow if anonymous access rules pass
            if ($this->anonymousCanView($video)) {
                return $next($request);
            }

            return redirect()->route('home');
        }

        // Authenticated flow (Shibboleth)
        if ($this->adminCheck->check()) {
            return $next($request);
        }

        if ($this->userCanView($video, $remoteUser, $username)) {
            return $next($request);
        }

        return redirect()->route('home');
    }

    /**
     * Try to find the Video model from common places.
     */
    private function resolveVideo(Request $request): ?Video
    {
        $id = $request->input('p')
            //Fallback: last path segment as we are encoding IDs in the URL
            ?? basename($request->path());

        if (!$id) {
            return null;
        }

        return Video::query()->find($id);
    }

    /**
     * Rules for anonymous viewers.
     */
    private function anonymousCanView(Video $video): bool
    {
        // Unlisted always allowed
        if ($video->unlisted) {
            return true;
        }

        // “Public video” via VideoPermission + default visibility (+ optional course visibility)
        $perm = VideoPermission::where('video_id', $video->id)->first(); // no 404s in middleware
        if ($perm && (int) $perm->permission_id === 4) {
            if ($video->visibility) {
                // If no courses -> allow
                if (!$video->courses()->exists()) {
                    return true;
                }
                // If courses exist, fall back to course visibility rules
                if ($this->courseSettingVisibility->check($video)) {
                    return true;
                }
            }
        }

        // Course-level “public” overrides when presentation visibility is “default”
        if ($this->courseSettingPublic->check($video) == 4) {
            if ($this->courseSettingVisibility->check($video)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Rules for authenticated users (via Shibboleth).
     */
    private function userCanView(Video $video, string $remoteUser, ?string $username): bool
    {
        $hasCourse = $video->courses()->exists();

        if ($hasCourse) {
            // Staff + CourseAdmin
            if ($this->staffCheck->check() && $this->courseAdmin->check($remoteUser, $video)) {
                return true;
            }

            // Explicit course admin list
            if ($this->courseAdminList->check($remoteUser, $video)) {
                return true;
            }

            // Individual presentation permissions
            if ($username && $video->ipermissions?->contains(
                    fn ($p) => $p->username === $username
                        && in_array($p->permission, ['read', 'edit', 'delete'], true)
                )) {
                return true;
            }

            // Presentation-level visibility/unlisted
            if ($video->visibility || $video->unlisted) {
                return true;
            }

            return false;
        }

        // Not associated to a course
        if ($video->visibility) {
            return true;
        }

        if ($username && $video->ipermissions?->contains(
                fn ($p) => $p->username === $username
                    && in_array($p->permission, ['read', 'edit', 'delete'], true)
            )) {
            return true;
        }

        if ($video->unlisted) {
            return true;
        }

        return false;
    }
}
