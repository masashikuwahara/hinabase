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
            'title' => '僕なんか',
            'release' => '2022-06-01',
            'lyricist' => '秋元康',
            'composer' => '温詞',
            'arranger' => '温詞、TomoLow',
            'is_recorded' => '僕なんか',
            'titlesong' => '1',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/15Hsw9QSeoc?si=zB7PLxkarTZf4d8f" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/bokunanka.jpg',
        ]);
    }
}
