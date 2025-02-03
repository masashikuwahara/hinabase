<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    public function create()
    {
        return view('admin.songs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release' => 'required|date',
            'lyricist' => 'nullable|string|max:255',
            'composer' => 'nullable|string|max:255',
            'arranger' => 'nullable|string|max:255',
        ]);

        Song::create($request->all());

        return redirect()->route('admin.songs.create')->with('success', '楽曲が追加されました！');
    }
}
