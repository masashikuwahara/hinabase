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
            'title' => '絶対的第六感',
            'release' => '2024-09-18',
            'lyricist' => '秋元康',
            'composer' => 'シライシ紗トリ',
            'arranger' => 'シライシ紗トリ',
            'is_recorded' => '絶対的第六感',
            'titlesong' => '1',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qUZagu-NL_s?si=bdKF6OMh3QdT58YI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/zettaiteki.jpg',
        ]);
    }
}
