<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @mixin IdeHelperCategory
 */
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

    public function video()
    {
        return $this->hasMany(Video::class);
    }
}
