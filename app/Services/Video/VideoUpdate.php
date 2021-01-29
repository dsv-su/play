<?php

namespace App\Services\Video;

use Illuminate\Database\Eloquent\Model;

class VideoUpdate extends Model
{
    protected $video;

    public function __construct($video, $request)
    {
        $this->video = $video;
        $this->request = $request;
    }

    public function presentation_update()
    {
        $this->video->origin = $this->request->origin;
        $this->video->notification_id = $this->request->notification_id;
        $this->video->creation = $this->request->creation;
        $this->video->title = $this->request->title;
        $this->video->thumb = $this->request->thumb;
        $this->video->duration = $this->request->duration;
        $this->video->subtitles = $this->request->subtitles;
        $this->video->sources = json_encode($this->request->sources, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->presentation = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        //$this->video->category_id = $this->request->category_id ?? 1;
        $this->video->save();

        return $this->video;
    }
}
