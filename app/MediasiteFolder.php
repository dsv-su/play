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

        $somethingexist = $this->presentations->where('status', 'sent')->count();
        $return = 1;
        foreach ($this->presentations as $mp) {
            $videos = Video::where('notification_id', $mp->id);
            if ($mp->status != 'sent' || !$videos->count()) {
                $return = 0;
            }
        }

        if (!$this->presentations->count()) {
            return 3;
        }

        if ($return == 0) {
            if ($somethingexist>0) {
                return 2;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }
}
