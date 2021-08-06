<?php

namespace App\Http\Controllers;

use App\Services\TicketHandler;
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
        $this->middleware(['entitlements', 'playauth'])->except(['presentation', 'playlist']);
    }

    /**
     * @param Video $video
     * @return RedirectResponse
     */
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
        $ticket = new TicketHandler($video);
        $token = $ticket->issue();

        // Construct Presentation json from DB
        $presentation = array();
        $streams = Stream::where('video_id', $video->id)->get();
        foreach ($streams as $key => $stream) {
            $presentation['sources'][] = [
                'poster' => 'https://play-store.dsv.su.se/presentation/' . $video->id . '/' .$stream->poster,
                'playAudio' => (bool) $stream->audio,
                'name' => $stream->name
             ];
            $resolutions = StreamResolution::where('stream_id', $stream->id)->get();
            foreach ($resolutions as $resolution) {
                $presentation['sources'][$key]['video'][$resolution->resolution] = 'https://play-store.dsv.su.se/presentation/' . $video->id . '/' . $resolution->filename;
            }
        }

        $presentation['id'] = $video->id;
        $presentation['title'] = $video->title;
        $presentation['thumb'] = 'https://play-store.dsv.su.se/presentation/' . $presentation['id'] . '/' . $video->thumb;
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
        $videos = VideoCourse::where('course_id', $id)->pluck('video_id')->toArray();

        $playlist = Video::whereIn('id', $videos)->get();
        //Build json playlist
        $json = Collection::make([
            'title' => 'My Playlist'
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
