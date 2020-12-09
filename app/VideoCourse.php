<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCourse extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'course_id'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
