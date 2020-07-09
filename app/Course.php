<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Course extends Model implements Searchable
{
    protected $fillable = ['course_name', 'semester', 'year'];

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function getSearchResult(): SearchResult
    {
        //$url = route('player', $this->id);

        return new SearchResult(
            $this,
            $this->course_name,
            //$url
            $this->id
        );
    }
}
