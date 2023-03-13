<?php

namespace App\Services\Upload;

use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class StreamThumb
{
    public function create($directory, $video, $seconds)
    {
        $base = basename($video);
        $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $base);

        //Create thumb and store in folder
        try {
            FFMpeg::fromDisk('play-store')
                ->open($video)
                ->getFrameFromSeconds($seconds)
                ->export()
                ->toDisk('play-store')
                ->save($directory.'/poster/'.$thumb_name.'.png');
        } catch (\Exception $e) {
            report($e);
        }

        if($path = Storage::disk('public')->url($directory.'/poster/'.$thumb_name.'.png')) {
            return $path;
        }

        return 0;
    }
}
