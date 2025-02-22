<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Song;

class SongSeeder extends Seeder
{
    public function run()
    {
        Song::create([
            'title' => 'レントゲン眼鏡',
            'release' => '2021-11-05',
            'lyricist' => '秋元康',
            'composer' => 'イイジマケン',
            'arranger' => '-',
            'is_recorded' => 'レントゲン眼鏡',
            'titlesong' => '0',
            'youtube' => '-',
            'photo' => 'photos/other.jpg',
        ]);
    }
}
