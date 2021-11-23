<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Model;

class CourseVisibility extends Model
{

    public function checkVisability($videos)
    {
        //Filter videos with coursesetting visibility
        return $videos->filter(function ($video, $key) {
            if(count($video->courses())>=1) {
                foreach($video->courses() as $course) {
                    if($setting = $course->coursesettings->toArray()) {
                        if($setting[0]['visibility'] == true) {
                            return $video;
                        }
                    }
                    else {
                        return $video;
                    }

                }
            } else {
                return $video;
            }

            return false;
        });
    }
}
