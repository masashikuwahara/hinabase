<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    // 楽曲一覧ページ
    public function index()
    {
        $songs = Song::all(); // 楽曲データを取得
        return view('songs.index', compact('songs'));
    }

    // 楽曲詳細ページ
    public function show($id)
    {
        $song = Song::with('members')->findOrFail($id); // 楽曲の参加メンバーを取得
        return view('songs.show', compact('song'));
    }
}
