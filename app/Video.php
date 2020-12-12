<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function getLinkAttribute(): string
    {
        return $this->attributes['link'] = URL::to('/') . '/player/' . $this->id;
    }

    public function video_presenter(): HasMany
    {
        return $this->hasMany(VideoPresenter::class);
    }

    public function video_course(): HasMany
    {
        return $this->hasMany(VideoCourse::class);
    }

    public function video_tag(): HasMany
    {
        return $this->hasMany(VideoTag::class);
    }

    public function tags(): Collection
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')->get();
    }

    public function courses(): Collection
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->get();
    }

    public function presenters(): Collection
    {
        return $this->belongsToMany(Presenter::class, 'video_presenters', 'video_id', 'presenter_id')->get();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function mediasite_presentation(): HasOne
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
