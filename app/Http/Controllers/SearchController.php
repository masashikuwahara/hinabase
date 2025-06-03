<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->back()->with('error', '何かキーワードを入力してください');
        }

        // メンバー検索
        $members = Member::where('name', 'like', "%{$query}%")
        ->orWhere('furigana', 'like', "%{$query}%")
        ->orWhere('nickname', 'like', "%{$query}%")->get();

        // 楽曲検索
        $songs = Song::where('title', 'like', "%{$query}%")
        ->orWhere('composer', 'like', "%{$query}%")->get();

        // 結果を統合して並び替え
        $results = collect([]); // 空のコレクションを作成

        foreach ($members as $member) {
            $results->push([
                'type' => 'member',
                'name' => $member->name,
                'image' => $member->image,
                'url' => route('members.show', $member->id)
            ]);
        }

        foreach ($songs as $song) {
            $results->push([
                'type' => 'song',
                'name' => $song->title ,
                'image' => $song->photo ,
                'url' => route('songs.show', $song->id) // ここで正しくIDを取得
            ]);
        }

        // 名前順で並び替え
        $results = $results->sortByDesc('name')->values();

        return view('search.results', compact('query', 'results'));
    }
}
