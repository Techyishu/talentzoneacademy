<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HomepageVideo extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'video_url',
        'video_type',
        'thumbnail_path',
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
     * Scope to filter only active videos.
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
     * Get the embed URL for the video.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->video_type === 'youtube') {
            // Extract video ID from various YouTube URL formats
            preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
        }

        if ($this->video_type === 'vimeo') {
            // Extract video ID from Vimeo URL
            preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://player.vimeo.com/video/{$matches[1]}" : null;
        }

        if ($this->video_type === 'local') {
            return asset('uploads/videos/' . $this->video_url);
        }

        return $this->video_url;
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return asset('uploads/thumbnails/' . $this->thumbnail_path);
        }

        // For YouTube, we can use the default thumbnail
        if ($this->video_type === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg" : null;
        }

        return null;
    }
}
