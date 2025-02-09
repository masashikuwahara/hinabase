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
            'title' => 'ブルーベリー＆ラズベリー',
            'release' => '2022-10-26',
            'lyricist' => '秋元康',
            'composer' => '小野貴光',
            'arranger' => '若田部誠',
            'is_recorded' => '月と星が踊るMidnight',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lV_Boxqp-ak?si=3imndfeHQsIOuhBR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'Blueberry & Raspberry.png',
        ]);
        Song::create([
            'title' => '錆つかない剣を持て!',
            'release' => '2024-05-08',
            'lyricist' => '秋元康',
            'composer' => 'karia',
            'arranger' => 'APAZZI',
            'is_recorded' => '君はハニーデュー',
            'titlesong' => '0',
            'youtube' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MYMyC927h0o?si=qkK87d74f99So96f" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
            'photo' => 'maxresdefault.jpg',
        ]);
    }
}
