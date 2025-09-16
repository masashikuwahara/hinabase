<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    public function edit($id)
    {
        $song = Song::findOrFail($id);
        return view('admin.songs.edit', compact('song'));
    }
    public function update(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'release' => 'required|date',
            'lyricist' => 'nullable|string|max:255',
            'composer' => 'nullable|string|max:255',
            'arranger' => 'nullable|string|max:255',
            'is_recorded' => 'nullable|string|max:255',
            'lyric' => 'nullable|string|max:255',
            'titlesong' => 'required|boolean',
            'youtube' => 'nullable|string|max:510',
        ]);

        $song->update($request->all());
        $song->save();

        return redirect()->route('admin.songs')->with('success', '楽曲を更新しました！');
    }
}
