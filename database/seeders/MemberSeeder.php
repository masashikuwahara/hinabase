<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run()
    {
        Member::create(['name' => '小坂菜緒']);
        Member::create(['name' => '山下葉留花']);
        Member::create(['name' => '小西夏菜実']);
    }
}
