<?php

namespace App\Services;

use App\Models\CourseadminPermission;
use App\Models\CoursesettingsUsers;
use App\Models\IndividualPermission;
use App\Services\Course\CourseAdmin;
use Illuminate\Database\Eloquent\Collection;

class VideoEditPermission
{
    public function __construct(private CourseAdmin $courseAdmin)
    {
    }

    public function editableVideoIds(Collection $videos, string $username, string $role): array
    {
        if ($videos->isEmpty() || $role === 'Administrator') {
            return $videos->modelKeys();
        }

        if ($username === '') {
            return [];
        }

        $videoIds = $videos->modelKeys();
        $permissions = ['edit', 'delete'];
        $editableIds = CourseadminPermission::query()
            ->where('username', $username)
            ->whereIn('video_id', $videoIds)
            ->whereIn('permission', $permissions)
            ->pluck('video_id')
            ->merge(IndividualPermission::query()
                ->where('username', $username)
                ->whereIn('video_id', $videoIds)
                ->whereIn('permission', $permissions)
                ->get(['video_id', 'username', 'permission'])
                ->filter(fn ($permission) => $permission->username === $username
                    && in_array($permission->permission, $permissions, true))
                ->pluck('video_id'));

        $remainingVideos = $videos->except($editableIds->all());
        $remainingVideos->loadMissing('coursesRelation:id');
        $courseIds = $remainingVideos->flatMap(fn ($video) => $video->coursesRelation->modelKeys())
            ->unique()
            ->all();

        if ($courseIds === []) {
            return $editableIds->unique()->all();
        }

        $editableCourseIds = CoursesettingsUsers::query()
            ->where('username', $username)
            ->whereIn('course_id', $courseIds)
            ->whereIn('permission', $permissions)
            ->pluck('course_id')
            ->all();

        $courseMatches = $remainingVideos->filter(
            fn ($video) => array_intersect($video->coursesRelation->modelKeys(), $editableCourseIds)
        );
        $editableIds = $editableIds->merge($courseMatches->modelKeys());
        $remainingVideos = $remainingVideos->except($courseMatches->modelKeys());

        if ($role === 'Courseadmin' && $remainingVideos->contains(fn ($video) => $video->coursesRelation->isNotEmpty())) {
            $responsibleCourseIds = $this->courseAdmin->courses($username.'@su.se');
            $editableIds = $editableIds->merge($remainingVideos
                ->filter(fn ($video) => array_intersect($video->coursesRelation->modelKeys(), $responsibleCourseIds))
                ->modelKeys());
        }

        return $editableIds->unique()->all();
    }
}
