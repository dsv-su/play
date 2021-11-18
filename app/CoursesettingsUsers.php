<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoursesettingsUsers extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'username', 'name', 'permission'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
