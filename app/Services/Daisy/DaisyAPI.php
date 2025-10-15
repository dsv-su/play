<?php

declare(strict_types=1);

namespace App\Services\Daisy;

use RuntimeException;

class DaisyAPI extends DaisyIntegration
{
    /**
     * Load courses for a list of semester codes (e.g. ['20252','20251', ...]).
     * Returns a flat array of course rows.
     *
     * @param array<int,string> $semesterCodes
     * @return array<int,array<string,mixed>>
     */
    public function loadCourses(array $semesterCodes): array
    {
        $all = [];

        foreach ($semesterCodes as $code) {
            $rows = $this->getJson("courseSegment?semester={$code}");
            if (!is_array($rows) || !$rows) {
                continue;
            }
            // Normalize shape if needed, then merge
            foreach ($rows as $row) {
                if (isset($row['id'])) {
                    $all[] = $row;
                }
            }
        }

        // Example: newest-first by id (desc). Adjust if you prefer semester/other sorting.
        usort($all, static fn($a, $b) => ($b['id'] ?? 0) <=> ($a['id'] ?? 0));
        return $all;
    }

    /**
     * Cheap O(1) check: does an employee record exist for this person id?
     * Avoids downloading the whole /employee list.
     */
    public function checkifEmployee(int|string $id): bool
    {
        try {
            // If this endpoint exists, it’s ideal. If the API only allows username lookups,
            // you can fall back to contributions or person->employment settings.
            $this->getJson("employee/{$id}");
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Prefer returning the employee resource; fall back to person if needed.
     * Returns an associative array with whatever the API provides.
     */
    public function getDaisyEmployee(string $username): array
    {
        $u = "{$username}@su.se";

        // Try the employee endpoint first (richer employment info)
        try {
            $emp = $this->getJson("employee/username/{$u}");
            if (is_array($emp) && $emp) {
                return $emp;
            }
        } catch (\Throwable $e) {
            // ignore and fall through to person
        }

        // Fallback to person info
        return $this->getJson("person/username/{$u}");
    }

    /**
     * If you truly want settings, keep the settings endpoint.
     * If you want the base person object, call person/{id}.
     */
    public function getDaisyPerson(int|string $id): array
    {
        return $this->getJson("person/{$id}/settings");
    }

    /**
     * Returns true if the person has ANY responsible course-admin contribution
     * between fromYear()..toYear(). This is stricter than "any contribution".
     */
    public function checkCourseAdmin(int|string $id): bool
    {
        $from = $this->fromYear() . '1';
        $to   = $this->toYear()   . '2';

        try {
            $contribs = $this->getJson("employee/{$id}/contributions?fromSemesterId={$from}&toSemesterId={$to}");
        } catch (\Throwable $e) {
            return false;
        }

        if (!is_array($contribs)) {
            return false;
        }

        foreach ($contribs as $c) {
            if (!empty($c['responsible'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * All courses for which the employee is marked 'responsible' within the configured range.
     * Returns an array of normalized rows (newest-first by instance id).
     *
     * @return array<int,array{name: string|null, name_en: string|null, id: int|null, semester: string|null, designation: string|null, responsible: bool}>
     */
    public function getDaisyEmployeeResponsibleCourses(int|string $id): array
    {
        $from = $this->fromYear() . '1';
        $to   = $this->toYear()   . '2';

        try {
            $contribs = $this->getJson("employee/{$id}/contributions?fromSemesterId={$from}&toSemesterId={$to}");
        } catch (\Throwable $e) {
            return [];
        }

        if (!is_array($contribs) || !$contribs) {
            return [];
        }

        $list = [];
        foreach ($contribs as $course) {
            $inst = $course['courseSegmentInstance'] ?? [];
            $isResponsible = !empty($course['responsible']);

            $list[] = [
                'name'        => $inst['name']['swedish']  ?? ($inst['name']['sv'] ?? null),
                'name_en'     => $inst['name']['english']  ?? ($inst['name']['en'] ?? null),
                'id'          => $inst['id']               ?? null,
                'semester'    => $inst['semesterId']       ?? null,
                'designation' => $inst['designation']      ?? null,
                'responsible' => (bool) $isResponsible,
            ];
        }

        // Sort newest-first by instance id (desc), nulls last
        usort($list, static function ($a, $b) {
            $ai = $a['id'] ?? -1;
            $bi = $b['id'] ?? -1;
            return $bi <=> $ai;
        });

        return $list;
    }

    /**
     * Retrieve ALL course segments across configured year range (fromYear..toYear),
     * ordered newest-first by id, querying HT then VT per year (to match your previous behavior).
     *
     * @return array<int,array<string,mixed>>
     */
    public function getDaisyCourses(): array
    {
        $from = (int) $this->fromYear();
        $to   = (int) $this->toYear();

        $years = [];
        for ($y = $to; $y >= $from; $y--) {
            $years[] = $y;
        }

        $all = [];
        foreach ($years as $year) {
            // Query HT(2) then VT(1) for that year
            foreach ([2, 1] as $term) {
                $rows = $this->getJson("courseSegment?semester={$year}{$term}");
                if (!is_array($rows) || !$rows) {
                    continue;
                }
                foreach ($rows as $row) {
                    if (isset($row['id'])) {
                        $all[] = $row;
                    }
                }
            }
        }

        // Newest-first by id (desc)
        usort($all, static fn($a, $b) => ($b['id'] ?? 0) <=> ($a['id'] ?? 0));
        return $all;
    }
}
