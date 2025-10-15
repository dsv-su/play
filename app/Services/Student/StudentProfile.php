<?php

declare(strict_types=1);

namespace App\Services\Student;

use App\Services\Daisy\DaisyIntegration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

final class StudentProfile
{
    public function __construct(
        private readonly DaisyIntegration $daisy,
        private readonly int $ttlSeconds = 900, // cache TTL in seconds
    ) {}

    /**
     * Return active course IDs for the current student.
     *
     * @return array<int,int>
     */
    public function getStudentCourseIds(): array
    {
        // Pull these once to avoid repeated container lookups.
        $role     = app('play_role');
        $auth     = app('play_auth');
        $username = (string) app('play_username');

        // --- Fixture students (for testing) ---
        $fixtures = [
            'Student1' => [6442, 6841, 6761, 6837, 6703, 6839, 6708, 6838, 6769],
            'Student2' => [6817, 6644, 6737, 6661, 6816, 6835, 6780, 6626, 6656, 6748, 6604, 6684, 6819, 6595, 6852],
            'Student3' => [6798, 6799, 6760, 6778, 6828, 6796, 6719, 6720],
        ];

        if (isset($fixtures[$role])) {
            return $fixtures[$role];
        }

        // --- Real students (production only) ---
        $isProd          = App::environment('production');
        $hasStudentAuth  = ($auth === 'Student');
        $hasStudentRole  = in_array($role, ['Uploader', 'Student'], true);

        if ($isProd && $hasStudentAuth && $hasStudentRole && $username !== '') {
            $cacheKey = "student:courses:{$username}";

            return Cache::remember(
                $cacheKey,
                $this->ttlSeconds,
                fn () => $this->daisy->getActiveStudentCourses($username) ?? []
            );
        }

        return [];
    }
}
