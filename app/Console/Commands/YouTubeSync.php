<?php

namespace App\Console\Commands;

use App\Models\YoutubeVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class YouTubeSync extends Command
{
    protected $signature   = 'youtube:sync {--max=400 : 取得最大件数(概数)}';
    protected $description = 'YouTube Data APIから動画情報を同期する';

    public function handle()
    {
        $apiKey     = config('services.youtube.key') ?? env('YOUTUBE_API_KEY');
        $channelId  = env('YOUTUBE_CHANNEL_ID');
        $maxWanted  = (int)$this->option('max');

        if (!$apiKey || !$channelId) {
            $this->error('YOUTUBE_API_KEY または YOUTUBE_CHANNEL_ID が未設定です。');
            return Command::FAILURE;
        }

        $this->info("Fetching up to {$maxWanted} videos from channel: {$channelId}");

        // 1) チャンネルのuploadsプレイリストIDを取得
        $chan = Http::get('https://www.googleapis.com/youtube/v3/channels', [
            'part' => 'contentDetails,snippet',
            'id'   => $channelId,
            'key'  => $apiKey,
        ])->json();

        $uploads = data_get($chan, 'items.0.contentDetails.relatedPlaylists.uploads');
        $channelTitle = data_get($chan, 'items.0.snippet.title');
        if (!$uploads) {
            $this->error('uploadsプレイリストが取得できませんでした。Channel IDを確認してください。');
            return Command::FAILURE;
        }

        // 2) uploadsプレイリストからvideoId一覧を収集（ページング）
        $videoIds = [];
        $nextPage = null;
        while (true) {
            $res = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', [
                'part'       => 'contentDetails',
                'playlistId' => $uploads,
                'maxResults' => 50,
                'pageToken'  => $nextPage,
                'key'        => $apiKey,
            ])->json();

            foreach (data_get($res,'items',[]) as $it) {
                $vid = data_get($it,'contentDetails.videoId');
                if ($vid) $videoIds[] = $vid;
                if (count($videoIds) >= $maxWanted) break 2;
            }

            $nextPage = data_get($res,'nextPageToken');
            if (!$nextPage) break;
        }

        if (empty($videoIds)) {
            $this->warn('取得できる動画がありませんでした。');
            return Command::SUCCESS;
        }

        // 3) videos APIで詳細をバルク取得（50件ずつ）
        $chunks = array_chunk($videoIds, 50);
        $upserts = 0;

        foreach ($chunks as $ids) {
            $res = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'snippet,statistics,contentDetails',
                'id'   => implode(',', $ids),
                'key'  => $apiKey,
            ])->json();

            foreach (data_get($res,'items',[]) as $item) {
                $videoId   = data_get($item,'id');
                $snippet   = data_get($item,'snippet',[]);
                $stats     = data_get($item,'statistics',[]);
                $details   = data_get($item,'contentDetails',[]);

                YoutubeVideo::updateOrCreate(
                    ['video_id' => $videoId],
                    [
                        'title'         => data_get($snippet,'title',''),
                        'channel_id'    => $channelId,
                        'channel_title' => $channelTitle,
                        'published_at'  => data_get($snippet,'publishedAt'),
                        'thumbnail_url' => data_get($snippet,'thumbnails.medium.url')
                                        ?? data_get($snippet,'thumbnails.default.url'),
                        'view_count'    => (int)($stats['viewCount'] ?? 0),
                        'like_count'    => (int)($stats['likeCount'] ?? 0),
                        'comment_count' => (int)($stats['commentCount'] ?? 0),
                        'duration'      => data_get($details,'duration'), // ISO8601
                    ]
                );
                $upserts++;
            }
        }

        // 一覧キャッシュのクリア（ページの最新化）
        cache()->forget('yt_top_views');

        $this->info("Synced/updated rows: {$upserts}");
        return Command::SUCCESS;
    }
}
