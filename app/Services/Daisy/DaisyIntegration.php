<?php

declare(strict_types=1);

namespace App\Services\Daisy;

use App\Course;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DaisyIntegration
{
    private Client $client;

    /** @var array<string, mixed> */
    private array $config;

    public function __construct(?Client $client = null)
    {
        $this->config = $this->loadConfig();

        $this->client = $client ?? new Client([
                'base_uri' => rtrim($this->config['daisy_url'], '/') . '/',
                'auth'     => [$this->config['daisy_username'], $this->config['daisy_password']],
                'timeout'  => 10.0,
            ]);
    }

    /**
     * Core GET helper.
     *
     * @param string      $endpoint e.g. 'courseSegment?semester=20252'
     * @param null|string $accept   'json' or 'xml' (optional)
     * @return string raw body
     */
    private function get(string $endpoint, ?string $accept = 'json'): string
    {
        $endpoint = ltrim($endpoint, '/');

        $headers = [];
        if ($accept) {
            $mime = $accept === 'json' ? 'application/json' : "application/{$accept}";
            $headers['Accept'] = $mime;
        }

        try {
            $res = $this->client->request('GET', $endpoint, ['headers' => $headers]);
            return (string) $res->getBody();
        } catch (ClientException|RequestException $e) {
            // app()->make('init')->check_system();
            // abort(404);

            throw new RuntimeException("Daisy API request failed for '{$endpoint}'", previous: $e);
        }
    }

    /**
     * @template T of array
     * @param string $endpoint
     * @return array<mixed>
     */
    protected function getJson(string $endpoint): array
    {
        $body = $this->get($endpoint, 'json');
        $decoded = json_decode($body, true);

        if (!is_array($decoded)) {
            throw new RuntimeException("Invalid JSON from Daisy endpoint: {$endpoint}");
        }
        return $decoded;
    }

    /** Read INI once and validate required keys. */
    private function loadConfig(): array
    {
        $path = base_path() . '/systemconfig/play.ini';
        if (!file_exists($path)) {
            $path = base_path() . '/systemconfig/play.ini.example';
            if (!file_exists($path)) {
                // abort(510);
                throw new RuntimeException('Missing Daisy configuration.');
            }
        }

        $ini = parse_ini_file($path, true);
        if (!is_array($ini) || !isset($ini['Daisy'])) {
            throw new RuntimeException('Invalid Daisy configuration file.');
        }

        $req = ['daisy_url','daisy_username','daisy_password','from_year','to_year','start_date'];
        foreach ($req as $key) {
            if (!array_key_exists($key, $ini['Daisy'])) {
                throw new RuntimeException("Daisy configuration missing key: {$key}");
            }
        }

        return [
            'daisy_url'      => (string) $ini['Daisy']['daisy_url'],
            'daisy_username' => (string) $ini['Daisy']['daisy_username'],
            'daisy_password' => (string) $ini['Daisy']['daisy_password'],
            'from_year'      => (string) $ini['Daisy']['from_year'],
            'to_year'        => (string) $ini['Daisy']['to_year'],
            'start_date'     => (string) $ini['Daisy']['start_date'],
        ];
    }

    protected function fromYear(): string
    {
        return $this->config['from_year'];
    }

    protected function toYear(): string
    {
        return $this->config['to_year'];
    }

    protected function semesterCode(string $year, string $term): string
    {
        // VT = 1, HT = 2
        $suffix = $term === 'VT' ? '1' : '2';
        return "{$year}{$suffix}";
    }

    // -------------------------
    // Daisy API
    // -------------------------

    public function getDaisyPersonId(string $username): ?int
    {
        $data = $this->getJson("person/username/{$username}@su.se");
        return $data['id'] ?? null;
    }

    public function getCourseSegment(int|string $id): array
    {
        return $this->getJson("courseSegment/{$id}");
    }

    public function getCourse(string $designation, string $semester): array|false
    {
        $arr = $this->getJson("courseSegment?designation={$designation}&semester={$semester}");
        return $arr[0] ?? false;
    }

    public function getActiveEmployeeCourses(string $username): array
    {
        $emp = $this->getJson("employee/username/{$username}@su.se");
        $personId = $emp['person']['id'] ?? null;
        if (!$personId) return [];

        $from = $this->fromYear() . '1';
        $to   = $this->toYear()   . '2';

        $courses = $this->getJson("employee/{$personId}/contributions?fromSemesterId={$from}&toSemesterId={$to}");

        $ids = [];
        foreach ($courses as $instance) {
            $ids[] = $instance['courseSegmentInstance']['id'] ?? null;
        }
        return array_values(array_filter($ids, fn($v) => $v !== null));
    }

    public function getActiveEmployeeSemesters(string $username): array
    {
        $emp = $this->getJson("employee/username/{$username}@su.se");
        $personId = $emp['person']['id'] ?? null;
        if (!$personId) return [];

        $from = $this->fromYear() . '1';
        $to   = $this->toYear()   . '2';

        $courses = $this->getJson("employee/{$personId}/contributions?fromSemesterId={$from}&toSemesterId={$to}");

        // Keep last 6, unique by semester value, sorted descending by instance id (as before)
        $pairs = [];
        foreach ($courses as $instance) {
            $id = $instance['courseSegmentInstance']['id'] ?? null;
            $sem = $instance['courseSegmentInstance']['semesterId'] ?? null;
            if ($id !== null && $sem !== null) {
                $pairs[$id] = $sem;
            }
        }

        if (!$pairs) return [];

        krsort($pairs); // by instance id desc
        // unique by value (semester id) while preserving order
        $seen = [];
        $out = [];
        foreach ($pairs as $id => $sem) {
            if (in_array($sem, $seen, true)) continue;
            $seen[] = $sem;
            $out[$id] = $sem;
            if (count($out) >= 6) break;
        }
        return $out;
    }

    public function getActiveEmployeeDesignations(string $username): array
    {
        $emp = $this->getJson("employee/username/{$username}@su.se");
        $personId = $emp['person']['id'] ?? null;
        if (!$personId) return [];

        $from = $this->fromYear() . '1';
        $to   = $this->toYear()   . '2';

        $courses = $this->getJson("employee/{$personId}/contributions?fromSemesterId={$from}&toSemesterId={$to}");

        $pairs = [];
        foreach ($courses as $instance) {
            $id = $instance['courseSegmentInstance']['id'] ?? null;
            $designation = $instance['courseSegmentInstance']['designation'] ?? null;
            if ($id !== null && $designation !== null) {
                $pairs[$id] = $designation;
            }
        }

        if (!$pairs) return [];

        krsort($pairs);
        $seen = [];
        $out = [];
        foreach ($pairs as $id => $des) {
            if (in_array($des, $seen, true)) continue;
            $seen[] = $des;
            $out[$id] = $des;
            if (count($out) >= 6) break;
        }
        return $out;
    }

    public function getActiveCoursesHT(): array
    {
        $semester = $this->semesterCode($this->toYear(), 'HT');
        return $this->courseIdsForSemester($semester);
    }

    public function getActiveCoursesVT(): array
    {
        $semester = $this->semesterCode($this->toYear(), 'VT');
        return $this->courseIdsForSemester($semester);
    }

    public function getPreviousYearCoursesHT(): array
    {
        $year = (string) ((int) $this->toYear() - 1);
        $semester = $this->semesterCode($year, 'HT');
        return $this->courseIdsForSemester($semester);
    }

    public function getPreviousYearCoursesVT(): array
    {
        $year = (string) ((int) $this->toYear() - 1);
        $semester = $this->semesterCode($year, 'VT');
        return $this->courseIdsForSemester($semester);
    }

    /** @return array<int> */
    private function courseIdsForSemester(string $semester): array
    {
        $arr = $this->getJson("courseSegment?semester={$semester}");
        if (!$arr) return [0];

        $ids = [];
        foreach ($arr as $row) {
            if (isset($row['id'])) $ids[] = $row['id'];
        }
        return $ids ?: [0];
    }

    public function getActiveStudentCourses(string $username): array
    {
        $person = $this->getJson("person/username/{$username}@su.se");
        $id = $person['id'] ?? null;
        if (!$id) return [];

        $instances = $this->getJson("person/{$id}/courseSegmentInstances");
        $ids = [];
        foreach ($instances as $inst) {
            if (isset($inst['id'])) $ids[] = $inst['id'];
        }
        rsort($ids);
        return $ids;
    }

    public function getActiveStudentDesignations(string $username): array
    {
        $person = $this->getJson("person/username/{$username}@su.se");
        $id = $person['id'] ?? null;
        if (!$id) return [];

        $instances = $this->getJson("person/{$id}/courseSegmentInstances");

        $pairs = [];
        foreach ($instances as $inst) {
            $iid = $inst['id'] ?? null;
            $designation = $inst['designation'] ?? null;
            if ($iid !== null && $designation !== null) {
                $pairs[$iid] = $designation;
            }
        }

        if (!$pairs) return [];

        krsort($pairs);
        $seen = [];
        $out = [];
        foreach ($pairs as $iid => $des) {
            if (in_array($des, $seen, true)) continue;
            $seen[] = $des;
            $out[$iid] = $des;
            if (count($out) >= 6) break;
        }
        return $out;
    }

    public function getDaisyCourseResponsible(int|string $id): array
    {
        $seg = $this->getJson("courseSegment/{$id}");

        $responsible = [];
        if (!empty($seg['contributors']) && is_array($seg['contributors'])) {
            foreach ($seg['contributors'] as $contrib) {
                if (!empty($contrib['responsible']) && !empty($contrib['personId'])) {
                    $person = $this->getJson("person/{$contrib['personId']}");
                    $responsible[] = $person;
                }
            }
        }
        return $responsible;
    }

    public function getDaisyUsername(int|string $id): array
    {
        return $this->getJson("person/{$id}/usernames");
    }

    public function init(?string $start_date = null): void
    {
        // Keep your explicit semester list (you can generate programmatically if you prefer)
        $endpoints = [
            'courseSegment?semester=20252',
            'courseSegment?semester=20251',
            'courseSegment?semester=20242',
            'courseSegment?semester=20241',
            'courseSegment?semester=20232',
            'courseSegment?semester=20231',
            'courseSegment?semester=20222',
            'courseSegment?semester=20221',
            'courseSegment?semester=20212',
            'courseSegment?semester=20211',
            'courseSegment?semester=20201',
            'courseSegment?semester=20202',
            'courseSegment?semester=20191',
            'courseSegment?semester=20192',
        ];

        foreach ($endpoints as $ep) {
            $rows = $this->getJson($ep);
            foreach ($rows as $row) {
                if (!isset($row['id'], $row['designation'], $row['semester'])) {
                    continue;
                }

                $isVT = substr((string) $row['semester'], 4) === '1';
                $year = substr((string) $row['semester'], 0, 4);
                $semester = $isVT ? 'VT' : 'HT';

                Course::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'designation' => $row['designation'],
                        'semester'    => $semester,
                        'year'        => $year,
                        'name'        => $row['name']    ?? null,
                        'name_en'     => $row['name_en'] ?? null,
                    ]
                );
            }
        }
    }

    public function refreshCourses(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->init($this->config['start_date']);
    }


    /**
     * ------------------------------------------
     * Working progress
     * ------------------------------------------
     */

    /**
     * Make semester codes like 20252, 20251, … in DESC order.
     * @param int    $fromYear inclusive (oldest)
     * @param int    $toYear   inclusive (newest)
     * @return array<int,string> e.g. ["20252","20251","20242",...]
     */
    private function makeSemesterCodesRange(int $fromYear, int $toYear): array
    {
        $codes = [];
        for ($y = $toYear; $y >= $fromYear; $y--) {
            // Newest first: HT (2) then VT (1)
            $codes[] = "{$y}2"; // HT
            $codes[] = "{$y}1"; // VT
        }
        return $codes;
    }

    /**
     * Last N semesters from a pivot year/term, inclusive. Default pivot = "current" toYear as HT.
     * @param int      $count how many codes to return (e.g. 14)
     * @param int|null $pivotYear defaults to (int)$this->toYear()
     * @param string   $pivotTerm 'HT' or 'VT' (default 'HT')
     */
    private function makeLastNSemesters(int $count, ?int $pivotYear = null, string $pivotTerm = 'HT'): array
    {
        $year = $pivotYear ?? (int)$this->toYear();
        $term = strtoupper($pivotTerm) === 'VT' ? 1 : 2;

        $codes = [];
        while (count($codes) < $count) {
            $codes[] = "{$year}{$term}";
            // step backward one term
            if ($term === 1) { // VT -> go to previous year's HT
                $term = 2;
                $year--;
            } else {           // HT -> same year VT
                $term = 1;
            }
        }
        return $codes;
    }

    /**
     * Build semesters from a start_date (YYYY-MM-DD). We include all semesters
     * whose code >= first semester that starts on/after start_date, up to toYear().
     * Assumes VT=1 (spring) starts in Jan, HT=2 (autumn) starts in Aug.
     */
    private function makeSemestersFromDate(string $startDate): array
    {
        $dt = new \DateTimeImmutable($startDate);
        $year = (int)$dt->format('Y');
        $month = (int)$dt->format('n');

        // Decide first semester at/after start_date
        // Jan–Jul => VT (1), Aug–Dec => HT (2)
        $firstTerm = ($month <= 7) ? 1 : 2;

        // Build ascending, then reverse to keep newest first
        $codes = [];
        $toYear = (int)$this->toYear();

        for ($y = $year; $y <= $toYear; $y++) {
            // for first year, start at firstTerm; afterwards both terms
            $terms = ($y === $year) ? [$firstTerm, ($firstTerm === 1 ? 2 : 1)] : [1, 2];
            foreach ($terms as $t) {
                $codes[] = "{$y}{$t}";
            }
        }

        // newest first: sort by code desc (string works because fixed width)
        rsort($codes);
        return $codes;
    }

    /*public function init(?string $start_date = null): void
    {
        $from = (int)$this->fromYear();
        $to   = (int)$this->toYear();

        $semesterCodes = $this->makeSemesterCodesRange($from, $to); // newest first

        foreach ($semesterCodes as $code) {
            $rows = $this->getJson("courseSegment?semester={$code}");
            foreach ($rows as $row) {
                if (!isset($row['id'], $row['designation'], $row['semester'])) {
                    continue;
                }
                $isVT = substr((string)$row['semester'], 4) === '1';
                $year = substr((string)$row['semester'], 0, 4);
                $semester = $isVT ? 'VT' : 'HT';

                \App\Course::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'designation' => $row['designation'],
                        'semester'    => $semester,
                        'year'        => $year,
                        'name'        => $row['name']    ?? null,
                        'name_en'     => $row['name_en'] ?? null,
                    ]
                );
            }
        }
    }*/

    //Last N Semesters
    /*public function init(?string $start_date = null): void
    {
        $codes = $this->makeLastNSemesters(14, (int)$this->toYear(), 'HT');

        foreach ($codes as $code) {
            $rows = $this->getJson("courseSegment?semester={$code}");
            foreach ($rows as $row) {
                if (!isset($row['id'], $row['designation'], $row['semester'])) {
                    continue;
                }
                $isVT = substr((string)$row['semester'], 4) === '1';
                $year = substr((string)$row['semester'], 0, 4);
                $semester = $isVT ? 'VT' : 'HT';

                \App\Course::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'designation' => $row['designation'],
                        'semester'    => $semester,
                        'year'        => $year,
                        'name'        => $row['name']    ?? null,
                        'name_en'     => $row['name_en'] ?? null,
                    ]
                );
            }
        }
    }*/

    //From start_date
    /*public function init(?string $start_date = null): void
    {
        $start = $start_date ?: $this->config['start_date']; // or $this->start_date()
        $codes = $this->makeSemestersFromDate($start);

        foreach ($codes as $code) {
            $rows = $this->getJson("courseSegment?semester={$code}");
            foreach ($rows as $row) {
                if (!isset($row['id'], $row['designation'], $row['semester'])) {
                    continue;
                }
                $isVT = substr((string)$row['semester'], 4) === '1';
                $year = substr((string)$row['semester'], 0, 4);
                $semester = $isVT ? 'VT' : 'HT';

                \App\Course::updateOrCreate(
                    ['id' => $row['id']],
                    [
                        'designation' => $row['designation'],
                        'semester'    => $semester,
                        'year'        => $year,
                        'name'        => $row['name']    ?? null,
                        'name_en'     => $row['name_en'] ?? null,
                    ]
                );
            }
        }
    }*/





}
