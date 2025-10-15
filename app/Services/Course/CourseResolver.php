<?php

namespace App\Services\Course;
use App\Models\Course;
use App\Models\CoursesettingsUsers;
use App\Services\Daisy\DaisyAPI;

class CourseResolver
{
    protected DaisyAPI $daisy;

    public function __construct(DaisyAPI $daisy)
    {
        $this->daisy = $daisy;
    }

    public function getCoursesForUser(string $username, string $role)
    {
        if ($role !== 'Administrator') {
            $daisyPersonId = cache()->remember("daisy:personId:{$username}", now()->addMinutes(10), function () use ($username) {
                return $this->daisy->getDaisyPersonId($username);
            });

            $daisyCourseIds = cache()->remember("daisy:responsibleCourseIds:{$daisyPersonId}", now()->addMinutes(10), function () use ($daisyPersonId) {
                $list = $this->daisy->getDaisyEmployeeResponsibleCourses($daisyPersonId);
                return collect($list)->pluck('id')->filter()->values()->all();
            });

            $dbPermittedCourseIds = CoursesettingsUsers::query()
                ->where('username', $username)
                ->whereIn('permission', ['upload', 'delete', 'edit'])
                ->pluck('course_id');

            $allowedCourseIds = $dbPermittedCourseIds->merge($daisyCourseIds)->unique()->values();

            return [
                'courses' => $allowedCourseIds->isNotEmpty()
                    ? Course::whereIn('id', $allowedCourseIds)->get()
                    : collect(),
                'allowedCourseIds' => $allowedCourseIds,
            ];
        }

        // Admin role
        $daisyCourseIds = cache()->remember("daisy:adminCourseIds", now()->addMinutes(10), function () {
            $list = $this->daisy->getDaisyCourses();
            return collect($list)->pluck('id')->filter()->values()->all();
        });

        return [
            'courses' => Course::all(),
            'allowedCourseIds' => $daisyCourseIds,
        ];
    }
}
