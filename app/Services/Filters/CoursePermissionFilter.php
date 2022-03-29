<?php

namespace App\Services\Filters;

use App\CoursePermissions;
use App\Interfaces\VisibilityInterface;
use App\Video;

class CoursePermissionFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $courses, $course, $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->courses = $video->courses();
    }

    public function cast()
    {
        foreach($this->courses as $this->course) {
            if($id = $this->getCoursePermissionId($this->course->id)) {
                $this->video->setAttribute('course_permission', true);
                switch($id) {
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
            } else {
                //Fallback to default setting if not set
                $this->video->setAttribute('course_permission', true);
                $this->video->setAttribute('permission_type', 'dsv');
            }
        }
    }

    private function getCoursePermissionId($course_id)
    {
        return CoursePermissions::where('course_id', $course_id)->pluck('permission_id')->first();
    }
}
