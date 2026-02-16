<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberStatsController extends Controller
{
    public function index()
    {
        $asOf = Carbon::create(2026, 2, 15, 0, 0, 0, 'Asia/Tokyo');

        $current   = $this->buildRanks(0, $asOf);
        $graduated = $this->buildRanks(1, $asOf);
        $all       = $this->buildRanks(null, $asOf);

        return view('members.stats', compact('current', 'graduated', 'all'));
    }

    /**
     * @param int|null $graduation
     */
    private function buildRanks(?int $graduation, Carbon $asOf): array
    {
        $base = Member::query();
        if ($graduation !== null) {
            $base->where('graduation', $graduation);
        }

        // 1) 身長順（NULLは最後）
        $heightRank = (clone $base)
            ->orderByRaw('height IS NULL asc')
            ->orderBy('height', 'desc')
            ->get(['id', 'name', 'height']);

        // 2) 誕生日順
        $birthdayRank = (clone $base)
            ->orderByRaw('birthday IS NULL asc')
            ->orderByDesc('birthday')
            ->orderBy('furigana', 'asc')
            ->get(['id', 'name', 'birthday', 'furigana'])
            ->map(function ($m) use ($asOf) {
                $m->age_2026 = $m->birthday
                    ? (int) floor(\Carbon\Carbon::parse($m->birthday)->diffInRealYears($asOf)) // 満年齢（整数）
                    : null;
                return $m;
            });

        // 3) 参加曲数
        $songCountRank = (clone $base)
            ->leftJoin('song_members', 'members.id', '=', 'song_members.member_id')
            ->groupBy('members.id', 'members.name')
            ->select('members.id', 'members.name', DB::raw('COUNT(song_members.song_id) as song_count'))
            ->orderByDesc('song_count')
            ->get();

        // 4) センター回数
        $centerCountRank = (clone $base)
            ->leftJoin('song_members', function ($join) {
                $join->on('members.id', '=', 'song_members.member_id')
                    ->where('song_members.is_center', 1);
            })
            ->groupBy('members.id', 'members.name')
            ->select('members.id', 'members.name', DB::raw('COUNT(song_members.song_id) as center_count'))
            ->orderByDesc('center_count')
            ->get();

        // 5) 選抜回数
        $titleSongCountRank = (clone $base)
            ->leftJoin('song_members', 'members.id', '=', 'song_members.member_id')
            ->leftJoin('songs', 'songs.id', '=', 'song_members.song_id')
            ->groupBy('members.id', 'members.name')
            ->select(
                'members.id',
                'members.name',
                DB::raw('SUM(CASE WHEN songs.titlesong = 1 THEN 1 ELSE 0 END) as titlesong_count')
            )
            ->orderByDesc('titlesong_count')
            ->get();

        return [
            'heightRank' => $heightRank,
            'birthdayRank' => $birthdayRank,
            'songCountRank' => $songCountRank,
            'centerCountRank' => $centerCountRank,
            'titleSongCountRank' => $titleSongCountRank,
        ];
    }
}
