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
        
        // 1b) 可視化用（Alpineへ渡す配列）
        $heightRankForJs = $heightRank
            ->filter(fn ($m) => $m->height !== null)
            ->map(fn ($m) => [
                'id' => (int) $m->id,
                'name' => (string) $m->name,
                'height' => (float) $m->height,
            ])
            ->values();

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
        
        // 6) 血液型順（A, B, O, AB, 不明）
        $bloodtypeRank = (clone $base)
            ->orderByRaw("
                CASE
                    WHEN blood_type IS NULL OR blood_type = '' THEN 6
                    ELSE 0
                END asc
            ")
            ->orderByRaw("FIELD(blood_type, 'A型', 'B型', 'O型', 'AB型', '不明')")
            ->orderBy('furigana', 'asc')
            ->get(['id', 'name', 'furigana', 'blood_type']);
        
        // 7) 出身地（都道府県）順：北→南（京都問題修正版）
        $prefExpr = "
            CASE
                WHEN birthplace = '北海道' THEN '北海道'
                WHEN RIGHT(birthplace, 1) IN ('都','府','県') THEN LEFT(birthplace, CHAR_LENGTH(birthplace) - 1)
                ELSE birthplace
            END
        ";

        $birthplaceRank = (clone $base)
            ->orderByRaw("FIELD($prefExpr,
                '北海道','青森','岩手','宮城','秋田','山形','福島',
                '茨城','栃木','群馬','埼玉','千葉','東京','神奈川',
                '新潟','富山','石川','福井','山梨','長野',
                '岐阜','静岡','愛知','三重',
                '滋賀','京都','大阪','兵庫','奈良','和歌山',
                '鳥取','島根','岡山','広島','山口',
                '徳島','香川','愛媛','高知',
                '福岡','佐賀','長崎','熊本','大分','宮崎','鹿児島','沖縄'
            ) = 0 asc")
            ->orderByRaw("FIELD($prefExpr,
                '北海道','青森','岩手','宮城','秋田','山形','福島',
                '茨城','栃木','群馬','埼玉','千葉','東京','神奈川',
                '新潟','富山','石川','福井','山梨','長野',
                '岐阜','静岡','愛知','三重',
                '滋賀','京都','大阪','兵庫','奈良','和歌山',
                '鳥取','島根','岡山','広島','山口',
                '徳島','香川','愛媛','高知',
                '福岡','佐賀','長崎','熊本','大分','宮崎','鹿児島','沖縄'
            ) asc")
            ->orderBy('furigana', 'asc')
            ->get(['id','name','furigana','birthplace']);

        return [
            'heightRank' => $heightRank,
            'heightRankForJs' => $heightRankForJs,
            'birthdayRank' => $birthdayRank,
            'songCountRank' => $songCountRank,
            'centerCountRank' => $centerCountRank,
            'titleSongCountRank' => $titleSongCountRank,
            'bloodtypeRank' => $bloodtypeRank,
            'birthplaceRank' => $birthplaceRank,
        ];
    }
}
