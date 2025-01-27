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
        $songB = Song::where('title', '足の小指を箪笥の角にぶつけた')->first();

        $memberA = Member::where('name', '小坂菜緒')->first();
        $memberB = Member::where('name', '山下葉留花')->first();
        $memberC = Member::where('name', '小西夏菜実')->first();

        $songA->members()->attach([$memberA->id, $memberB->id]);
        $songB->members()->attach([$memberB->id, $memberC->id]);
    }
}
