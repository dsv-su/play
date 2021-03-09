<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * Get the videos for the permission.
     */
    public function videos()
    {
        return $this->hasMany(VideoPermission::class);
    }
}
