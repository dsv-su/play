<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\Filters\VisibilityFilter;
use App\Services\TicketHandler\TicketPermissionHandler;
use App\Models\Video;
use App\Models\VideoCourse;
use App\Models\VideoStat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MultiplayerController extends Controller
{
    public function __construct()
    {
        //Exceptions for 'Multiplayer', 'Presentation' and 'Playlist' for external permission setting
        $this->middleware(['entitlements', 'playauth'])->except(['multiplayer', 'multiplayer_ce', 'presentation', 'playlist']);
        //Playback middleware checks hidden presentations
        $this->middleware('playback')->except(['playlist', 'playCourse','presentation']);
    }

    /**
     * @return RedirectResponse
     */
    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(503);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    public function playCourse($courseid): RedirectResponse
    {
        $visibility = app(VisibilityFilter::class);
        $video_id = $visibility->filter(Video::whereHas('video_course.course', function ($query) use ($courseid) {
            $query->where('course_id', $courseid);
        })->where('visibility', 1)->orderBy('creation')->get())->first()->id;

        return Redirect::to('multiplayer?p=' . $video_id . '&l=' . $courseid);
    }

    public function player(Video $video): RedirectResponse
    {
        // Fetch the associated course_id (if any)
        $courseId = VideoCourse::where('video_id', $video->getKey())->value('course_id');

        // Build query parameters for the player
        $query = ['p' => $video->getKey()];
        if ($courseId) {
            $query['l'] = $courseId;
        }

        return redirect()->route('multiplayer.index', $query);
    }


    public function presentation(string $id): JsonResponse
    {
        // Eager-load
        $video = Video::with([
            'streams' => fn ($q) => $q->where('hidden', false),
            'streams.resolutions',
        ])->findOrFail($id);

        // Issue ticket for video
        $handler = app(TicketPermissionHandler::class);      // constructor gets Entitlement via container
        $token   = $handler->issue($video, $entitlements ?? []);

        // Base presentation payload
        $presentation = [
            'id'    => $video->id,
            'title' => $video->title,
            'thumb' => $video->thumb,
        ];

        // Build sources
        $sources = [];
        foreach ($video->streams as $stream) {
            // Reset per stream
            $videoSources = [];

            foreach ($stream->resolutions as $resolution) {
                $videoSources[$resolution->resolution] = $this->base_uri().'/'.$video->id.'/'.$resolution->filename;
            }

            $sources[$stream->name] = [
                'video'     => $videoSources,
                'poster'    => $this->base_uri().'/'.$video->id.'/'.$stream->poster,
                'playAudio' => (bool) $stream->audio,
            ];
        }

        if (!empty($sources)) {
            $presentation['sources'] = $sources;
        }

        // Subtitles
        if (!empty($video->subtitles)) {
            $subtitleArray = is_array($video->subtitles)
                ? $video->subtitles
                : (json_decode($video->subtitles, true) ?: []);

            if (!empty($subtitleArray)) {
                // Map keys to absolute URLs
                $presentation['subtitles'] = collect($subtitleArray)
                    ->mapWithKeys(fn ($path, $key) => [$key => $this->base_uri().'/'.$video->id.'/'.$path])
                    ->all();
            }
        }

        // Add valid token
        $presentation['token'] = $token;

        // Update stats (atomic)
        $stat = VideoStat::firstOrCreate(
            ['video_id' => $video->id],
            ['playback' => 0]
        );
        $stat->increment('playback');

        //Record metrics for presentation
        metric('presentation')
            ->measurable($video)
            ->with(['vid' => $video->id])
            ->category('clicks')
            ->record();
        //Record metrics overall
        metric('playback')
            ->category('clicks')
            ->record();

        return response()->json($presentation);

    }

    public function playlist(int $id): JsonResponse
    {
        // 1) Load the course
        $course = Course::findOrFail($id);

        // 2) Pull video IDs in desired order (latest first).
        $videoIds = VideoCourse::where('course_id', $id)
            ->latest() // relies on created_at in pivot; adjust if you have a different column
            ->pluck('video_id')
            ->all();

        // if no videos
        if (empty($videoIds)) {
            return response()->json([
                'title' => sprintf(
                    '%s %s%s presentations',
                    $course->designation,
                    $course->semester,
                    $course->year
                ),
                'items' => [],
            ]);
        }

        // 3) Base query
        $query = Video::query()
            ->whereIn('id', $videoIds)
            ->where('visibility', 1)
            ->select(['id', 'title', 'title_en', 'thumb', 'visibility', 'description']); // trim payload

        // 4) Apply visibilityfilter
        $visibility = app(VisibilityFilter::class);
        $visibleVideos = $visibility->filter($query->get());

        // 5) Preserve the original order from $videoIds
        $orderIndex = array_flip($videoIds);
        $ordered = $visibleVideos->sortBy(fn ($v) => $orderIndex[$v->id])->values();

        // 6) Build response payload
        $payload = [
            'title' => sprintf(
                '%s %s%s presentations',
                $course->designation,
                $course->semester,
                $course->year
            ),
            'items' => $ordered->map(fn ($v) => [
                'id'    => $v->id,
                'title' => $v->title,
                'title_en' => $v->title_en,
                'thumb' => $v->thumb,
                'link' => $v->link,
                'description' => $v->description,
            ])->all(),
        ];

        // 7) Return  JSON (pretty-print)
        return response()->json($payload, 200, [], JSON_PRETTY_PRINT );
    }

    public function multiplayer()
    {
        //deprecated
        return view('player.index');
    }

    public function multiplayer_ce(Request $request): View|RedirectResponse
    {
        // Validate query params
        $data = $request->validate([
            'p' => ['required', 'string'],   // presentation id
            'l' => ['nullable', 'integer'],   // playlist id
            's' => ['nullable', 'string'],   // default subtitle
        ]);

        // Build view data
        $viewData = [
            'presentation' => $data['p'],
        ];

        if (!empty($data['l'])) {
            $viewData['playlist'] = $data['l'];
        }

        if (!empty($data['s'])) {
            $viewData['s'] = $data['s'];
        }


        return view('player.index-ce', $viewData);
    }
}
