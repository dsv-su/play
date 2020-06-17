<?php
namespace App;

use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class CategorySearchAspect extends SearchAspect
{
    public static $searchType = 'Category';

    public function getResults(string $term): Collection
    {
        return Category::query()
            ->where('category_name','LIKE', "%{$term}%")
            ->get();

    }
}
