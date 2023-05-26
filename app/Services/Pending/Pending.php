<?php

namespace App\Services\Pending;

use App\Video;

class Pending
{
    public static function presentations()
    {
        return Video::with('category', 'video_course.course')->where('state', false)->latest('creation')->get();
    }

    public static function presentations_state()
    {
        if(Video::where('state', false)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
