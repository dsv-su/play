<?php

namespace App\Models;

use App\Services\Daisy\DaisyAPI;
use App\Services\Daisy\DaisyIntegration;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;


/**
 * @mixin IdeHelperCourse
 */
class Course extends Model
{
    use Searchable;

    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'name_en', 'designation', 'semester', 'year'];

    protected $appends = ['type'];

    // Parallel relation methods
    public function videosRelation(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_courses', 'course_id', 'video_id')
            ->withTimestamps();
    }

    public function tagsRelation(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'course_tags', 'course_id', 'tag_id')
            ->withTimestamps();
    }

    protected static function booted(): void
    {
        static::saved(function (Course $course) {
            $course->videosRelation()->get()->each->searchable();
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id'          => (string) $this->id,
            'name'        => (string) $this->name,
            'designation' => (string) ($this->designation ?? ''),
            'semester' => (string) ($this->semester ?? ''),
        ];
    }

    public function getTypeAttribute(): string
    {
        return 'course';
    }

    public function video_course(): HasMany
    {
        return $this->hasMany(VideoCourse::class);
    }

    /*public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoCourse::class, 'course_id', 'id', 'id', 'video_id')->get();
    }*/

    public function videos(): BelongsToMany {
        return $this->belongsToMany(Video::class, 'video_courses', 'course_id', 'video_id')->withTimestamps();
    }

    public function tags(): Collection
    {
        return $this->belongsToMany(Tag::class, 'course_tags', 'course_id', 'tag_id')->get();
    }

    public function responsible()
    {
        $daisy = new DaisyIntegration();
        return $daisy->getDaisyCourseResponsible($this->id);
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

    public function permissions(): Collection
    {
        return $this->belongsToMany(Permission::class, 'course_permissions', 'course_id', 'permission_id')->get();
    }

    public function userpermissions(): HasMany
    {
        return $this->hasMany(CoursesettingsUsers::class);
    }

    public function coursesettings(): HasMany
    {
        return $this->hasMany(CoursesettingsPermissions::class);
    }

    /**
     * @throws BindingResolutionException
     */
    public function userPermission() {
        $username = app()->make('play_username');
        $daisy_courses_ids = [];
        if (app()->make('play_role') != 'Administrator') {

            // Use cache
            $daisy_courses_ids = Cache::remember($username, 3600, function () use ($username){
                // Show only courses that you have permission to
                //Override if local
                if(!app()->environment('local')) {
                    $daisy = new DaisyAPI();
                    $daisyPersonID = $daisy->getDaisyPersonId($username);
                    // Get all courses where user is courseadmin
                    if ($daisy_courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
                        return array_map(function ($d) {
                            return $d['id'];
                        }, $daisy_courses);
                    } else {
                        return [];
                    }
                } else {
                    return [];
                }

            });
        }

        if (in_array($this->id, $daisy_courses_ids) || app()->make('play_role') == 'Administrator') {
            $user_permission = 'delete';
        } else {
            $coursesettingpermission = CoursesettingsUsers::where('course_id', $this->id)->where('username', $username)->first();
            $user_permission = $coursesettingpermission ? $coursesettingpermission->permission : '';
        }

        return $user_permission;
    }
}
