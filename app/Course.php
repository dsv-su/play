<?php

namespace App;

use App\Services\Daisy\DaisyAPI;
use App\Services\Daisy\DaisyIntegration;
use Illuminate\Contracts\Container\BindingResolutionException;
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
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'name_en', 'designation', 'semester', 'year'];
    protected $searchable = [
        'columns' => [
            'name' => 5,
            'name_en' => 6,
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
            // Show only courses that you have permission to
            $daisy = new DaisyAPI();
            $daisyPersonID = $daisy->getDaisyPersonId($username);
            // Get all courses where user is courseadmin
            if ($daisy_courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
                $daisy_courses_ids = array_map(function ($d) {
                    return $d['id'];
                }, $daisy_courses);
            }
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
