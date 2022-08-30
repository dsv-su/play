<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

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
    protected $fillable = ['id', 'status', 'user', 'video_id', 'mediasite_folder_id', 'title', 'visibility', 'presenters', 'created', 'duration', 'courses', 'tags', 'thumb', 'sources', 'description'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediasiteFolder::class);
    }

    public function getLangTitleAttribute(): string
    {
        // We need this to be the same as other presentation types, thus simply returning title attribute.
        return $this->title;
    }
}
