<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'youtube_url',
        'status',
        'category',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationship with User (creator)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' ? 'success' : 'secondary';
    }

    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Hoạt động' : 'Không hoạt động';
    }

    // Helper methods
    public function getYoutubeEmbedUrl()
    {
        if (!$this->youtube_url) {
            return null;
        }

        // Convert YouTube URL to embed format
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $this->youtube_url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        return null;
    }

    public function getYoutubeVideoId()
    {
        if (!$this->youtube_url) {
            return null;
        }

        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $this->youtube_url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function hasYoutubeVideo()
    {
        return !empty($this->youtube_url) && !is_null($this->getYoutubeVideoId());
    }
}
