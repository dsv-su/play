<?php

namespace App\Services\Ffmpeg;

use Illuminate\Database\Eloquent\Model;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;

class DetermineDurationVideo extends Model
{
    protected $media;

    protected $video_path;

    protected $media_check;

    protected $media_durations;

    protected $media_duration;

    protected $diff;

    protected $value;

    protected $collection;

    protected $file;

    private $video_name;

    public function __construct($dir)
    {
        $this->video_path = $dir.'/video/';
        $this->diff = 3;
    }

    public function duration($video)
    {
        $this->media = FFMpeg::fromDisk('public')->open($this->video_path.$video);

        return $this->media->getDurationInSeconds();
    }

    public function check()
    {
        foreach ($this->getDownloadedVideoFiles() as $this->media_check) {
            $this->media_durations[] = $this->duration($this->media_check);
        }

        $this->collection = collect($this->media_durations)->map(function ($item, $key) {
            return abs($item - $this->media_durations[0]);
        });

        foreach ($this->collection->toArray() as $this->value) {
            if ($this->value > $this->diff) {
                return false;
            }
        }

        return true;
    }

    private function getDownloadedVideoFiles()
    {
        foreach (Storage::disk('public')->files($this->video_path) as $this->file) {
            $this->video_name[] = basename($this->file);
            // $this->video_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        return $this->video_name;
    }
}
