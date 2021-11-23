<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoursesettingsPermissions extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'visibility', 'downloadable', 'playback'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
