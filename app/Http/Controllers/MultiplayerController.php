<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\Filters\VisibilityFilter;
use App\Services\TicketHandler\TicketPermissionHandler;
use App\Stream;
use App\StreamResolution;
use App\Video;
use App\VideoCourse;
use App\VideoStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class MultiplayerController extends Controller
{
    public function __construct()
    {
        //Exceptions for 'Multiplayer', 'Presentation' and 'Playlist' for external permission setting
        $this->middleware(['entitlements', 'playauth'])->except(['multiplayer', 'presentation', 'playlist']);
        //Playback middleware checks hidden presentations
        $this->middleware('playback')->except(['playlist', 'presentation']);
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

        if (!$playlist = VideoCourse::where('video_id', $video->id)->first()) {
            //No playlist
            return Redirect::to('multiplayer?p=' . $video->id);
        } else {
            // Production
            return Redirect::to('multiplayer?p=' . $video->id . '&l=' . $playlist->course_id);
        }
    }

    public function presentation($id)
    {
        $video = Video::find($id);

        //Issue ticket for video
        $ticket = new TicketPermissionHandler($video);
        $token = $ticket->issue();

        // Construct Presentation json from DB
        $presentation = array();
        $presentation['id'] = $video->id;
        $presentation['title'] = $video->title;
        $presentation['thumb'] = $video->thumb;

        $streams = Stream::where('video_id', $video->id)->where('hidden', 0)->get();

        /*foreach ($streams as $key => $stream) {
            $presentation['sources'][] = [
                'poster' => $this->base_uri() .'/' . $video->id . '/' .$stream->poster,
                'playAudio' => (bool) $stream->audio,
                'name' => $stream->name
             ];
            $resolutions = StreamResolution::where('stream_id', $stream->id)->get();
            foreach ($resolutions as $resolution) {
                $presentation['sources'][$key]['video'][$resolution->resolution] = $this->base_uri() .'/'. $video->id . '/' . $resolution->filename;
            }
        }*/

        //New presentation structure
        foreach ($streams as $key => $stream) {
            $resolutions = StreamResolution::where('stream_id', $stream->id)->get();

            foreach ($resolutions as $resolution) {
                $videosource[$resolution->resolution] = $this->base_uri() .'/'. $video->id . '/' . $resolution->filename;
            }
            $build = \Illuminate\Support\Collection::make([
                    'video' => \Illuminate\Support\Collection::make($videosource),
                    'poster' => $this->base_uri() . '/' . $video->id . '/' . $stream->poster,
                    'playAudio' => (bool)$stream->audio
                    ]);

            $presentation['sources'] = \Illuminate\Support\Collection::make([
                $stream->name => $build
            ]);
        }

        //Add subtitles
        if($video->subtitles) {
            $subtitles = json_decode($video->subtitles, true);
            foreach($subtitles as $key => $subtitle) {
                $subs[$key] = $this->base_uri() . '/' . $video->id . '/' . $subtitle;
            }
            $presentation['subtitles'] = $subs;
        }

        //Add valid token
        $presentation['token'] = $token;

        //Update stats
        $stats = VideoStat::firstOrNew(['video_id' => $id]);
        $stats->playback = $stats->playback + 1;
        $stats->save();

        return json_encode($presentation);
    }

    public function playlist($id): string
    {
        //Generate a playlist of videos associated with the course
        $videos = VideoCourse::where('course_id', $id)->latest()->pluck('video_id')->toArray();

        $visibility = app(VisibilityFilter::class);

        $playlist = $visibility->filter(Video::whereIn('id', $videos)->where('visibility', 1)->orderBy('creation')->get());
        $course = Course::findOrFail($id);

        //Build json playlist
        $json = Collection::make([
            'title' => $course->designation . ' ' . $course->semester . $course->year . ' presentations'
        ]);
        $playlist
            ->makeHidden('presentation')
            ->makeHidden('notification_id')
            ->makeHidden('creation')
            ->makeHidden('subtitles')
            ->makeHidden('sources')
            ->makeHidden('origin')
            ->makeHidden('type')
            ->makeHidden('duration')
            ->makeHidden('tags')
            ->makeHidden('category_id')
            ->makeHidden('visibility')
            ->makeHidden('download')
            ->makeHidden('created_at')
            ->makeHidden('updated_at');

        $json['items'] = $playlist->toArray();


        return $json->toJson(JSON_PRETTY_PRINT);
    }

    public function multiplayer()
    {
        return view('player.index');
    }
}
