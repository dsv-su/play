<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['content', 'content_sv', 'visible', 'visible_for_staff', 'visible_for_student', 'link_url', 'link_text'];
}
