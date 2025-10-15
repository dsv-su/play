<?php

namespace App\Services\MyPresentation;

use App\Models\IndividualPermission;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Student\StudentProfile;
use App\Repositories\VideoRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class MyPresentationsService
{
    public function __construct(
        private DaisyIntegration $daisy,
        private VideoRepositoryInterface $videos
    ) {
    }

    /**
     * Resolve courses for a user with role awareness and caching.
     *
     * @return array<int,int|string>
     */
    public function resolveCourseIds(string $username, string $authRole, string $playRole, int $ttl = 3600): array
    {
        $isStaff = $this->isStaff($authRole, $playRole);
        $prod = app()->environment('production');

        if ($prod && $isStaff) {
            return Cache::remember("courses:employee:{$username}", $ttl, function () use ($username) {
                try {
                    return $this->daisy->getActiveEmployeeCourses($username) ?: [];
                } catch (\Throwable $e) {
                    report($e);
                    return [];
                }
            });
        }

        try {
            $student = new StudentProfile($this->daisy, $ttl);
            return $student->getStudentCourseIds() ?: [];
        } catch (\Throwable $e) {
            report($e);
            return [];
        }
    }

    /**
     * Resolve individually permitted video IDs (cached).
     *
     * @return array<int,int|string>
     */
    public function resolveIndividualVideoIds(string $username, int $ttl = 900): array
    {
        return Cache::remember("videos:individual-perms:{$username}", $ttl, function () use ($username) {
            return IndividualPermission::where('username', $username)->pluck('video_id')->all();
        });
    }

    public function isAdmin(string $authRole, string $playRole): bool
    {
        return $authRole === 'Administrator' && $playRole === 'Administrator';
    }

    public function isStaff(string $authRole, string $playRole): bool
    {
        $staff = ['Administrator', 'Courseadmin', 'Staff'];
        return in_array($authRole, $staff, true) && in_array($playRole, $staff, true);
    }

    /**
     * Fetch both list and count (top N version).
     *
     * @return array{videos: \Illuminate\Support\Collection, total: int}
     */
    public function getTopForUser(
        string $username,
        string $authRole,
        string $playRole,
        int $limit = 10
    ): array {
        $courses = array_values(array_unique(Arr::wrap(
            $this->resolveCourseIds($username, $authRole, $playRole)
        )));
        $individual = array_values(array_unique(Arr::wrap(
            $this->resolveIndividualVideoIds($username)
        )));

        if (empty($courses) && empty($individual)) {
            return ['videos' => collect(), 'total' => 0];
        }

        $isAdmin = $this->isAdmin($authRole, $playRole);

        $total = $this->videos->countFor($courses, $individual, $isAdmin);
        $list  = $this->videos->topFor($courses, $individual, $isAdmin, $limit);

        return ['videos' => $list, 'total' => $total];
    }
}

