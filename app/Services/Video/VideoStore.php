<?php

namespace App\Services\Video;

use App\Video;
use Carbon\Carbon;

class VideoStore
{
    protected $video, $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function presentation(): Video
    {
        $this->video = new Video;
        $title = new TitleObject($this->request->input('package.title'));
        $this->video->id = $this->request->input('package.pkg_id');
        $this->video->origin = $this->request->origin;
        $this->video->notification_id = $this->request->jobid;
        $this->video->creation = $this->request->input('package.created');
        $this->video->title = $title->swedish();
        $this->video->title_en = $title->english();
        $this->video->description = $this->request->input('package.description');
        $this->video->thumb = $this->request->input('package.thumb');
        $this->video->duration = Carbon::parse($this->request->input('package.duration'));
        //$this->video->visibility = !isset($this->request->visibility) || (bool)$this->request->visibility;
        $this->video->subtitles = json_encode($this->request->input('package.subtitles'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->sources = json_encode($this->request->input('package.sources'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->presentation = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->video->category_id = $this->request->category_id ?? 1;
        //Set video state
        if(count($this->request->pending) > 0) {
            $this->video->state = false;
        } else {
            $this->video->state = true;
        }
        $this->video->save();

        //Update mediasite video link
        //TODO
        /*if ($this->request->origin == 'mediasite') {
            // If the Mediasite presentation doesnt exist - prevent error /RD
            if($mp = MediasitePresentation::find($this->request->notification_id)) {
                $mp->video_id = $this->video->id;
                $mp->save();
            }
        }*/

        //Make manual uploaded presentation that are not associated to a course default hidden
        //Depricated
        /*if($this->request->origin == 'manual') {
            $this->video->visibility = false;
            $this->video->save();
        }*/

        return $this->video;
    }
}
