<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class ManualPresentation extends Model
{
    use HasFactory;
    protected $fillable = ['jobid', 'pkg_id', 'status', 'type', 'user','upload_dir', 'jobid', 'video_id',
        'subtitles', 'sublanguage', 'title', 'title_en', 'created', 'presenters', 'visibility', 'unlisted',
        'courses','daisy_courses', 'tags', 'thumb', 'permission', 'entitlement', 'description',
        'sources', 'autogenerate_subtitles', 'generate_subtitles', 'description', 'category_id'];

    protected $casts = [
        'presenters' => 'array',
        'tags' => 'array',
        'subtitles' => 'array',
        'courses' => 'array',
        'daisy_courses' => 'array',
        'sources' =>  'array',
        'generate_subtitles' =>  'array',
    ];

    public function getLangTitleAttribute(): string
    {
        return App::getLocale() === 'sv'
            ? $this->title
            : ($this->title_en ?? $this->title);
    }

    protected static function booted()
    {
        // Before insert: set initial values
        static::creating(function ($file) {
            $file->status   = $file->status   ?? 'init';
            $file->user     = $file->user     ?? app()->make('play_username');
            $file->user_email = $file->user_email ?? app()->make('play_email');
            $file->local    = $file->local    ?? Carbon::now()->format('Y-m-d') . '_' . Str::random(6);
            $file->upload_dir = $file->upload_dir ?? '';
            $file->title    = $file->title    ?? '';
            $file->title_en = $file->title_en ?? '';
            $file->presenters = $file->presenters ?? [];
            $file->tags = $file->tags ?? [];
            $file->courses = $file->courses ?? [];
            $file->daisy_courses = $file->daisy_courses ?? [];
            $file->thumb    = $file->thumb    ?? '';
            $file->created = $file->created ?? now()->format('Y-m-d');
            $file->duration = $file->duration ?? 0;
            $file->sources = $file->sources ?? [];
            $file->generate_subtitles = $file->generate_subtitles ?? [];
            $file->category_id = $file->category_id ?? 1;
        });

        // After insert: append the DB id to `local`
        static::created(function ($file) {
            $file->update(['local' => $file->local . $file->id]);
        });
    }

    public function setPresentersAttribute($value)
    {
        $this->attributes['presenters'] = json_encode($value);
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    public function setCoursesAttribute($value)
    {
        $this->attributes['courses'] = json_encode($value);
    }

    public function setSourcesAttribute($value)
    {
        $this->attributes['sources'] = json_encode((object) $value);
    }

}
