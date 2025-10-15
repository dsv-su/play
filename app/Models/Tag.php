<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;

    protected $fillable = ['name'];

    protected $appends = ['type'];

    // Parallel relation method
    public function videosRelation(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_tags', 'tag_id', 'video_id')
            ->withTimestamps();
    }

    // When a tag name changes, reindex related videos
    protected static function booted(): void
    {
        static::saved(function (Tag $tag) {
            $tag->videosRelation()->get()->each->searchable();
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id'   => (string) $this->getKey(),
            'name' => (string) $this->name,
        ];
    }

    public function getTypeAttribute(): string
    {
        return 'tag';
    }

    /*public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoTag::class, 'tag_id', 'id', 'id', 'video_id')->get();
    }*/

    public function videos(): BelongsToMany {
        return $this->belongsToMany(Video::class, 'video_tags', 'tag_id', 'video_id')->withTimestamps();
    }

}
