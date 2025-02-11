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
            'title' => 'ソンナコトナイヨ',
            'release' => '2020-02-19',
            'lyricist' => '秋元康',
            'composer' => '柳沢英樹',
            'arranger' => '柳沢英樹',
            'is_recorded' => 'ソンナコトナイヨ',
            'titlesong' => '1',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7njC5lgL61c?si=AD3oGCX6gtaiq3i6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/sonnakotonaiyo.jpg',
        ]);
        Song::create([
            'title' => '青春の馬',
            'release' => '2020-02-19',
            'lyricist' => '秋元康',
            'composer' => '近藤圭一',
            'arranger' => '近藤圭一',
            'is_recorded' => 'ソンナコトナイヨ',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WnCksS3LEyA?si=Sa_2WIWs5XbRDXdn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/seishunnouma.jpg',
        ]);
        Song::create([
            'title' => '窓を開けなくても',
            'release' => '2020-02-19',
            'lyricist' => '秋元康',
            'composer' => 'CHOCOLATE MIX',
            'arranger' => 'CHOCOLATE MIX',
            'is_recorded' => 'ソンナコトナイヨ',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LjQWrrctzV0?si=bCXL0AOeum9KGeIm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'photos/madowo.jpg',
        ]);
    }
}
