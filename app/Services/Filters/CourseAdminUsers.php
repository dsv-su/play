<?php

namespace App\Services\Filters;

use App\Video;

class CourseAdminUsers extends VisibilityFilter
{
    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->courses = $video->courses();
    }



}
