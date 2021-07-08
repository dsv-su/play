<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['scope', 'entitlement'];
    /**
     * Get the videos for the permission.
     */

    /*public function videos()
    {
        return $this->hasMany(VideoPermission::class);
    }*/

    public function videos(): Collection
    {
        return $this->hasManyThrough(Video::class, VideoPermission::class, 'permission_id', 'id', 'id', 'video_id')->get();
    }
}
