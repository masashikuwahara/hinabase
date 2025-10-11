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
        $albums = Song::where('titlesong', 3)->get();
        return view('songs.index', compact('others', 'singles', 'albums'));
    }

    // 楽曲詳細ページ
    public function show($id)
    {
        $song = Song::with('members')->findOrFail($id);
        $recordedSongs = Song::where('is_recorded', $song->is_recorded)
        ->where('id', '!=', $song->id)
        ->get();
        return view('songs.show', compact('song', 'recordedSongs'));
    }
}
