<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presenter extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'name', 'description'];

    public function video_presenter(): HasMany
    {
        return $this->hasMany(VideoPresenter::class);
    }

    public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoPresenter::class, 'presenter_id', 'id', 'id', 'video_id')->get();
    }
}
