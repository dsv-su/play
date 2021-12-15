<?php

namespace App;

use App\Services\Filters\Visibility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\URL;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Video extends Model implements Searchable
{
    use SearchableTrait;
    //UUID
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['presentation_id', 'title', 'thumb','creation','origin','notification_id', 'presenter', 'duration', 'thumb', 'category_id', 'description'];
    protected $table = 'videos';

    //
    protected $searchable = [
        'columns' => [
            'videos.title' => 10,
            'categories.category_name' => 5,
        ],
        'joins' => [
            'categories' => ['videos.category_id', 'categories.id'],
        ],
    ];

    //Playlist
    protected $appends = ['link', 'type'];

    public function getLinkAttribute(): string
    {
        return $this->attributes['link'] = URL::to('/') . '/player/' . $this->id;
    }

    public function getThumbAttribute(): string
    {
        return  $this->base_uri() . '/' . $this->id . '/' . $this->attributes['thumb'];
    }

    public function getTypeAttribute(): string
    {
        return 'video';
    }

    public function video_stat(): HasMany
    {
        return $this->hasMany(VideoStat::class);
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

    public function getRecordedDate(): string
    {
        return Carbon::parse(json_decode($this->presentation)->recorded)->format('Y-m-d H:i:s') ?? '';
    }

    public function tags(): Collection
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')->get();
    }

    public function has_tag($tag_id): bool
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')->where('tag_id', $tag_id)->count()>0;
    }

    public function courses(): Collection
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->get();
    }

    public function has_course($course_id): bool
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->where('course_id', $course_id)->count()>0;
    }

    /*public function courses(): Collection
    {
        return $this->belongsToMany(Course::class, VideoCourse::class, 'video_id', 'course_id')->get();
    }*/

    public function presenters():Collection
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

    public function getPresentationDate() {
        $presentation = json_decode($this->presentation);
        if ($presentation) {
            return $presentation->creation ?? strtotime($presentation->recorded);
        }
        return null;
    }

    public function permissions():Collection
    {
        return $this->belongsToMany(Permission::class, 'video_permissions', 'video_id', 'permission_id')->get();
    }

    //Overall group permissions
    public function status(): HasMany
    {
        return $this->hasMany(VideoPermission::class);
    }

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class);
    }

    public function ipermissions(): HasMany
    {
        return $this->hasMany(IndividualPermission::class);
    }

    public function coursepermissions(): HasMany
    {
        return $this->hasMany(CourseadminPermission::class);
    }

    public function getSearchResult(): SearchResult
    {
        // TODO: Implement getSearchResult() method.
    }

    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    //These flags should be refactored in the future as it would speed up by casting instead
    public function editable() {
        return app()->make('play_role') == 'Administrator' ||
            CourseadminPermission::where('username', app()->make('play_username'))->where('video_id', $this->id)->exists() ||
            IndividualPermission::where('username', app()->make('play_username'))->where('permission', 'edit')->exists();
    }

    public function deletable() {
        return app()->make('play_role') == 'Administrator' ||
            CourseadminPermission::where('username', app()->make('play_username'))->where('video_id', $this->id)->exists() ||
            IndividualPermission::where('username', app()->make('play_username'))->where('permission', 'delete')->exists();
    }
}
