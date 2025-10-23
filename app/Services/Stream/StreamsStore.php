<?php

namespace App\Services\Stream;

use App\Models\Stream;
use App\Models\StreamResolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StreamsStore
{
    protected array $sources = [];
    protected $video;

    public function __construct(Request $request, $video)
    {
        $this->sources = (array) $request->input('package.sources', []);
        $this->video = $video;
    }

    public function streams(): void
    {
        DB::transaction(function () {
            // If there are no valid sources, delete all
            if ($this->isEmptySources()) {
                $this->deleteAllStreams();
                return;
            }

            $keptStreamIds = [];

            foreach ($this->sources as $key => $source) {
                if (empty($source)) {
                    continue;
                }

                $stream = $this->updateStream($key, $source);
                $keptStreamIds[] = $stream->id;

                $this->updateStreamResolutions($stream, $source['video'] ?? []);
            }

            // Remove streams that were not present in the request
            $this->video->streams()
                ->whereNotIn('id', $keptStreamIds)
                ->delete();
        });
    }

    protected function updateStream(string|int $name, array $source): Stream
    {
        return Stream::updateOrCreate(
            ['video_id' => $this->video->id, 'name' => $name],
            [
                'poster' => $source['poster'] ?? '',
                'audio' => $source['playAudio'] ?? false,
            ]
        );
    }

    protected function updateStreamResolutions(Stream $stream, array $videoUrls): void
    {
        $keptIds = [];

        foreach ($videoUrls as $resolution => $url) {
            $resolutionModel = StreamResolution::updateOrCreate(
                [
                    'stream_id' => $stream->id,
                    'resolution' => $resolution,
                ],
                ['filename' => $url]
            );

            $keptIds[] = $resolutionModel->id;
        }

        // Clean up removed resolutions
        $stream->resolutions()
            ->whereNotIn('id', $keptIds)
            ->delete();
    }

    protected function deleteAllStreams(): void
    {
        $this->video->streams()->delete();
    }

    protected function isEmptySources(): bool
    {
        if (empty($this->sources)) {
            return true;
        }

        foreach ($this->sources as $source) {
            if (!empty($source)) {
                return false;
            }
        }

        return true;
    }
}
