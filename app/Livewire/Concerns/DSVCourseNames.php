<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;
use App\Models\Course;
use Illuminate\Support\Arr;

trait DSVCourseNames
{
    #[Computed]
    public function courseTitles(): array
    {
        $locale = app()->getLocale();

        // 1) Collect numeric course IDs from the grouped keys
        $courseIds = collect($this->videos)
            ->keys()
            ->filter(fn($k) => is_numeric($k))
            ->map(fn($k) => (int)$k)
            ->values();

        // 2) Fetch the courses in ONE query (no need to touch the videos() relation)
        $courses = \App\Models\Course::whereIn('id', $courseIds)
            ->get(['id', 'designation', 'semester', 'year', 'name', 'name_en']);

        // 3) Build a map of id => title
        $courseTitles = $courses->mapWithKeys(function ($c) use ($locale) {
            $name = $locale === 'sv' ? $c->name : $c->name_en;
            return [
                $c->id => "{$c->designation} {$c->semester}{$c->year} — {$name}",
            ];
        })->all();

        // 4) Add a fallback title for the "no course" bucket
        $noCourseKey = 'nocourse';          // or 999999 if that’s what your grouping uses
        $courseTitles[$noCourseKey] = $locale === 'sv' ? 'Presentationer' : 'Presentations';

        return $courseTitles;
    }

}
