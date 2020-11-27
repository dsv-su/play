<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Nicolaslopezj\Searchable\SearchableTrait;


/**
 * @mixin IdeHelperVideo
 */
class Video extends Model implements Searchable
{
    use SearchableTrait;

    protected $fillable = ['presentation_id','title', 'tags', 'duration', 'thumb', 'course_id','category_id'];
    protected $searchable = [
        'columns' => [
            'videos.title' => 10,
            'videos.tags' => 10,
            'categories.category_name' => 5,
        ],
        'joins' => [
            'categories' => ['videos.category_id', 'categories.id'],
        ],
    ];
    protected $appends = ['link'];

    public function getLinkAttribute()
    {
        return $this->attributes['link'] = 'player/'.$this->id;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mediasite_presentation()
    {
        return $this->hasOne(MediasitePresentation::class);
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
