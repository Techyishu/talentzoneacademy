<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use BelongsToSchool;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'category',
        'title',
        'image_path',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'display_order' => 'integer',
    ];
}
