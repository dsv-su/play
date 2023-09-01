<?php

namespace App\Services\Stream;

use App\ManualPresentation;
use App\Stream;
use App\StreamResolution;
use Illuminate\Database\Eloquent\Model;

class StreamsStore extends Model
{
    protected $streams, $video;

    public function __construct($request, $video)
    {
        $this->streams = $request->input('package.sources');
        $this->video = $video;
     }

    public function streams()
    {
        //Check if presentation has been edited
        if(!$presentation = ManualPresentation::where('pkg_id', $this->video->id)->where('type', 'edit')->where(function($query) {
            $query->where('status', 'sent')->orWhere('status', 'completed');})->latest()->first()) {
            if(count($this->streams)>0) {
                foreach ($this->streams as $key => $source) {
                    if ($source) {
                        $stream = Stream::updateOrCreate([
                            'video_id' => $this->video->id, 'name' => $key ?? ''],
                            [
                                'poster' => $source['poster'] ?? '',
                                'audio' => $source['playAudio'] ?? false
                            ]);

                        if($source['video'] ?? false) {
                            foreach ($source['video'] as $resolution => $url) {
                                $streamresolution = StreamResolution::updateOrCreate(
                                    [
                                        'stream_id' => $stream->id,
                                        'resolution' => $resolution
                                    ],
                                    [
                                        'filename' => $url
                                    ]
                                );
                            }
                        }
                    } //end check
                } // end foreach

            } else {
                //Remove any old associations
                $streams = Stream::where('video_id', $this->video->id)->get();
                foreach ($streams as $stream) {
                    StreamResolution::where('stream_id', $stream->id)->delete();
                    $stream->delete();
                }
            }
        } //end presentation edit
    }

}
