<?php

namespace App\Http\Controllers;

use App\Models\YoutubeVideo;
use Illuminate\Support\Facades\Cache;

class YoutubeRankingController extends Controller
{
    public function index()
    {
        // 24時間キャッシュ（ページ描画の軽量化）
        $videosTopViews = Cache::remember('yt_top_views', 60*60*24, function () {
            return YoutubeVideo::orderByDesc('view_count')->limit(50)->get();
        });

        $latest = YoutubeVideo::orderByDesc('published_at')->limit(12)->get();

        // グラフ用（上位10件）
        $chart = $videosTopViews->take(10)->map(fn($v)=>[
            'title' => mb_strimwidth($v->title,0,20,'…'),
            'views' => (int)$v->view_count,
        ]);

        return view('youtube.ranking', compact('videosTopViews','latest','chart'));
    }
}
