<?php

namespace App\Services\VideoSearch;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class VideoSearchService
{
    /**
     * Returns: [courses, terms, presenters, tags, groupedVideos]
     * - $courses: array [designation => displayName] including 'nocourse'
     * - $terms: array of "semester+year"
     * - $presenters: array [username => name] sorted by name
     * - $tags: array of tag names (sorted)
     * - $groupedVideos: Collection keyed by course_id (999999 = no course)
     */
    public function performFiltering(Collection $videos, VideoFilters $filters): array
    {
        $requiresCourse = !empty($filters->courses) || !empty($filters->terms);
        $matchNoCourse  = \in_array('nocourse', $filters->courses ?? [], true);
        $requiresTags   = !empty($filters->tags);        // AND semantics
        $requiresPres   = !empty($filters->presenters);  // OR semantics

        $filtered = $videos->filter(function ($video) use (
            $requiresCourse, $filters, $matchNoCourse,
            $requiresTags, $requiresPres
        ) {
            // course/designation/semester
            if ($requiresCourse) {
                $courseColl = $video->courses;

                $hasCourseMatch =
                    ($matchNoCourse && $courseColl->isEmpty()) ||
                    $courseColl->contains(function ($course) use ($filters) {
                        $designationOk = empty($filters->courses) || \in_array($course->designation, $filters->courses, true);
                        $termKey       = $course->semester . $course->year;
                        $semesterOk    = empty($filters->terms) || \in_array($termKey, $filters->terms, true);
                        return $designationOk && $semesterOk;
                    });

                if (!$hasCourseMatch) {
                    return false;
                }
            }

            // tags (must contain all requested)
            if ($requiresTags) {
                $videoTagNames = $video->tags->pluck('name')->all();
                foreach ($filters->tags as $t) {
                    if (!\in_array($t, $videoTagNames, true)) {
                        return false;
                    }
                }
            }

            // presenters (any)
            if ($requiresPres) {
                $videoPresenterUsernames = $video->presenters->pluck('username')->all();
                if (!\array_intersect($filters->presenters, $videoPresenterUsernames)) {
                    return false;
                }
            }

            return true;
        });

        $videocourses    = $this->extractCourses($filtered);
        $videoterms      = $this->extractTerms($filtered);
        $videotags       = $this->extractTags($filtered);
        $videopresenters = $this->extractPresenters($filtered);
        $grouped         = $this->groupVideos($filtered);

        return [$videocourses, $videoterms, $videopresenters, $videotags, $grouped];
    }

    public function extractCourses(Collection $videos): array
    {
        $courses = ['nocourse' => __('No course association')];

        $videos->flatMap->courses
            ->unique('designation')
            ->each(function ($course) use (&$courses) {
                $courses[$course->designation] = Lang::locale() === 'swe'
                    ? $course->name
                    : $course->name_en;
            });

        return $courses;
    }

    public function extractTerms(Collection $videos): array
    {
        return $videos->flatMap->courses
            ->map(fn ($c) => $c->semester . $c->year)
            ->unique()
            ->values()
            ->all();
    }

    public function extractTags(Collection $videos): array
    {
        $tags = $videos->flatMap->tags
            ->pluck('name')
            ->unique()
            ->values()
            ->all();

        sort($tags);
        return $tags;
    }

    public function extractPresenters(Collection $videos): array
    {
        $presenters = $videos->flatMap->presenters
            ->unique('username')
            ->mapWithKeys(fn ($p) => [$p->username => $p->name])
            ->all();

        asort($presenters);
        return $presenters;
    }

    public function groupVideos(Collection $videos): Collection
    {
        return $videos
            ->flatMap(function ($video) {
                $pairs = $video->videoCourse->isNotEmpty()
                    ? $video->videoCourse->pluck('course_id')->map(fn ($id) => [$id, $video])
                    : collect([[999999, $video]]);
                return $pairs->map(fn ($pair) => ['key' => $pair[0], 'video' => $pair[1]]);
            })
            ->groupBy('key')
            ->map(fn ($group) => collect($group)->pluck('video')->unique('id')->sortByDesc('creation'))
            ->sortKeysDesc();
    }
}
