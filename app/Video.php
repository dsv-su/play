<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @mixin IdeHelperVideo
 */
class Video extends Model implements Searchable
{
    use SearchableTrait;

    protected $fillable = ['presentation_id', 'title', 'presenter', 'tags', 'duration', 'thumb', 'category_id'];
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

    protected $casts = [
        'tags' => 'array',
    ];

    public function getLinkAttribute()
    {
        return $this->attributes['link'] = URL::to('/') . '/player/' . $this->id;
    }

    public function video_presenter()
    {
        return $this->hasMany(VideoPresenter::class);
    }

    public function video_course()
    {
        return $this->hasMany(VideoCourse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mediasite_presentation()
    {
        return $this->hasOne(MediasitePresentation::class);
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
