<?php

namespace App\Http\Controllers;

use App\Models\YoutubeVideo;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;

class YoutubeRankingController extends Controller
{
    public function index()
    {
        // メンバー一覧（名前とIDだけでOK）
        $members = Member::select('id', 'name')->get();

        // 24時間キャッシュ（ページ描画の軽量化）
        $videosTopViews = Cache::remember('yt_top_views', 60*60*24, function () {
            return YoutubeVideo::orderByDesc('view_count')->limit(50)->get();
        });

        $latest = YoutubeVideo::orderByDesc('published_at')->limit(12)->get();

        // ★ タイトルにメンバー内部リンクを埋め込む
        $this->attachMemberLinks($videosTopViews, $members);
        $this->attachMemberLinks($latest, $members);

        // グラフ用（上位10件）
        $chart = $videosTopViews->take(10)->map(fn($v)=>[
            'title' => mb_strimwidth($v->title,0,20,'…'),
            'views' => (int)$v->view_count,
            'video_id' => $v->video_id,
        ]);

        $lastUpdatedAt = now();
        return view('youtube.ranking', compact('videosTopViews','latest','chart'));
    }

    /**
     * 動画タイトル内のメンバー名を内部リンク化して linked_title として持たせる
     */
    private function attachMemberLinks($videos, $members)
    {
        foreach ($videos as $video) {
            $title = $video->title;

            foreach ($members as $m) {
                $name = $m->name;
                if (!$name) continue;

                $url = route('members.show', $m->id);

                // メンバー名を安全に正規表現に使える形に
                $escaped = preg_quote($name, '/');

                // 最初にヒットした1箇所だけリンク化（2箇所以上リンクしたいなら第4引数を外す）
                $title = preg_replace(
                    "/{$escaped}/u",
                    '<a href="'.$url.'" class="text-blue-600 underline hover:text-blue-800">'.$name.'</a>' . ' ',
                    $title,
                    1
                );
            }

            // Eloquentモデルに動的属性として保持（@jsonで出力される）
            $video->linked_title = $title;
        }
    }
}


// class YoutubeRankingController extends Controller
// {
//     public function index()
//     {
//         // 24時間キャッシュ（ページ描画の軽量化）
//         $videosTopViews = Cache::remember('yt_top_views', 60*60*24, function () {
//             return YoutubeVideo::orderByDesc('view_count')->limit(50)->get();
//         });

//         $latest = YoutubeVideo::orderByDesc('published_at')->limit(12)->get();

//         // グラフ用（上位10件）
//         $chart = $videosTopViews->take(10)->map(fn($v)=>[
//             'title' => mb_strimwidth($v->title,0,20,'…'),
//             'views' => (int)$v->view_count,
//         ]);

//         return view('youtube.ranking', compact('videosTopViews','latest','chart'));
//     }
// }
