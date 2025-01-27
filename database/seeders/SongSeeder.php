<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Song;

class SongSeeder extends Seeder
{
    public function run()
    {
        Song::create(['title' => '卒業写真だけが知ってる']);
        Song::create(['title' => '足の小指を箪笥の角にぶつけた']);
    }
}
