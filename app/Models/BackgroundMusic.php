<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BackgroundMusic extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'background_music';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'file_path',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope to filter only active music.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by display order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order');
    }

    /**
     * Get the full URL for the music file.
     */
    public function getFileUrlAttribute(): string
    {
        return asset('uploads/music/' . $this->file_path);
    }
}
