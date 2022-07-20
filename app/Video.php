<?php

namespace App;

use App\Services\Filters\Visibility;
use App\Services\Video\TitleObject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Lang;
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

    protected $fillable = ['presentation_id', 'title', 'title_en', 'thumb', 'creation', 'origin', 'notification_id', 'presenter', 'duration', 'thumb', 'category_id', 'description'];
    protected $table = 'videos';

    //
    protected $searchable = [
        'columns' => [
            'videos.title' => 10,
            'videos.title_en' => 9,
            'categories.category_name' => 5,
        ],
        'joins' => [
            'categories' => ['videos.category_id', 'categories.id'],
        ],
    ];

    //Playlist
    protected $appends = ['link', 'type'];

    protected $casts = [
        'permission_type' => 'string',
        'edit' => 'boolean',
        'delete' => 'boolean',
    ];

    public function getLinkAttribute(): string
    {
        if (!$playlist = VideoCourse::where('video_id', $this->id)->first()) {
            //No playlist
            return $this->attributes['link'] = URL::to('/') . '/multiplayer?p=' . $this->id;
        } else {
            return $this->attributes['link'] = URL::to('/') . '/multiplayer?p=' . $this->id . '&l=' . $playlist->course_id;
        }
        //return $this->attributes['link'] = URL::to('/') . '/player/' . $this->id;
    }

    public function getLangTitleAttribute(): string
    {
        if (Lang::locale() == 'swe') {
            return $this->title;
        } else {
            return $this->title_en ?: $this->title;
        }
    }

    public function getThumbAttribute(): string
    {
        return $this->base_uri() . '/' . $this->id . '/' . $this->attributes['thumb'];
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

    public function getCreationDate(): string
    {
        return Carbon::createFromTimestamp($this->creation)->format('M d, Y');
    }

    public function tags(): Collection
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')->get();
    }

    public function hasCourseDesignation($designation)
    {
        foreach ($this->courses() as $course) {
            if ($course->designation == $designation) {
                return true;
            }
        }
        return false;
    }

    public function has_tag($tag_id): bool
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')->where('tag_id', $tag_id)->count() > 0;
    }

    public function courses(): Collection
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->get();
    }

    public function has_course($course_id): bool
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->where('course_id', $course_id)->count() > 0;
    }

    /*public function courses(): Collection
    {
        return $this->belongsToMany(Course::class, VideoCourse::class, 'video_id', 'course_id')->get();
    }*/

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

    public function getPresentationDate()
    {
        $presentation = json_decode($this->presentation);
        if ($presentation) {
            return $presentation->creation ?? strtotime($presentation->recorded);
        }
        return null;
    }

    public function permissions(): Collection
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

    /**
     * @return array
     */
    public function getUniqueDesignations()
    {
        $designations = [];
        if (!$this->video_course->isEmpty()) {
            foreach ($this->video_course as $vc) {
                $designation = Course::find($vc->course_id)->designation;
                if (!in_array($designation, $designations)) {
                    $designations[] = $designation;
                }
            }
        }
        return $designations;
    }

}
