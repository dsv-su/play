<?php

namespace App\Http\Middleware;

use App\Models\Video;
use App\Services\AuthHandler;
use App\Services\VideoEditPermission;
use Closure;
use Illuminate\Http\Request;

class CheckEditPermission
{
    public function handle(Request $request, Closure $next)
    {
        // Ensure auth context is established
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

        // Resolve the video target
        $video = $this->resolveVideo($request);
        if (!$video) {
            // No valid target -> treat as unauthorized to avoid leaking info
            return redirect()->route('home');
        }

        $editableIds = app(VideoEditPermission::class)->editableVideoIds(
            $video->newCollection([$video]), $username, $role
        );

        return $editableIds ? $next($request) : redirect()->route('home');
    }

    /**
     * Try to resolve a Video model from request input or URL.
     * Accepts:
     *  - query param "p"
     *  - last URI segment (numeric)
     */
    protected function resolveVideo(Request $request): ?Video
    {
        // Nested routes such as /edit/{video}/stream/upload do not end in the video ID.
        $routeVideo = $request->route('video');
        if ($routeVideo instanceof Video) {
            return $routeVideo;
        }

        $id = $routeVideo ?: $request->input('p');

        // Fallback: last path segment if it looks like a UUID
        if (!$id) {
            $lastSegment = (string) str($request->path())->explode('/')->last();

            // Validate UUID format
            if (preg_match(
                '/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[1-5][0-9a-fA-F]{3}\b-[89abAB][0-9a-fA-F]{3}\b-[0-9a-fA-F]{12}$/',
                $lastSegment
            )) {
                $id = $lastSegment;
            }
        }

        // Final safety: only attempt lookup if it matches UUID format
        if ($id && preg_match(
                '/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[1-5][0-9a-fA-F]{3}\b-[89abAB][0-9a-fA-F]{3}\b-[0-9a-fA-F]{12}$/',
                $id
            )) {
            return Video::find($id);
        }

        return null;
    }

}

