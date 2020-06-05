<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Video extends Model implements Searchable
{
    protected $fillable = ['title', 'length', 'source1', 'source2', 'source3', 'source4','course_id','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('player', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
