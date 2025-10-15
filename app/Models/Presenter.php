<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Presenter extends Model
{
    use Searchable;

    protected $fillable = ['username', 'name', 'description'];

    protected $appends = ['type'];

    // Parallel relation method
    public function videosRelation(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_presenters', 'presenter_id', 'video_id')
            ->withTimestamps();
    }

    // When a tag name changes, reindex related videos
    protected static function booted(): void
    {
        static::saved(function (Presenter $presenter) {
            $presenter->videosRelation()->get()->each->searchable();
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id'       => (string) $this->id,
            'name'     => (string) $this->name,
            'username' => (string) ($this->username ?? ''),
        ];
    }

    public function getTypeAttribute(): string
    {
        return 'presenter';
    }

    public function getUsernameAttribute($value)
    {
        return $value ?: $this->attributes['name'];
    }

    public function video_presenter(): HasMany
    {
        return $this->hasMany(VideoPresenter::class);
    }

    /*public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoPresenter::class, 'presenter_id', 'id', 'id', 'video_id')->get();
    }*/
    public function videos(): BelongsToMany {
        return $this->belongsToMany(Video::class, 'video_presenters', 'presenter_id', 'video_id')->withTimestamps();
    }
}
