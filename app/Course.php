<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @mixin IdeHelperCourse
 */
class Course extends Model implements Searchable
{
    use SearchableTrait;

    protected $fillable = ['name', 'designation'];
    protected $searchable = [
        'columns' => [
            'name' => 5,
            'designation' => 10
        ]
    ];
    protected $appends = ['type'];

    public function getTypeAttribute(): string
    {
        return 'course';
    }

    public function video_course(): HasMany
    {
        return $this->hasMany(VideoCourse::class);
    }

    public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoCourse::class, 'course_id', 'id', 'id', 'video_id')->get();
    }

    public function userVideos($user): Collection
    {
        return $this->hasManyThrough(Video::class, VideoCourse::class, 'course_id', 'id', 'id', 'video_id')->orderBy('created_at', 'desc')->get()->filter(function ($video) use ($user) {
            foreach ($video->presenters() as $presenter) {
                // Dummy value to test the output.
                return isset($user->id) ? ($presenter->id == $user->id) : false;
            }
        });
    }

    public function getSearchResult(): SearchResult
    {
        //$url = route('player', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            //$url
            $this->id
        );
    }
}
