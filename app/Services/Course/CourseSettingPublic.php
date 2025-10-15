<?php

namespace App\Services\Course;

use App\Models\CoursePermissions;
use App\Models\Video;

class CourseSettingPublic
{
    /**
     * Return the public setting for a video based on its related courses.
     * If multiple course settings exist and they disagree, fall back to 1.
     * If no courses or no settings exist, fall back to 1.
     */
    public function check(Video $video): int
    {
        // Get the collection of related courses (not the relation object)
        $courses = $video->relationLoaded('courses')
            ? $video->courses
            : $video->load('courses')->courses;

        // If the video has no courses, default to 1
        if ($courses->isEmpty()) {
            return 1;
        }

        // Collect course IDs
        $courseIds = $courses->pluck('id');

        // Get permission_id per course in a single query: [course_id => permission_id]
        $permsByCourse = CoursePermissions::whereIn('course_id', $courseIds)
            ->pluck('permission_id', 'course_id');

        // Build the list, filling in default 1 where a course has no setting
        $courseSettingList = [];
        foreach ($courseIds as $courseId) {
            $courseSettingList[] = $permsByCourse[$courseId] ?? 1;
        }

        // If multiple settings and not all equal, fallback to default 1
        $unique = array_unique($courseSettingList);
        if (count($courseSettingList) > 1 && count($unique) !== 1) {
            return 1;
        }

        // Otherwise return the single (or first) value
        return $courseSettingList[0] ?? 1;
    }
}

