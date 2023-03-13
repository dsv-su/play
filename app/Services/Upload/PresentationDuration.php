<?php

namespace App\Services\Upload;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class PresentationDuration
{
    public function duration($filename)
    {
        $video = $filename;
        $media = FFMpeg::fromDisk('play-store')->open($video);
        return $media->getDurationInSeconds();
    }
}
