<?php
namespace App;

use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class CourseSearchAspect extends SearchAspect
{
    public static $searchType = 'Course';

    public function getResults(string $term): Collection
    {
        return Course::query()
            ->where('course_name','LIKE', "%{$term}%")
            ->get();

    }
}
