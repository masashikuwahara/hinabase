<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PopularityDaily;
use App\Models\Member;
use App\Models\Song;

class PopularController extends Controller
{
    public function index()
    {
        $end   = Carbon::today();
        $start = $end->copy()->subDays(6);

        $weekly = Cache::remember(
            "popular_weekly_top8_{$start->toDateString()}_{$end->toDateString()}",
            600,
            function () use ($start, $end) {
                return PopularityDaily::select('type','entity_id', DB::raw('SUM(views) as week_views'))
                    ->whereBetween('date', [$start, $end])
                    ->groupBy('type','entity_id')
                    ->orderByDesc('week_views')
                    ->limit(20)
                    ->get();
            }
        );

        $memberIds = $weekly->where('type','member')->pluck('entity_id')->unique()->values();
        $songIds   = $weekly->where('type','song')->pluck('entity_id')->unique()->values();

        $members = Member::whereIn('id', $memberIds)->get()->keyBy('id');
        $songs   = Song::whereIn('id', $songIds)->get()->keyBy('id');

        $cards = $weekly->map(function ($row) use ($members, $songs) {
            if ($row->type === 'member') {
                $m = $members[$row->entity_id] ?? null;
                return [
                    'url'        => route('members.show', $row->entity_id),
                    'title'      => $m->name ?? "メンバー #{$row->entity_id}",
                    'image'      => $m && $m->image ? asset('storage/'.$m->image) : asset('images/member-default.jpg'),
                    'tag'        => 'メンバー',
                    'is_new'     => (bool)($m->is_recently_updated ?? false),
                    'week_views' => (int)$row->week_views,
                    'updated_at' => $row->updated_at,
                ];
            } else {
                $s = $songs[$row->entity_id] ?? null;
                $songImage = $s?->photo ?? $s?->image ?? null;
                return [
                    'url'        => route('songs.show', $row->entity_id),
                    'title'      => $s->title ?? "楽曲 #{$row->entity_id}",
                    'image'      => $songImage ? asset('storage/'.$songImage) : asset('images/song-default.jpg'),
                    'tag'        => '楽曲',
                    'is_new'     => false,
                    'week_views' => (int)$row->week_views,
                    'updated_at' => $row->updated_at,
                ];
            }
        });

        $rangeText = $start->toDateString().' 〜 '.$end->toDateString();
        return view('popular.index', compact('cards','rangeText'));
    }
}