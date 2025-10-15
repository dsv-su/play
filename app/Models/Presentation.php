<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'presentation_id', 'local','base','status', 'resolution', 'title','creation', 'user', 'created',
        'duration', 'presenters', 'courses', 'tags', 'thumb','permission', 'entitlement', 'sources', 'description',
        'progress'
    ];

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
