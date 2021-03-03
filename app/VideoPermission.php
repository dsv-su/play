<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPermission extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'notification_id', 'permission_id', 'type'];
}
