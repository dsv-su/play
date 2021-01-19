<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;
    protected $fillable = ['presentation_id', 'local','base','title','creation', 'presenters', 'courses', 'tags', 'thumb','permission', 'entitlement', 'sources'];

    protected $casts = [
        'presenters' => 'array',
        'tags' => 'array',
        'courses' => 'array',
        'sources' =>  'array',
    ];

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
