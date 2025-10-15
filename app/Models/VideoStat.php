<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoStat extends Model
{
    use HasFactory;

    protected $fillable = ['video_id','stats'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
