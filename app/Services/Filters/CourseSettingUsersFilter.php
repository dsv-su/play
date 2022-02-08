<?php

namespace App\Services\Filters;

use App\CoursesettingsUsers;
use App\Interfaces\VisibilityInterface;
use App\Video;

class CourseSettingUsersFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $courses, $course, $user, $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->courses = $video->courses();
        $this->user = app()->make('play_username');
    }

    public function cast()
    {
        foreach($this->courses as $this->course) {
            if($users = $this->getCourseSettingUsers($this->course->id)) {
                foreach($users as $user) {
                    if($user->username == $this->user) {
                        switch($user->permission) {
                            case('read'):
                                $this->video->setAttribute('visibility', true);
                                break;
                            case('edit'):
                                $this->video->setAttribute('visibility', true);
                                $this->video->setAttribute('edit', true);
                                break;
                            case('delete'):
                                $this->video->setAttribute('visibility', true);
                                $this->video->setAttribute('edit', true);
                                $this->video->setAttribute('delete', true);
                        }
                    }
                }
            }
        }
    }

    private function getCourseSettingUsers($course_id)
    {
        return CoursesettingsUsers::where('course_id', $course_id)->get();
    }

}
