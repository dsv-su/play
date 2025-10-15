<?php

namespace App\Services\Video;

use App\Video;
use Illuminate\Database\Eloquent\Model;

class VideoResolution extends Model
{
    protected $video, $source, $key, $link, $resolutions;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function availableResolutions()
    {
        foreach (json_decode($this->video->sources, true) as $this->source) {
            foreach ($this->source['video'] as $this->key => $this->link) {
                $resolutions[] = $this->key;
            }
        }
        return $resolutions;
    }
}
