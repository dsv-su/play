<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'name', 'poster', 'audio'];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function resolutions(): HasMany
    {
        return $this->hasMany(StreamResolution::class);
    }
}
