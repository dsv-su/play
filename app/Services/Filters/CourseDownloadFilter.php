<?php

namespace App\Services\Filters;

use App\Models\CoursesettingsPermissions;
use App\Models\Video;

class CourseDownloadFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        // Ensure we work with the loaded collection, not the relation object
        $this->video = $video->loadMissing('courses');
    }

    public function cast(): void
    {
        $courses = $this->video->courses; // Collection<Course>

        if ($courses->isEmpty()) {
            // No related courses; keep current download state unchanged
            return;
        }

        // Collect course IDs
        $courseIds = $courses->pluck('id');

        // Get downloadable flags per course in one go: [course_id => 0|1|null]
        $downloadByCourse = CoursesettingsPermissions::whereIn('course_id', $courseIds)
            ->pluck('downloadable', 'course_id');

        // Flatten to a plain list of values (could be 0,1, or null if no row)
        $values = [];
        foreach ($courseIds as $id) {
            $values[] = $downloadByCourse[$id] ?? null;
        }

        // If ANY course explicitly disallows download → force false
        if (in_array(0, $values, true)) {
            $this->video->setAttribute('download', false);
            return;
        }

        // Otherwise, if not already downloadable, allow if ANY course explicitly allows
        $current = optional($this->video->fresh())->download; // re-pull to respect db state if needed
        if (!$current) {
            if (in_array(1, $values, true)) {
                $this->video->setAttribute('download', true);
            }
            // If all values are null (no explicit settings), leave as-is
        }
    }
}

