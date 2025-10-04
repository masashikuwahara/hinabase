<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    protected $fillable = [
        'video_id','title','channel_id','channel_title','published_at',
        'thumbnail_url','view_count','like_count','comment_count','duration',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'view_count'   => 'integer',
        'like_count'   => 'integer',
        'comment_count'=> 'integer',
    ];

    // 視聴ページ
    public function getWatchUrlAttribute(): string
    {
        return "https://www.youtube.com/watch?v={$this->video_id}";
    }

    // 埋め込みURL
    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->video_id}";
    }
}
