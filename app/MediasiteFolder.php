<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
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
}
