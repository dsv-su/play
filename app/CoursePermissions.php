<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePermissions extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'permission_id', 'type'];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
