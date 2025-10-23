<?php

declare(strict_types=1);

namespace App\Services\Course;

use App\Jobs\JobFailedNotification;
use App\Models\Course;
use App\Models\CoursePermissions;
use App\Models\CourseadminPermission;
use App\Models\CoursesettingsPermissions;
use App\Models\VideoCourse;
use App\Models\VideoPermission;
use App\Services\Daisy\DaisyIntegration;
use Illuminate\Database\Connection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class CourseStoreOrUpdate
{
    /** @var array<int, array<string,mixed>> */
    private array $courses;
    private $video;
    private DaisyIntegration $daisy;
    private Connection $db;

    public function __construct($request, $video, DaisyIntegration $daisy = null, Connection $db = null)
    {
        // Expecting array like: ['package' => ['courses' => [ ['designation' => 'XX123', 'semester' => 'HT24'], ... ]]]
        $this->courses = (array)($request->input('package.courses') ?? []);
        $this->video = $video;
        $this->daisy = $daisy ?? new DaisyIntegration();
        $this->db = $db ?? DB::connection($video->getConnectionName());
    }

    public function store(): void
    {
        $videoId = (string) $this->video->getKey();

        // If no courses supplied, just detach any previous links and stop.
        if (empty($this->courses)) {
            VideoCourse::where('video_id', $videoId)->delete();
            return;
        }

        $this->db->transaction(function () use ($videoId) {
            // Remove old links once (not on each iteration)
            VideoCourse::where('video_id', $videoId)->delete();

            foreach ($this->courses as $courseData) {
                if (empty($courseData) || empty($courseData['designation']) || empty($courseData['semester'])) {
                    continue; // skip invalid entries quietly
                }

                [$semester, $year] = $this->parseSemester((string)$courseData['semester']);
                $designation = (string)$courseData['designation'];

                // Try local DB first
                $dbCourse = Course::query()
                    ->where('designation', $designation)
                    ->where('semester', $semester)
                    ->where('year', $year)
                    ->first();

                if (!$dbCourse) {
                    // Lookup in Daisy (designation + year+semesterNumber)
                    $daisyKey = $year . (string)$this->convertDaisySemester($semester);

                    try {
                        $daisyCourse = $this->daisy->getCourse($designation, $daisyKey);
                    } catch (Throwable $e) {
                        Log::warning('Daisy getCourse failed', [
                            'designation' => $designation,
                            'key' => $daisyKey,
                            'error' => $e->getMessage(),
                        ]);
                        $daisyCourse = null;
                    }

                    if ($daisyCourse) {
                        // Mirror Daisy into local Course table (id is from Daisy)
                        $dbCourse = Course::updateOrCreate(
                            ['id' => (int)$daisyCourse['id']],
                            [
                                'name' => (string)($daisyCourse['name'] ?? ''),
                                'name_en' => (string)($daisyCourse['name_en'] ?? ''),
                                'designation' => $designation,
                                'semester' => $semester,
                                'year' => $year,
                            ]
                        );
                    } else {
                        // Daisy lookup failed — log
                        Log::notice(
                            'Failed course association in Daisy',
                            [
                                'video_id' => $videoId,
                                'video_title' => (string)$this->video->title,
                                'designation' => $designation,
                                'semester' => $semester,
                                'year' => $year,
                            ]
                        );

                        dispatch(new JobFailedNotification($this->video, $designation));
                        continue;
                    }
                }

                // Link Video <-> Course (idempotent)
                VideoCourse::updateOrCreate(
                    ['video_id' => $videoId, 'course_id' => (int)$dbCourse->id],
                    []
                );

                // Sync course administrators → CourseadminPermission
                $this->syncCourseAdmins((int)$dbCourse->id, $videoId);

                // Apply course-level settings to the video (visibility, permissions, etc.)
                $this->applyCourseSettings((int)$dbCourse->id);
            }
        });
    }

    /**
     * Apply visibility/download/permission defaults from course settings.
     */
    private function applyCourseSettings(int $courseId): void
    {
        // CoursesettingsPermissions (visibility, unlisted, download)
        if ($courseSetting = CoursesettingsPermissions::where('course_id', $courseId)->first()) {
            $this->video->visibility = $courseSetting->visibility;
            $this->video->unlisted = $courseSetting->unlisted;
            $this->video->download = $courseSetting->downloadable;
            $this->video->save();
        }

        // CoursePermissions (maps to VideoPermission.permission_id)
        if ($coursePermission = CoursePermissions::where('course_id', $courseId)->first()) {
            VideoPermission::updateOrCreate(
                ['video_id' => $this->video->id],
                ['permission_id' => (int)$coursePermission->permission_id]
            );
        }
    }

    /**
     * Replace course admins (from Daisy) for this presentation.
     * Source of truth is Daisy "course responsible". Only SU.SE realm is allowed.
     */
    private function syncCourseAdmins(int $courseId, string $videoId): void
    {
        try {
            $responsibles = (array)$this->daisy->getDaisyCourseResponsible($courseId);
        } catch (Throwable $e) {
            Log::warning('Daisy getDaisyCourseResponsible failed', [
                'course_id' => $courseId,
                'error' => $e->getMessage(),
            ]);
            $responsibles = [];
        }

        $payload = [];

        foreach ($responsibles as $responsible) {
            $personId = (int)($responsible['id'] ?? 0);
            $firstName = trim((string)($responsible['firstName'] ?? ''));
            $lastName = trim((string)($responsible['lastName'] ?? ''));
            $fullName = trim($firstName . ' ' . $lastName);

            if ($personId <= 0) {
                continue;
            }

            // Temporary workaround to get usernames until Daisy endpoint improves
            try {
                $usernames = (array)$this->daisy->getDaisyUsername($personId);
            } catch (Throwable $e) {
                Log::info('Daisy getDaisyUsername failed', [
                    'person_id' => $personId,
                    'error' => $e->getMessage(),
                ]);
                $usernames = [];
            }

            foreach ($usernames as $u) {
                if (($u['realm'] ?? null) !== 'SU.SE') {
                    continue;
                }

                $username = (string)($u['username'] ?? '');
                if ($username === '') {
                    continue;
                }

                $payload[] = [
                    'video_id' => $videoId,
                    'username' => $username,
                    'name' => $fullName,
                    'permission' => 'delete',
                ];
            }
        }

        // Replace old admins with fresh set, atomically.
        CourseadminPermission::where('video_id', $videoId)->delete();

        if (!empty($payload)) {
            // upsert by unique (video_id, username) if you have a unique index; otherwise updateOrCreate in loop
            CourseadminPermission::upsert(
                $payload,
                ['video_id', 'username'],
                ['name', 'permission']
            );
        }
    }

    /**
     * Parse strings like "HT24", "vt24", "HT2025" to ['HT', 2024|2025].
     * Falls back conservatively if pattern is unexpected.
     *
     * @return array{0:string,1:int} [semester ('VT'|'HT'), year (four-digit)]
     */
    private function parseSemester(string $raw): array
    {
        $raw = Str::upper(trim($raw));

        // First two letters should be VT/HT; rest is year (2 or 4 digits).
        $letters = Str::substr($raw, 0, 2);
        $digits = preg_replace('/\D+/', '', Str::substr($raw, 2));

        $semester = in_array($letters, ['VT', 'HT'], true) ? $letters : 'VT';

        // Normalize year to 4 digits
        $year = 0;
        if ($digits !== '') {
            if (strlen($digits) === 2) {
                // Assume 20xx for 00–69; 19xx otherwise (tweak as needed)
                $yy = (int)$digits;
                $year = ($yy <= 69) ? 2000 + $yy : 1900 + $yy;
            } elseif (strlen($digits) === 4) {
                $year = (int)$digits;
            }
        }

        // Defensive fallback: if still zero, try to read current year
        if ($year === 0) {
            $year = (int)date('Y');
        }

        return [$semester, $year];
    }

    private function convertDaisySemester(string $semester): int
    {
        return match ($semester) {
            'VT' => 1,
            'HT' => 2,
            default => 0,
        };
    }
}
