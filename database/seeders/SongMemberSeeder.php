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
        $songA = Song::where('title', '卒業写真だけが知ってる')->first();

        $memberA = Member::where('name', '金村美玖')->first();

        // 曲Aにメンバーを追加（メンバーAをセンターに設定）
        $songA->members()->attach([
            $memberA->id => ['is_center' => false]
        ]);
        // 曲Bにメンバーを追加（メンバーCをセンターに設定）

        
    }
}
