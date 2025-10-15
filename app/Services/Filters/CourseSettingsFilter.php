<?php

namespace App\Services\Filters;

use App\Models\CoursesettingsPermissions;
use App\Models\Video;

class CourseSettingsFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        // Ensure related courses are loaded as a collection
        $this->video = $video->loadMissing('courses');
    }

    public function cast(): void
    {
        $courses = $this->video->courses; // Collection of Course models

        // If there are no courses, choose a sensible default (kept as true to match your fallback)
        if ($courses->isEmpty()) {
            $this->video->setAttribute('visibility', true);
            return;
        }

        // Collect course IDs
        $courseIds = $courses->pluck('id');

        // Fetch all visibility settings in one query: [course_id => visibility]
        $visibilityByCourse = CoursesettingsPermissions::whereIn('course_id', $courseIds)
            ->pluck('visibility', 'course_id');

        // Build the visibility list, defaulting to true when missing
        $visList = [];
        foreach ($courseIds as $courseId) {
            // cast to bool to normalize 0/1 or truthy/falsy
            $visList[] = (bool) ($visibilityByCourse[$courseId] ?? true);
        }

        // If multiple settings exist and they disagree, fallback to false
        $unique = array_unique($visList);
        if (count($visList) > 1 && count($unique) !== 1) {
            $this->video->setAttribute('visibility', false);
            return;
        }

        // Otherwise use the (single) agreed value
        $this->video->setAttribute('visibility', (bool) $visList[0]);
    }
}

