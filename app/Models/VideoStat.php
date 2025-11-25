<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoStat extends Model
{
    use HasFactory;

    protected $fillable = ['video_id','stats', 'playback', 'download'];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
