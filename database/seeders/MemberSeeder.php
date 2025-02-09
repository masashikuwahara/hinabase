<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run()
    {
        Member::create([
            'name' => '平尾帆夏',
            'birthday' => '2003-07-31',
            'constellation' => 'しし座',
            'height' => '158.5',
            'blood_type' => 'A型',
            'birthplace' => '鳥取県',
            'grade' => '四期生',
            'color1' => '#49BDF0br',
            'colorname1' => 'パステルブルー',
            'color2' => '#ffa500',
            'colorname2' => 'オレンジ',
            'graduation' => '0',
            'image' => 'images/hiraho.jpg'
        ]);
    }
}
