<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'tag_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
