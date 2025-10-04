<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\YoutubeVideo;
use Carbon\Carbon;

class YoutubeFetchService
{
    private string $key;
    public function __construct() { $this->key = config('services.youtube.key'); }

    /**
     * チャンネルの最新動画一覧→詳細（statistics, contentDetails）を結合して保存/更新
     */
    public function syncChannel(string $channelId, int $max = 50): int
    {
        // 1) search.list で videoIdを収集（公開日降順）
        $searchRes = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'key' => $this->key,
            'channelId' => $channelId,
            'part' => 'id,snippet',
            'maxResults' => $max,
            'order' => 'date',
            'type' => 'video',
        ])->throw()->json();

        $items = $searchRes['items'] ?? [];
        if (!$items) return 0;

        $videoIds = collect($items)->pluck('id.videoId')->filter()->values()->implode(',');

        // 2) videos.list で詳細を取得
        $videosRes = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'key' => $this->key,
            'id' => $videoIds,
            'part' => 'snippet,contentDetails,statistics',
            'maxResults' => 50,
        ])->throw()->json();

        $count = 0;
        foreach ($videosRes['items'] ?? [] as $v) {
            $snippet = $v['snippet'] ?? [];
            $stats   = $v['statistics'] ?? [];
            $detail  = $v['contentDetails'] ?? [];

            YoutubeVideo::updateOrCreate(
                ['video_id' => $v['id']],
                [
                    'title'         => $snippet['title'] ?? '',
                    'channel_id'    => $snippet['channelId'] ?? $channelId,
                    'channel_title' => $snippet['channelTitle'] ?? null,
                    'published_at'  => isset($snippet['publishedAt']) ? Carbon::parse($snippet['publishedAt']) : now(),
                    'thumbnail_url' => $snippet['thumbnails']['high']['url'] ?? ($snippet['thumbnails']['default']['url'] ?? null),
                    'view_count'    => (int)($stats['viewCount'] ?? 0),
                    'like_count'    => (int)($stats['likeCount'] ?? 0),
                    'comment_count' => (int)($stats['commentCount'] ?? 0),
                    'duration'      => $detail['duration'] ?? null,
                ]
            );
            $count++;
        }
        return $count;
    }
}
