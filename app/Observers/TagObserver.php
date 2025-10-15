<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    /**
     * Handle the Tag "created" event.
     */
    public function created(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "updated" event.
     */
    public function updated(Tag $tag): void
    {
        // Only reindex if the name changed
        if (! $tag->wasChanged('name')) {
            return;
        }

        // Reindex related videos in chunks
        $tag->videosRelation()
            ->select('videos.id')
            ->orderBy('videos.id')
            ->chunkById(500, function ($videos) {
                $videos->each->searchable(); // queued if SCOUT_QUEUE=true
            });
    }

    /**
     * Handle the Tag "deleted" event.
     */
    public function deleted(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "restored" event.
     */
    public function restored(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "force deleted" event.
     */
    public function forceDeleted(Tag $tag): void
    {
        //
    }
}
