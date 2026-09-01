<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Channel extends Model
{
    use Searchable;

    protected $fillable = ['category_id', 'name', 'slug', 'created_by', 'show_on_homepage'];

    protected $casts = ['show_on_homepage' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Presenter::class, 'created_by', 'username');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getComponentKeyAttribute(): string
    {
        return 'channel.'.$this->id;
    }

    public function toSearchableArray(): array
    {
        return [
            'id'   => (string) $this->getKey(),
            'name' => (string) $this->name,
            'slug' => (string) $this->slug,
        ];
    }

    public function typesenseCollectionSchema(): array
    {
        return [
            'name' => $this->searchableAs(),
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'slug', 'type' => 'string'],
            ],
        ];
    }

    public function presentations(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'channel_video_assignments')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ChannelVideoAssignment::class);
    }
}
