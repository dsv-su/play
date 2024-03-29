<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPermission extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'notification_id', 'reference_id', 'permission_id', 'type'];

    /**
     * Get the permission that owns the video.
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
