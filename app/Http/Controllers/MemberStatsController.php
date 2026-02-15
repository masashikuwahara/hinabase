<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberStatsController extends Controller
{
    public function index()
    {
        $asOf = \Carbon\Carbon::create(2026, 2, 15, 0, 0, 0, 'Asia/Tokyo');
        // 1) 身長順
        $heightRank = Member::query()
            ->where('graduation', 0)
            ->orderByRaw('height IS NULL asc')
            ->orderBy('height', 'desc')
            ->get(['id', 'name', 'height']);

        // 2) 誕生日順
        $birthdayRank = Member::query()
            ->where('graduation', 0)
            ->orderByRaw('birthday IS NULL asc')
            ->orderByRaw('birthday')
            ->orderByRaw('furigana')
            ->get(['id', 'name', 'birthday'])
            ->map(function ($m) use ($asOf) {
                $m->age_2026 = $m->birthday
                    ? (int) floor(\Carbon\Carbon::parse($m->birthday)->diffInRealYears($asOf))
                    : null;
                return $m;
            });

        // 3) 参加曲数
        $songCountRank = Member::query()
            ->where('graduation', 0)
            ->leftJoin('song_members', 'members.id', '=', 'song_members.member_id')
            ->groupBy('members.id', 'members.name')
            ->select('members.id', 'members.name', DB::raw('COUNT(song_members.song_id) as song_count'))
            ->orderByDesc('song_count')
            ->get();

        // 4) センター回数
        $centerCountRank = Member::query()
            ->where('graduation', 0)
            ->leftJoin('song_members', function ($join) {
                $join->on('members.id', '=', 'song_members.member_id')
                    ->where('song_members.is_center', 1);
            })
            ->groupBy('members.id', 'members.name')
            ->select('members.id', 'members.name', DB::raw('COUNT(song_members.song_id) as center_count'))
            ->orderByDesc('center_count')
            ->get();

        // 5) 選抜回数
        $titleSongCountRank = Member::query()
            ->where('graduation', 0)
            ->leftJoin('song_members', 'members.id', '=', 'song_members.member_id')
            ->leftJoin('songs', 'songs.id', '=', 'song_members.song_id')
            ->groupBy('members.id', 'members.name')
            ->select('members.id', 'members.name', DB::raw('SUM(CASE WHEN songs.titlesong = 1 THEN 1 ELSE 0 END) as titlesong_count'))
            ->orderByDesc('titlesong_count')
            ->get();

        return view('members.stats', compact(
            'heightRank',
            'birthdayRank',
            'songCountRank',
            'centerCountRank',
            'titleSongCountRank'
        ));
    }
}
