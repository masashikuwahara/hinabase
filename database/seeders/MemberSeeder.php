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
            'name' => '藤嶌果歩',
            'birthday' => '2006-08-07',
            'constellation' => 'しし座',
            'blood_type' => '不明',
            'birthplace' => '北海道',
            'grade' => '四期生',
            'color1' => '#fceeeb',
            'color2' => '#0000ff',
            'graduation' => '0',
            'image' => 'images/kaho.jpg']);
    }
}
