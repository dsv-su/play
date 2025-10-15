<?php

namespace App\Services\Filters;

use App\Models\CoursesettingsUsers;
use App\Interfaces\VisibilityInterface;
use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseSettingUsersFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $courses, $user, $video;

    public function __construct(Video $video)
    {
        // Ensure we have a collection, not the relation
        $this->video   = $video->load('courses');      // eager-load relation
        $this->courses = $this->video->courses;        // Collection<Course>
        // or: $this->courses = $video->courses()->get();

        $this->user    = app('play_username');
    }

    public function cast()
    {
        foreach ($this->courses as $course) {
            $users = $this->getCourseSettingUsers($course->id);

            foreach ($users as $user) {
                if ($user->username === $this->user) {
                    if (!$this->video->getAttribute('visibility')) {
                        $this->video->setAttribute('visibility', true);
                        $this->video->setAttribute('hidden', true);
                    }

                    switch ($user->permission) {
                        case 'edit':
                            $this->video->setAttribute('edit', true);
                            break;

                        case 'delete':
                            $this->video->setAttribute('edit', true);
                            $this->video->setAttribute('delete', true);
                            break;
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
