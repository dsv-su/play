<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperMediasiteFolder
 */
class MediasiteFolder extends Model
{
    protected $table = 'mediasite_folders';
    protected $fillable = ['name', 'mediasite_id', 'parent', 'type'];

    public function presentations(): HasMany
    {
        return $this->hasMany(MediasitePresentation::class);
    }

    public function completed()
    {
        $mediasitepresentations = $this->presentations;
        $videos = array();
        $somethingmissing = false;

        foreach ($this->presentations as $mp) {
            $video = Video::where('notification_id', $mp->id)->where('origin', 'mediasite')->first();
            if (!$video) {
                $somethingmissing = true;
            } else {
                $videos[] = $video;
            }
        }

        if ($mediasitepresentations->count() == 0) {
            // Folder is empty
            return 3;
        } elseif (count($videos) == 0) {
            // Folder is not empty but there are no videos
            return 0;
        } elseif (!$somethingmissing) {
            // Folder is not empty and there are videos
            return 1;
        } else {
            // Folder is not empty but some videos are missing
            return 2;
        }
    }
}
