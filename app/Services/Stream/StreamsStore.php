<?php

namespace App\Services\Stream;

use App\Stream;
use App\StreamResolution;
use Illuminate\Database\Eloquent\Model;

class StreamsStore extends Model
{
    protected $streams, $video;

    public function __construct($request, $video)
    {
        $this->streams = $request->sources;
        $this->video = $video;
    }

    public function streams()
    {
        if(count($this->streams)>0) {
            foreach ($this->streams as $key => $source) {
                if ($source) {
                    $stream = Stream::firstOrNew([
                        'video_id' => $this->video->id,
                        'name' => $source->name ?? $key,
                        'poster' => $source->poster,
                        'audio' => $source->playAudio
                    ]);
                    $stream->save();
                    foreach ($source->video as $resolution => $url) {
                        $streamresolution = StreamResolution::firstOrNew([
                            'stream_id' => $stream->id,
                            'resolution' => $resolution,
                            'filename' => $url
                        ]);
                        $streamresolution->save();
                    }
                } //end check
            } // end foreach
        } else {
            //Remove any old associations
            $streams = Stream::where('video_id', $this->video->id);
            foreach ($streams as $stream) {
                StreamResolution::where('stream_id', $stream->id)->delete();
                $stream->delete();
            }
        }
    }

}
