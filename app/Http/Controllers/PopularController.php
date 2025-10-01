<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Popularity;
use App\Models\Member;
use App\Models\Song;

class PopularController extends Controller
{
    public function index()
    {
        $items = Cache::remember('popular_top8', 600, function () {
            return Popularity::whereIn('type', ['member','song'])
                ->orderByDesc('views')
                ->limit(20)
                ->get(['type','entity_id','updated_at']);
        });

        // まとめて関連データを取得（N+1回避）
        $memberIds = $items->where('type','member')->pluck('entity_id')->unique()->values();
        $songIds   = $items->where('type','song')->pluck('entity_id')->unique()->values();

        $members = Member::whereIn('id', $memberIds)->get()->keyBy('id');
        $songs   = Song::whereIn('id', $songIds)->get()->keyBy('id');

        $cards = $items->map(function ($pop) use ($members, $songs) {
            if ($pop->type === 'member') {
                $m = $members[$pop->entity_id] ?? null;
                return [
                    'url'        => route('members.show', $pop->entity_id),
                    'title'      => $m->name ?? "メンバー #{$pop->entity_id}",
                    'image'      => $m && $m->image ? asset('storage/'.$m->image) : asset('images/member-default.jpg'),
                    'tag'        => 'メンバー',
                    'is_new'     => (bool)($m->is_recently_updated ?? false),
                    'updated_at' => $pop->updated_at,
                ];
            } else {
                $s = $songs[$pop->entity_id] ?? null;
                $songImage = $s?->photo ?? $s?->image ?? null;
                return [
                    'url'        => route('songs.show', $pop->entity_id),
                    'title'      => $s->title ?? "楽曲 #{$pop->entity_id}",
                    'image'      => $songImage ? asset('storage/'.$songImage) : asset('images/song-default.jpg'),
                    'tag'        => '楽曲',
                    'is_new'     => false,
                    'updated_at' => $pop->updated_at,
                ];
            }
        });

        return view('popular.index', compact('cards'));
    }
}