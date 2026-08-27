<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelVideoAssignment extends Model
{
    protected $fillable = ['channel_id', 'video_id', 'assigned_by'];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
