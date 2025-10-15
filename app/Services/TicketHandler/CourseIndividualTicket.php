<?php

namespace App\Services\TicketHandler;

use App\Models\CoursesettingsUsers;
use App\Models\Video;

class CourseIndividualTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        // Work with the loaded collection, not the relation object
        $this->video = $video->loadMissing('courses');
    }

    public function cast(): Video
    {
        $remote = $_SERVER['REMOTE_USER'] ?? null;
        if (!$remote) {
            return $this->video; // no authenticated remote user
        }

        // DB stores usernames without domain (based on your original code)
        $username = explode('@', $remote, 2)[0];

        $courses = $this->video->courses; // Collection<Course>
        if ($courses->isEmpty()) {
            return $this->video;
        }

        $courseIds = $courses->pluck('id');

        // One EXISTS query across all related courses
        $hasTicket = CoursesettingsUsers::whereIn('course_id', $courseIds)
            ->where('username', $username)
            ->whereIn('permission', ['read', 'edit', 'delete'])
            ->exists();

        if ($hasTicket) {
            $this->video->setAttribute('ticket', true);
        }

        return $this->video;
    }
}

