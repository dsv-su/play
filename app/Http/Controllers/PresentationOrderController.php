<?php

namespace App\Http\Controllers;

use App\Models\CourseadminPermission;
use App\Models\Course;
use App\Models\IndividualPermission;
use App\Models\Presenter;
use App\Services\MyPresentation\MyPresentationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentationOrderController extends Controller
{
    public function show(MyPresentationsService $myPresentations)
    {
        $username = (string) app('play_username');
        $playRole = (string) app('play_role');
        $presenter = Presenter::query()->where('username', $username)->first();

        $presenterVideoIds = $presenter
            ? $presenter->videos()->select('videos.id')
            : null;

        $profileStats = [
            'presentations' => $presenter ? (clone $presenterVideoIds)->count() : 0,
            'published' => $presenter
                ? (clone $presenterVideoIds)->where('visibility', true)->where('unlisted', false)->count()
                : 0,
            'unlisted' => $presenter
                ? (clone $presenterVideoIds)->where('unlisted', true)->count()
                : 0,
            'courses' => $presenter
                ? DB::table('video_courses')
                    ->whereIn('video_id', (clone $presenterVideoIds)->select('videos.id'))
                    ->distinct()
                    ->count('course_id')
                : 0,
            'playbacks' => $presenter
                ? (int) DB::table('video_stats')
                    ->whereIn('video_id', (clone $presenterVideoIds)->select('videos.id'))
                    ->sum('playback')
                : 0,
            'downloads' => $presenter
                ? (int) DB::table('video_stats')
                    ->whereIn('video_id', (clone $presenterVideoIds)->select('videos.id'))
                    ->sum('download')
                : 0,
        ];

        $courseadminPermissions = CourseadminPermission::query()
            ->with('video:id,title')
            ->where('username', $username)
            ->orderByDesc('updated_at')
            ->get();

        $individualPermissions = IndividualPermission::query()
            ->with('video:id,title')
            ->where('username', $username)
            ->orderByDesc('updated_at')
            ->get();

        // Use the same cached, role-aware Daisy lookup as "My presentations".
        // It returns an empty array when the user has no courses or Daisy is unavailable.
        $daisyCourseIds = collect($myPresentations->resolveCourseIds(
            $username,
            (string) app('play_auth'),
            $playRole
        ))->filter()->unique()->values();

        $daisyCourses = Course::query()
            ->whereIn('id', $daisyCourseIds)
            ->get(['id', 'designation', 'semester', 'year']);

        $daisySemesters = $daisyCourses
            ->map(fn (Course $course) => trim((string) $course->semester . ' ' . (string) $course->year))
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        $daisyStats = [
            'courses' => $daisyCourseIds->count(),
            'designations' => $daisyCourses->pluck('designation')->filter()->unique()->count(),
            'semesters' => $daisySemesters->count(),
            'semester_labels' => $daisySemesters->take(4),
        ];

        $componentLabels = [
            'home.newpresentations' => 'New on Play Presentations',
            'home.mypresentations' => 'My Presentations',
            'home.studypresentations' => 'Study Presentations',
            'home.next-ilearn' => 'NextIlearn Presentations'
        ];

        return view('cookie.profile', compact(
            'componentLabels',
            'profileStats',
            'daisyStats',
            'courseadminPermissions',
            'individualPermissions'
        ));
    }

    public function store(Request $request)
    {
        // Allowed components (same as in your Blade)
        $defaultOrder = ['home.newpresentations', 'home.mypresentations', 'home.studypresentations', 'home.next-ilearn'];

        // Validate and sanitize input
        $data = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'string',
        ]);

        // Keep only allowed components and preserve order
        $order = collect($data['order'])
            ->filter(fn ($c) => in_array($c, $defaultOrder, true))
            ->values()
            ->all();

        // Ensure all defaults appear, same logic as in your Blade
        $order = array_values(array_unique(array_merge($order, $defaultOrder)));

        // Encode as JSON for the cookie
        $json = json_encode($order, JSON_THROW_ON_ERROR);

        // Cookie lifetime (e.g. 30 days)
        $minutes = 60 * 24 * 30;

        // JSON
        return response()->json([
            'status' => 'ok',
            'order'  => $order,
        ])->cookie('presentation_order', $json, $minutes);
    }
}
