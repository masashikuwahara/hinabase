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
            'title' => 'キュン',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => '野村陽一郎',
            'arranger' => '野村陽一郎',
            'is_recorded' => 'キュン',
            'titlesong' => '1',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K5HPhoqyO4U?si=-Ui4lIU3jxyY1aEN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/kyun.jpg',
        ]);
        Song::create([
            'title' => 'JOYFUL LOVE',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => '前迫潤哉、Dr.Lilcom',
            'arranger' => 'Dr.Lilcom',
            'is_recorded' => 'キュン',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mbXtz9zGB_E?si=w6VW1WkyvD6IhaOU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/kyun.jpg',
        ]);
        Song::create([
            'title' => '耳に落ちる涙',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => '西井昌明',
            'arranger' => '若田部誠',
            'is_recorded' => 'キュン',
            'titlesong' => '0',
            'youtube' => '-',
            'photo' => 'photos/kyun.jpg',
        ]);
        Song::create([
            'title' => 'Footsteps',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => '野井洋児',
            'arranger' => '野井洋児',
            'is_recorded' => 'キュン',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/VSQD18hsYz8?si=i05FermbXZ-e4C5l" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/kyun.jpg',
        ]);
        Song::create([
            'title' => 'ときめき草',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => '御子柴リョーマ',
            'arranger' => '御子柴リョーマ',
            'is_recorded' => 'キュン',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bgCR9HlsSPY?si=xWBqFwWkQVs1vFDn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/kyun.jpg',
        ]);
        Song::create([
            'title' => '沈黙が愛なら',
            'release' => '2019-03-27',
            'lyricist' => '秋元康',
            'composer' => 'サトウシンゴ',
            'arranger' => 'サトウシンゴ、長田直也',
            'is_recorded' => 'キュン',
            'titlesong' => '0',
            'youtube' => '-',
            'photo' => 'photos/kyun.jpg',
        ]);
    }
}
