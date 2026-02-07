<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'slug',
        'title',
        'content',
        'meta_title',
        'meta_description',
    ];
}
