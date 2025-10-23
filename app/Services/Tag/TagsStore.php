<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class TagsStore
{
    public function handle($request, Video $video): void
    {
        // Normalize only spacing and empties — NOT case
        $names = collect((array)($request->input('package.tags') ?? []))
            ->map(fn ($t) => is_string($t) ? trim($t) : '')
            ->filter()  // remove empty/null
            ->unique()  // keep first unique by exact string match
            ->values();

        DB::transaction(function () use ($video, $names) {
            if ($names->isEmpty()) {
                // Remove all old tag associations
                $video->tags()->sync([]);
                return;
            }

            // Get existing tags (incase-sensitive)
            //$existing = Tag::whereIn('name', $names)->pluck('id', 'name');
            // Get existing tags (case-sensitive)
            $existing = \App\Models\Tag::whereIn(DB::raw('BINARY name'), $names)->pluck('id', 'name');

            // Determine which tags need to be created
            $toCreate = $names->diff($existing->keys());

            if ($toCreate->isNotEmpty()) {
                Tag::insert(
                    $toCreate->map(fn ($name) => [
                        'name'       => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])->all()
                );
            }

            // Fetch all tag IDs (existing + newly created)
            //$allIds = Tag::whereIn('name', $names)->pluck('id')->all();
            $allIds = \App\Models\Tag::whereIn(DB::raw('BINARY name'), $names)->pluck('id')->all();

            // Sync in one go — replaces old associations automatically
            $video->tags()->sync($allIds);
        });
    }
}
