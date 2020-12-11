<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Video;
use Carbon\Carbon;

class VideoStore extends Model
{
    protected $video;
    private $file, $system_config;

    public function __construct($request)
    {
        $this->request = $request;
    }

    private function permission()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['global']['default_presentation_permission'];
    }

    private function entitlement()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['global']['default_presentation_entitlement'];
    }

    public function presentation()
    {
        $this->video = new Video;
        $this->video->presentation_id = $this->request->id;
        $this->video->title = $this->request->title;
        $this->video->thumb = $this->request->thumb;
        $this->video->duration = $this->request->duration;
        $this->video->subtitles = $this->request->subtitles;
        $this->video->tags = json_encode($this->request->tags, true);
        $this->video->sources = json_encode($this->request->sources, true);
        $this->video->presentation = json_encode($this->request->all(), true);
        $this->video->permission = $this->permission();
        $this->video->entitlement = $this->entitlement();
        $this->video->category_id = $this->request->category_id ?? 1;
        $this->video->save();

        return $this->video;
    }
}
