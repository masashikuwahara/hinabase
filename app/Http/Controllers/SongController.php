<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    // 楽曲一覧ページ
    public function index()
    {
        $others = Song::where('titlesong', 0)->get();
        $singles = Song::where('titlesong', 1)->get();
        return view('songs.index', compact('others', 'singles'));
    }

    // 楽曲詳細ページ
    public function show(Song $song)
    {
        $song->load('members');
        $recordedSongs = Song::where('is_recorded', $song->is_recorded)
        ->where('id', '!=', $song->id) // 自分自身は除外
        ->get();

        $callVideos = [
            'suki-ni-naru-crescendo' => 'https://www.youtube.com/embed/wA_lovpT5C4?si=5hmR4V6RppHi2ZQJ',
            'surfs-up-girl' => 'https://www.youtube.com/embed/vr7IROT1ml4?si=yHgieV2CFYQi_NVz',
        ];

        $callVideoUrl = $callVideos[$song->slug] ?? null;

        return view('songs.show', compact('song', 'recordedSongs', 'callVideoUrl' ));
    }
}
