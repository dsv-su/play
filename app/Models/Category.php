<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['category_name'];

    protected $searchable = [
        'columns' => [
            'category_name' => 10,
        ],
    ];

    protected $appends = ['type'];

    public function getTypeAttribute(): string
    {
        return 'category';
    }

    public function video(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class);
    }
}
