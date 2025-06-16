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
    public function store(Request $request)
    {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'release' => 'required|date',
            'lyricist' => 'nullable|string|max:255',
            'composer' => 'nullable|string|max:255',
            'arranger' => 'nullable|string|max:255',
            'is_recorded' => 'nullable|string|max:255',
            'titlesong' => 'required|boolean',
            'youtube' => 'nullable|string|max:510',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Song::create([
            'title' => $request->title,
            'release' => $request->release,
            'lyricist' => $request->lyricist,
            'composer' => $request->composer,
            'arranger' => $request->arranger,
            'is_recorded' => $request->is_recorded,
            'titlesong' => $request->titlesong,
            'youtube' => $request->youtube,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.songs.create')->with('success', '楽曲を追加しました！');
    }
}
