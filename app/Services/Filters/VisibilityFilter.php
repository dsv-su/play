<?php

namespace App\Services\Filters;

use App\Video;

class VisibilityFilter
{
    protected $video;

    public function __construct($videos)
    {
        $this->videos = $videos;
    }

        public function filter()
        {
            $this->videos->filter(function ($video, $key)  {
                //Check and set CourseSettings
                $test = new CoursePermissionFilter($video);
                $test->permissionType();
                
            });


        }

//Check if video is associated with one or many courses
    //yes
        //Foreach course
            //Check course setting visibility
                //yes
                    //check if course is public
                        //yes - set public setting

                        //no - set private setting
                //no

    //no

}
