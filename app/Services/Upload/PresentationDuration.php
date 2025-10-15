<?php

namespace App\Services\Upload;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class PresentationDuration
{
    public function duration($filename)
    {
        $video = $filename;
        try {
            $media = FFMpeg::fromDisk('play-store')->open($video);
        } catch (\Throwable $e) {
            report($e);
        }

        return $media->getDurationInSeconds();
    }
}
