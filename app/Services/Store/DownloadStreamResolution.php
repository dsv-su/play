<?php

namespace App\Services\Store;

use App\Stream;
use App\Video;
use Illuminate\Database\Eloquent\Model;

class DownloadStreamResolution extends Model
{
    protected $video_streams, $video_stream, $resolution, $streams = [];
    protected $posters = [];

    public function __construct(Video $video)
    {
        $this->video_streams = Stream::where('video_id',$video->id)->get();
    }

    public function videonames($resolution)
    {
        foreach($this->video_streams as $this->video_stream) {
            foreach($this->video_stream->resolutions as $this->resolution) {
                if($this->resolution->resolution == $resolution) {
                    $this->streams[] = $this->resolution->filename;
                }
            }
        }
        return $this->streams;
    }
    public function posternames()
    {
        foreach($this->video_streams as $this->video_stream) {
            $this->posters[] = $this->video_stream->poster;
        }
        return $this->posters;
    }
}
