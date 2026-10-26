<?php

namespace App\Services\Stream;

use App\Models\ManualPresentation;
use App\Models\Stream;
use App\Models\StreamResolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StreamsStore
{
    protected array $sources = [];
    protected $video;
    protected bool $hasSources;
    protected bool $isEdit;

    public function __construct(Request $request, $video)
    {
        // Editing can replace individual streams; an edit callback may omit unchanged sources.
        $this->isEdit = $request->filled('jobid') && ManualPresentation::query()
            ->where('jobid', $request->input('jobid'))
            ->where('pkg_id', $video->id)
            ->where('type', 'edit')
            ->exists();
        $this->hasSources = $request->exists('package.sources');
        $this->sources = (array) $request->input('package.sources', []);
        $this->video = $video;
    }

    public function streams(): void
    {
        if (!$this->hasSources) {
            return;
        }

        DB::transaction(function () {
            // An empty edit result must not remove the existing streams.
            if ($this->isEmptySources()) {
                if (!$this->isEdit) {
                    $this->deleteAllStreams();
                }
                return;
            }

            $keptStreamIds = [];

            foreach ($this->sources as $key => $source) {
                if (empty($source)) {
                    continue;
                }

                $stream = $this->updateStream($key, $source);
                $keptStreamIds[] = $stream->id;

                if (array_key_exists('video', $source)) {
                    $this->updateStreamResolutions($stream, $source['video']);
                }
            }

            // Non-edit callbacks contain an authoritative stream list.
            if (!$this->isEdit) {
                $this->video->streams()
                    ->whereNotIn('id', $keptStreamIds)
                    ->delete();
            }
        });
    }

    protected function updateStream(string|int $name, array $source): Stream
    {
        return Stream::updateOrCreate(
            ['video_id' => $this->video->id, 'name' => $name],
            array_filter([
                'poster' => $source['poster'] ?? null,
                'audio' => $source['playAudio'] ?? null,
            ], fn ($value) => $value !== null)
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
