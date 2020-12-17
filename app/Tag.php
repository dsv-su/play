<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $fillable = ['name'];
    protected $searchable = [
        'columns' => [
            'name' => 10
        ]
    ];

    protected $appends = ['type'];

    public function getTypeAttribute(): string
    {
        return 'tag';
    }

    public function videos() {
        $this->belongsToMany(Video::class);
    }

}
