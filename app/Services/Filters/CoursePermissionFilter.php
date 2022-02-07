<?php

namespace App\Services\Filters;

use App\CoursePermissions;
use App\Video;

class CoursePermissionFilter extends VisibilityFilter
{
    protected $courses, $course;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->courses = $video->courses();
    }

    public function permissionType()
    {
        foreach($this->courses as $this->course) {
            switch($this->getCoursePermissionId($this->course->id)) {
                case(1):
                    $this->video->setAttribute('permission_type', 'dsv');
                    break;
                case(2):
                    $this->video->setAttribute('permission_type', 'dsv_staff');
                    break;
                case(3):
                    $this->video->setAttribute('permission_type', 'test');
                    break;
                case(4):
                    $this->video->setAttribute('permission_type', 'public');
                    break;
                default:
                    $this->video->setAttribute('permission_type', 'custom');
            }
        }

    }

    private function getCoursePermissionId($course_id)
    {
        return CoursePermissions::where('course_id', $course_id)->pluck('permission_id')->first();
    }
}
