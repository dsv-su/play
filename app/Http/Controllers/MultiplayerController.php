<?php

namespace App\Http\Controllers;

use App\Services\TicketHandler;
use App\Video;
use App\VideoCourse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MultiplayerController extends Controller
{
    /**
     * @param Video $video
     * @return RedirectResponse
     */
    public function player(Video $video): RedirectResponse
    {

        if (!$playlist = VideoCourse::where('video_id', $video->id)->first()) {
            //No playlist
            /* old $url = url('/multiplayer') . '?' . urldecode(http_build_query(['presentation' => URL::to('/') . '/presentation/' . $video->id, 'authtoken' => $token]));*/
            $url = url('/multiplayer') . '?' . urldecode(http_build_query(['p' =>  $video->id]));
        } else {
            // Production
            /* old $url = url('/multiplayer') . '?' . urldecode(http_build_query(['presentation' => URL::to('/') . '/presentation/' . $video->id, 'playlist' => URL::to('/') . '/playlist/' . $playlist->course_id, 'authtoken' => $token]));*/
            //$url = url('/multiplayer') . '?' . urldecode(http_build_query(['presentation' => $video->id, 'playlist' =>  $playlist->course_id]));
            // Dev
            $url = url('/multiplayer') . '?' . http_build_query(['p' => $video->id, 'l' => $playlist->course_id]);
        }

        return redirect()->away($url);
    }

    public function presentation($id)
    {
        $video = Video::find($id);

        //Issue ticket for video
        $ticket = new TicketHandler($video);
        $token = $ticket->issue();

        $presentation = json_decode($video->presentation, true);


        //Add valid token
        $presentation['token'] = $token;

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
            ->makeHidden('id')
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
            ->makeHidden('permission')
            ->makeHidden('entitlement')
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
