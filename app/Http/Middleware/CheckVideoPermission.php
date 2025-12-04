<?php

namespace App\Http\Middleware;

use App\Models\Video;
use App\Models\VideoPermission;
use App\Services\AuthHandler;
use App\Services\Course\CourseSettingPublic;
use Closure;
use Illuminate\Http\Request;

class CheckVideoPermission
{
    protected $system;

    public function __construct(
        private AuthHandler $authHandler,
        private CourseSettingPublic $courseSettingPublic,
    ) {}

    /**
     * Handle an incoming request and check if the requested presentation is public.
     */
    public function handle(Request $request, Closure $next)
    {
        //Authorize
        $this->system = $this->authHandler->authorize();

        $video = $this->resolveVideoFromRequest($request);
        if (!$video) {
            abort(404);
        }

        //If user is authenticated via SSO, let it pass
        if ($request->server('REMOTE_USER')) {
            return $next($request);
        }

        //Guest / anonymous flow
        $permissionId = VideoPermission::query()
            ->where('video_id', $video->id)
            ->value('permission_id'); // null-safe; avoids throwing in middleware

        //4 = public presentation
        if ((int) $permissionId === 4) {
            return $next($request);
        }

        //Non-default presentation setting (!= 1):
        //Allow in local, otherwise force SSO login
        if ((int) $permissionId !== 1) {
            return $this->localOrLogin($request, $next);
        }

        //Default presentation setting (== 1): fall back to course-level public
        if ($this->courseSettingPublic->check($video) == 4) {
            return $next($request);
        }

        //Check for ifram from nextIlearn
        if( isset($_SERVER['HTTP_SEC_FETCH_DEST']) && $_SERVER['HTTP_SEC_FETCH_DEST'] == 'iframe' ) {
            abort(450);
        }

        //Default + not public at course level
        return $this->localOrLogin($request, $next);
    }

    /**
     * Resolve Video from supported request shapes.
     */
    private function resolveVideoFromRequest(Request $request): ?Video
    {
        // primary: explicit `p` param
        $id = $request->input('p')
            //route model binding
            ?? $request->route('video')
            ?? $request->route('id');

        if (!$id) {
            return null;
        }

        return Video::query()->find($id);
    }

    /**
     * "Local, otherwise redirect to SSO login".
     */
    private function localOrLogin(Request $request, Closure $next)
    {
        if($this->system->global->app_env === 'local') {
            return $next($request);
        }

        return redirect()->guest(route('sulogin'));
    }
}
