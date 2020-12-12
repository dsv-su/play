<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'tag_id'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
