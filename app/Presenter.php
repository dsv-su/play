<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Presenter extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $fillable = ['username', 'name', 'description'];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'username' => 10
        ]
    ];

    protected $appends = ['type'];

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

    public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoPresenter::class, 'presenter_id', 'id', 'id', 'video_id')->get();
    }
}
