<?php

namespace App\Services\Video;

use App\MediasitePresentation;
use Carbon\Carbon;
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
        $title = new TitleObject($this->request->title);
        $this->video->origin = $this->request->origin;
        $this->video->notification_id = $this->request->notification_id;
        $this->video->creation = $this->request->creation;
        $this->video->title = $title->swedish();
        $this->video->title_en = $title->english();
        $this->video->description = $this->request->description;
        $this->video->thumb = $this->request->thumb;
        $this->video->duration = Carbon::parse($this->request->duration);
        $this->video->visibility = !isset($this->request->visibility) || (bool)$this->request->visibility;
        $this->video->subtitles = $this->request->subtitles;
        $this->video->sources = json_encode($this->request->sources, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->presentation = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->category_id = $this->request->category_id ?? 1;
        $this->video->save();

        //Update mediasite video link
        if ($this->request->origin == 'mediasite') {
            // If the Mediasite presentation doesnt exist - prevent error /RD
            if($mp = MediasitePresentation::find($this->request->notification_id)) {
                $mp->video_id = $this->video->id;
                $mp->save();
            }

        }
        //Make manual uploaded presentation default hidden
        if($this->request->origin == 'manual') {
            $this->video->visibility = false;
            $this->video->save();
        }

        return $this->video;
    }
}
