<?php

namespace App\Services\TicketHandler;

use App\Models\CoursePermissions;
use App\Models\Video;

class CourseSettingTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        // Work with the collection (not the relation object)
        $this->video = $video->loadMissing('courses');
    }

    public function cast()
    {
        $courses = $this->video->courses; // Collection<Course>

        if ($courses->isEmpty()) {
            // Original behavior: don't set anything when no courses
            return $this->video;
        }

        // Collect course IDs
        $courseIds = $courses->pluck('id');

        // Fetch permission_id per course in one query: [course_id => permission_id]
        $permIdByCourse = CoursePermissions::whereIn('course_id', $courseIds)
            ->pluck('permission_id', 'course_id');

        // Build the settings list; default to 1 when no row exists
        $settings = [];
        foreach ($courseIds as $courseId) {
            $settings[] = $permIdByCourse[$courseId] ?? 1;
        }

        if (count($settings) > 1) {
            // Multiple settings → default to dsv students & staff (id=1)
            $this->video->setAttribute('ticket_permission_id', 1);
        } else {
            // Single setting
            $this->video->setAttribute('ticket_permission_id', $settings[0]);
        }

        return $this->video;
    }
}
