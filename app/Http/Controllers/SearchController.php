<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));
        $category = $request->input('category', 'all');

        $request->validate([
            'query' => ['required', 'string'],
            'category' => ['nullable', 'in:all,members,songs'],
        ], [
            'query.required' => '何かキーワードを入力してください',
        ]);

        $results = collect([]);

        // --- ヘルパ：publicディスク上のパスをURLへ正規化 ---
        $toPublicUrl = function (?string $path, string $folder) {
            // フォールバック画像（public/images/noimage.png を配置）
            $fallback = asset('images/noimage.png');

            if (!$path) return $fallback;

            // すでに http(s) の場合はそのまま
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            // 先頭スラッシュ削除
            $path = ltrim($path, '/');

            // すでに images/ or photos/ を含む場合はそのまま確認
            if (Str::startsWith($path, ['images/', 'photos/'])) {
                return Storage::disk('public')->exists($path)
                    ? Storage::url($path)           // => /storage/xxx/yyy.jpg
                    : $fallback;
            }

            // ファイル名だけの場合は、指定フォルダを付ける
            $candidate = "{$folder}/{$path}";

            return Storage::disk('public')->exists($candidate)
                ? Storage::url($candidate)         // => /storage/{folder}/filename
                : $fallback;
        };

        // すべて or メンバー
        if (in_array($category, ['all', 'members'], true)) {
            $members = Member::query()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('furigana', 'like', "%{$query}%")
                      ->orWhere('nickname', 'like', "%{$query}%");
                })
                ->get();

            foreach ($members as $m) {
                $results->push([
                    'type'       => 'member',
                    'name'       => $m->name,
                    'image_url'  => $toPublicUrl($m->image, 'images'), // ← ここがポイント
                    'url'        => route('members.show', $m->id),
                ]);
            }
        }

        // すべて or 楽曲
        if (in_array($category, ['all', 'songs'], true)) {
            $songs = Song::query()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('composer', 'like', "%{$query}%");
                })
                ->get();

            foreach ($songs as $s) {
                $results->push([
                    'type'       => 'song',
                    'name'       => $s->title,
                    'image_url'  => $toPublicUrl($s->photo, 'photos'), // ← ここがポイント
                    'url'        => route('songs.show', $s->id),
                ]);
            }
        }

        $results = $results->sortByDesc('name')->values();

        return view('search.results', [
            'query'    => $query,
            'category' => $category,
            'results'  => $results,
        ]);
    }
}
