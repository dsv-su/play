<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperMediasiteFolder
 */
class MediasiteFolder extends Model
{
    protected $table = 'mediasite_folders';
    protected $fillable = ['name', 'mediasite_id', 'parent', 'type'];

    public function presentations()
    {
        return $this->hasMany(MediasitePresentation::class);
    }
}
