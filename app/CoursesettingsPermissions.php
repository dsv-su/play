<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesettingsPermissions extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'visibility', 'downloadable', 'playback'];
}
