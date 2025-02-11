<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Song;
use App\Models\Member;

class SongMemberSeeder extends Seeder
{
    public function run()
    {
        $songA = Song::where('title', 'ソンナコトナイヨ')->first();
        $songB = Song::where('title', '青春の馬')->first();
        $songC = Song::where('title', '窓を開けなくても')->first();

        $memberA = Member::where('name', '小坂菜緒')->first();
        $memberB = Member::where('name', '松田好花')->first();
        $memberC = Member::where('name', '上村ひなの')->first();
        $memberD = Member::where('name', '金村美玖')->first();
        $memberE = Member::where('name', '加藤史帆')->first();
        $memberF = Member::where('name', '丹生明里')->first();
        $memberG = Member::where('name', '佐々木美玲')->first();

        // 曲Aにメンバーを追加（メンバーAをセンターに設定）
        $songA->members()->attach([
            $memberA->id => ['is_center' => true],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
        ]);
        // 曲Bにメンバーを追加（メンバーAをセンターに設定）
        $songB->members()->attach([
            $memberA->id => ['is_center' => true],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
        ]);
        // 曲Cにメンバーを追加（メンバーAをセンターに設定）
        $songC->members()->attach([
            $memberA->id => ['is_center' => true],
            $memberE->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
        ]);
    }
}
