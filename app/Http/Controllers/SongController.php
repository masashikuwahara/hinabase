<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        // 楽曲ごとに参加メンバーを取得
        $songs = Song::with('members')->get();

        return view('songs.index', compact('songs'));
    }
}
