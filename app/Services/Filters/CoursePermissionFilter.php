<?php

namespace App\Services\Filters;

use App\Models\CoursePermissions;
use App\Models\Video;

class CoursePermissionFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        // Ensure we have a collection, not the relation object
        $this->video = $video->loadMissing('courses');
    }

    public function cast(): void
    {
        $courses = $this->video->courses; // Collection of Course models

        // If there are no courses, use the default fallback
        if ($courses->isEmpty()) {
            $this->video->setAttribute('course_permission', true);
            $this->video->setAttribute('permission_type', 'dsv');
            return;
        }

        // Gather course IDs
        $courseIds = $courses->pluck('id');

        // Fetch permission_id per course in one query: [course_id => permission_id]
        // Equivalent to your old "pluck('permission_id')->first()" per course
        $permIdByCourse = CoursePermissions::whereIn('course_id', $courseIds)
            ->pluck('permission_id', 'course_id');

        // Map DB ids to desired strings
        $map = [
            1 => 'dsv',
            2 => 'dsv_staff',
            3 => 'test',
            4 => 'public',
        ];

        // Build the per-course resolved types, defaulting to 'dsv' when missing
        $types = [];
        foreach ($courseIds as $courseId) {
            $pid = $permIdByCourse[$courseId] ?? 1; // default to id=1 (dsv)
            $types[] = $map[$pid] ?? 'custom';
        }

        // If multiple courses and they disagree, fallback to 'dsv'
        $unique = array_unique($types);
        $finalType = (count($types) > 1 && count($unique) !== 1) ? 'dsv' : $types[0];

        // Apply attributes
        $this->video->setAttribute('course_permission', true);
        $this->video->setAttribute('permission_type', $finalType);
    }

}

