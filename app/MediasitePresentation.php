<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperMediasitePresentation
 */
class MediasitePresentation extends Model
{
    //UUID
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'mediasite_presentations';
    protected $fillable = ['id', 'status', 'user', 'video_id', 'mediasite_folder_id', 'title', 'presenters', 'created', 'duration', 'courses', 'tags', 'thumb', 'sources', 'description'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediasiteFolder::class);
    }
}
