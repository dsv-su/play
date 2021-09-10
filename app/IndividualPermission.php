<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualPermission extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'username', 'name', 'permission'];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
