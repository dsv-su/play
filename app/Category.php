<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends Model implements Searchable
{
    protected $fillable = ['category_name'];

    public function getSearchResult(): SearchResult
    {
        //$url = route('categories.show', $this->id);

        return new SearchResult(
            $this,
            $this->category_name,
            //$url
            $this->id
        );
    }
}
