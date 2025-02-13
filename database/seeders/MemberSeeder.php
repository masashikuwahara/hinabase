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
            'name' => '長濱ねる',
            'nickname' => 'ねる',
            'birthday' => '1998-09-04',
            'constellation' => 'おとめ座',
            'height' => '159',
            'blood_type' => 'O型',
            'birthplace' => '長崎県',
            'grade' => 'けやき坂46',
            'color1' => '#9b72b0',
            'colorname1' => 'パープル',
            'color2' => '#9b72b0',
            'colorname2' => 'パープル',
            'graduation' => '1',
            'introduction' => '全てはここから始まった！ねるのためにひらがなけやきが結成され、仲間が集まり、やがてねるは兼任を解除し、ひらがなけやきは新たなにスタートを切り、今に至る。',
            'image' => 'images/neru.jpg'
        ]);
    }
}
