<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class ManualPresentation extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'user','base', 'title', 'title_en', 'creation', 'presenters', 'courses','daisy_courses', 'tags', 'thumb','permission', 'entitlement', 'sources', 'description'];

    protected $casts = [
        'presenters' => 'array',
        'tags' => 'array',
        'courses' => 'array',
        'daisy_courses' => 'array',
        'sources' =>  'array',
    ];

    public function getLangTitleAttribute(): string
    {
        if (Lang::locale() == 'swe') {
            return $this->title;
        } else {
            return $this->title_en ?: $this->title;
        }

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
        $this->attributes['sources'] = json_encode($value);
    }



}
