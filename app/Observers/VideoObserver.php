<?php

namespace App\Observers;

use App\Models\Video;
use Illuminate\Support\Facades\Log;

class VideoObserver
{
    public bool $afterCommit = true;

    private function reindex(Video $video): void
    {
        try {
            if ($video->shouldBeSearchable()) {
                $video->searchable();
            } else {
                $video->unsearchable();
            }
        } catch (\Throwable $e) {
            Log::warning('VideoObserver reindex failed', [
                'video_id' => $video->getKey(),
                'error'    => $e->getMessage(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
            ]);
        }
    }

    public function saved(Video $video): void
    {
        $this->reindex($video);
    }

    public function deleted(Video $video): void
    {
        try {
            $video->unsearchable();
        } catch (\Throwable $e) {
            Log::warning('VideoObserver unsearchable failed on delete', [
                'video_id' => $video->getKey(),
                'error'    => $e->getMessage(),
            ]);
        }
    }

    public function restored(Video $video): void
    {
        $this->reindex($video);
    }

    public function forceDeleted(Video $video): void
    {
        try {
            $video->unsearchable();
        } catch (\Throwable $e) {
            Log::warning('VideoObserver unsearchable failed on force delete', [
                'video_id' => $video->getKey(),
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
