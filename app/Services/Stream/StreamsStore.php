<?php

namespace App\Services\Stream;

use App\Stream;
use App\StreamResolution;
use Illuminate\Database\Eloquent\Model;

class StreamsStore extends Model
{
    protected $video;

    public function __construct($request, $video)
    {
        $this->sources = $request->input('package.sources');
        $this->video = $video;
    }

    public function streams()
    {

        if (empty($this->sources)) {
            $this->deleteAllStreams();
            return;
        }

        foreach ($this->sources as $key => $source) {
            if (empty($source)) {
                continue;
            }

            $stream = $this->updateStream($key, $source);
            $this->updateStreamResolutions($stream, $source['video'] ?? []);
        }
    }

    protected function updateStream($name, $source)
    {
        return Stream::updateOrCreate(
            ['video_id' => $this->video->id, 'name' => $name],
            ['poster' => $source['poster'] ?? '', 'audio' => $source['playAudio'] ?? false]
        );
    }

    protected function updateStreamResolutions($stream, $videoUrls)
    {
        foreach ($videoUrls as $resolution => $url) {
            StreamResolution::updateOrCreate(
                ['stream_id' => $stream->id, 'resolution' => $resolution],
                ['filename' => $url]
            );
        }
    }

    protected function deleteAllStreams()
    {
        $this->video->streams()->delete();
    }
}
