<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperMediasitePresentation
 */
class MediasitePresentation extends Model
{
    protected $table = 'mediasite_presentations';
    protected $fillable = ['name', 'mediasite_id', 'mediasite_folder_id', 'video_id', 'status'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function folder()
    {
        return $this->belongsTo(MediasiteFolder::class);
    }
}
