<?php

namespace App\Models\Pivots;

use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VideoTagPivot extends Pivot
{
    protected static function booted(): void
    {
        $reindex = function (self $p): void {
            // Defer until transaction commits
            DB::afterCommit(function () use ($p) {
                if ($video = Video::find($p->video_id)) {
                    $video->reindexForSearch();
                }
            });
        };

        static::created($reindex);
        static::updated($reindex); // keep if your pivot has attributes
        static::deleted($reindex);
    }
}
