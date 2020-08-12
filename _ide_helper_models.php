<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Category
 *
 * @property int $id
 * @property string $category_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Video[] $video
 * @property-read int|null $video_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent implements \Spatie\Searchable\Searchable {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Course
 *
 * @property int $id
 * @property string $course_name
 * @property string $semester
 * @property string $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Video[] $video
 * @property-read int|null $video_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereYear($value)
 */
	class Course extends \Eloquent implements \Spatie\Searchable\Searchable {}
}

namespace App{
/**
 * App\Video
 *
 * @property int $id
 * @property string $title
 * @property string $length
 * @property string|null $tags
 * @property string|null $image
 * @property string $source1
 * @property string|null $source2
 * @property string|null $source3
 * @property string|null $source4
 * @property int $course_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Category $category
 * @property-read \App\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSource1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSource2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSource3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSource4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereUpdatedAt($value)
 */
	class Video extends \Eloquent implements \Spatie\Searchable\Searchable {}
}

namespace App\Services{
/**
 * App\Services\AuthHandler
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\AuthHandler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\AuthHandler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\AuthHandler query()
 */
	class AuthHandler extends \Eloquent {}
}

namespace App\Services{
/**
 * App\Services\ConfigurationHandler
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\ConfigurationHandler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\ConfigurationHandler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Services\ConfigurationHandler query()
 */
	class ConfigurationHandler extends \Eloquent {}
}

