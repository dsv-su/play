<?php

namespace App\Models;

use App\Models\Pivots\VideoCoursePivot;
use App\Models\Pivots\VideoPresenterPivot;
use App\Models\Pivots\VideoTagPivot;
use Carbon\Carbon;
use DirectoryTree\Metrics\HasMetrics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use Searchable, HasMetrics;

    //UUID
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    //TODO Remove presentation attribute
    protected $fillable = [
        'id', 'title', 'title_en', 'thumb', 'creation', 'origin', 'notification_id', 'subtitles', 'state',
        'presenter', 'duration', 'thumb', 'category_id', 'description', 'visibility', 'unlisted', 'sources', 'presentation',
        'progress'
    ];
    protected $table = 'videos';

    //Playlist
    protected $appends = ['link', 'type', 'progress'];

    protected $casts = [
        'permission_type' => 'string',
        'edit' => 'boolean',
        'delete' => 'boolean',
        'visibility' => 'boolean',
        'unlisted'   => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getProgressAttribute()
    {
        return optional($this->pending)->progress;
    }

    public function pending()
    {
        return $this->hasOne(Pending::class, 'video_id');
    }

    public function tagsRelation(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')
            ->using(VideoTagPivot::class)
            ->withTimestamps();
    }

    public function presenterRelation(): BelongsToMany
    {
        return $this->belongsToMany(Presenter::class, 'video_presenters', 'video_id', 'presenter_id')
            ->using(VideoPresenterPivot::class)
            ->withTimestamps();
    }

    public function coursesRelation(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')
            ->using(VideoCoursePivot::class)
            ->withTimestamps();
    }

    public function videoCourseRelation(): HasMany
    {
        return $this->hasMany(VideoCourse::class);
    }

    public function videoTagRelation(): HasMany
    {
        return $this->hasMany(VideoTag::class);
    }

    // Scout index name
    public function searchableAs(): string
    {
        return 'videos';
    }

    public function shouldBeSearchable(): bool
    {
        // Only index when visible AND not unlisted
        return $this->visibility === true && $this->unlisted === false;
    }

    public function reindexForSearch(): void
    {
        if ($this->shouldBeSearchable()) {
            $this->searchable();
        } else {
            $this->unsearchable();
        }
    }

    // Eager-load ONLY when Scout does a bulk import
    public function makeAllSearchableUsing($query)
    {
        return $query->with(['tagsRelation:id,name', 'coursesRelation:id,name,designation', 'presenterRelation:id,name,username']);
    }

    // What gets indexed in Typesense
    public function toSearchableArray(): array
    {
        // Ensure relations are loaded for single-record indexing paths
        $this->loadMissing(['tagsRelation:id,name',
                            'coursesRelation:id,name,designation',
                            'presenterRelation:id,name,username']);

        return [
            'id'                    => (string) $this->getKey(),
            'uuid'                  => (string) $this->getKey(),
            'title'                 => (string) $this->title,
            'title_en'              => (string) $this->title_en,
            'description'           => (string) ($this->description ?? ''),
            'tag_names'             => $this->tagsRelation->pluck('name')->filter()->values()->all(),
            'course_names'          => $this->coursesRelation->pluck('name')->filter()->values()->all(),
            'course_designation'    => $this->coursesRelation->pluck('designation')->filter()->values()->all(),
            'presenter_names'       => $this->presenterRelation->pluck('name')->filter()->values()->all(),
            'presenter_usernames'   => $this->presenterRelation->pluck('username')->filter()->values()->all(),
            'tag_ids'               => $this->tagsRelation->pluck('id')->values()->all(),
            'course_ids'            => $this->coursesRelation->pluck('id')->values()->all(),
            'presenter_ids'         => $this->presenterRelation->pluck('id')->values()->all(),
            'published_at_ts'       => $this->published_at?->timestamp ?? 0,
            'visibility'            => $this->visibility ? 1 : 0,
            'unlisted'              => $this->unlisted ? 1 : 0,
        ];
    }

    //Keep index fresh when the Video itself is saved
    protected static function booted(): void
    {
        static::saved(fn (self $video) => $video->searchable());
    }
    //end typesense

    public function getLinkAttribute(): string
    {
        if (!$playlist = VideoCourse::where('video_id', $this->id)->first()) {
            //No playlist
            //return $this->attributes['link'] = URL::to('/') . '/multiplayer?p=' . $this->id;
            return $this->attributes['link'] = URL::to('/') . '/multiplayer_ce?p=' . $this->id;
        } else {
            //return $this->attributes['link'] = URL::to('/') . '/multiplayer?p=' . $this->id . '&l=' . $playlist->course_id;
            return $this->attributes['link'] = URL::to('/') . '/multiplayer_ce?p=' . $this->id . '&l=' . $playlist->course_id;
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

    public function videoStats(): HasOne
    {
        return $this->hasOne(VideoStat::class);
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
        if (!$this->creation) {
            return '';
        }

        return Carbon::createFromTimestamp((int) $this->creation)->format('M d, Y');
    }


    //New
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id')
            ->withTimestamps();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')
            ->withTimestamps();

    }
    public function presenters(): BelongsToMany
    {
        return $this->belongsToMany(Presenter::class, 'video_presenters', 'video_id', 'presenter_id')
            ->withTimestamps();
    }

    public function videoCourse(): HasMany
    {
        return $this->hasMany(VideoCourse::class);
    }

    public function hasCourseDesignation($designation)
    {
        foreach ($this->courses as $course) {
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

    public function has_course($course_id): bool
    {
        return $this->belongsToMany(Course::class, 'video_courses', 'video_id', 'course_id')->where('course_id', $course_id)->count() > 0;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPresentationDate()
    {
        $presentation = json_decode($this->presentation);
        if ($presentation) {
            return $presentation->creation ?? strtotime($presentation->recorded);
        }
        return null;
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'video_permissions', 'video_id', 'permission_id')
            ->withTimestamps();
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

    public function individualPermissions(): HasMany
    {
        return $this->hasMany(IndividualPermission::class, 'video_id', 'id');
    }

    public function coursepermissions(): HasMany
    {
        return $this->hasMany(CourseadminPermission::class);
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

    /**
     * @return array
     */
    public function getUniqueStudyAdminCat()
    {
        $categories = [];
        if (!$this->video_course->isEmpty()) {
            if($this->category->category_name == 'Studieadmin') {
                $category = $this->category->category_name;
                if (!in_array($category, $categories)) {
                    $categories[] = $category;
                }
            }
        }
        return $categories;
    }

    public function getUniqueNextilearnCat()
    {
        $categories = [];
        if (!$this->video_course->isEmpty()) {
            if($this->category->category_name == 'Nextilearn') {
                $category = $this->category->category_name;
                if (!in_array($category, $categories)) {
                    $categories[] = $category;
                }
            }
        }
        return $categories;
    }

}
