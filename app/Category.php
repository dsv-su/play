<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @mixin IdeHelperCategory
 */
class Category extends Model implements Searchable
{
    use SearchableTrait;
    protected $primaryKey = 'id';
    protected $fillable = ['category_name'];
    protected $searchable = [
        'columns' => [
            'category_name' => 10
        ]
    ];
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

    public function video(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
