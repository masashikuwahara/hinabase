<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Song;
use App\Models\Member;

class SongMemberSeeder extends Seeder
{
    public function run()
    {
        $songA = Song::where('title', '僕なんか')->first();
        $songB = Song::where('title', '飛行機雲ができる理由')->first();
        $songC = Song::where('title', 'もうこんなに好きになれない')->first();
        $songD = Song::where('title', 'ゴーフルと君')->first();
        $songE = Song::where('title', '真夜中の懺悔大会')->first();
        $songF = Song::where('title', '恋した魚は空を飛ぶ')->first();
        $songG = Song::where('title', '知らないうちに愛されていた')->first();

        $memberA = Member::where('name', '潮紗理菜')->first();
        $memberB = Member::where('name', '影山優佳')->first();
        $memberC = Member::where('name', '加藤史帆')->first();
        $memberD = Member::where('name', '齊藤京子')->first();
        $memberE = Member::where('name', '佐々木久美')->first();
        $memberF = Member::where('name', '佐々木美玲')->first();
        $memberG = Member::where('name', '高瀬愛奈')->first();
        $memberH = Member::where('name', '高本彩花')->first();
        $memberI = Member::where('name', '東村芽依')->first();
        $memberJ = Member::where('name', '金村美玖')->first();
        $memberK = Member::where('name', '河田陽菜')->first();
        $memberL = Member::where('name', '小坂菜緒')->first();
        $memberM = Member::where('name', '富田鈴花')->first();
        $memberN = Member::where('name', '丹生明里')->first();
        $memberO = Member::where('name', '濱岸ひより')->first();
        $memberP = Member::where('name', '松田好花')->first();
        $memberQ = Member::where('name', '宮田愛萌')->first();
        $memberR = Member::where('name', '渡邉美穂')->first();
        $memberS = Member::where('name', '上村ひなの')->first();
        $memberT = Member::where('name', '髙橋未来虹')->first();
        $memberU = Member::where('name', '森本茉莉')->first();
        $memberV = Member::where('name', '山口陽世')->first();

        $songA->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => true],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
            $memberP->id => ['is_center' => false],
            $memberQ->id => ['is_center' => false],
            $memberR->id => ['is_center' => false],
            $memberS->id => ['is_center' => false],
            $memberT->id => ['is_center' => false],
            $memberU->id => ['is_center' => false],
            $memberV->id => ['is_center' => false],
        ]);
        $songB->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => true],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
            $memberP->id => ['is_center' => false],
            $memberQ->id => ['is_center' => false],
            $memberR->id => ['is_center' => false],
            $memberS->id => ['is_center' => false],
            $memberT->id => ['is_center' => false],
            $memberU->id => ['is_center' => false],
            $memberV->id => ['is_center' => false],
        ]);
        $songC->members()->attach([
            $memberJ->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
        ]);
        $songD->members()->attach([
            $memberS->id => ['is_center' => false],
            $memberT->id => ['is_center' => false],
            $memberU->id => ['is_center' => false],
            $memberV->id => ['is_center' => true],
        ]);
        $songE->members()->attach([
            $memberA->id => ['is_center' => true],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
        ]);
        $songF->members()->attach([
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
            $memberP->id => ['is_center' => false],
            $memberQ->id => ['is_center' => false],
            $memberR->id => ['is_center' => true],
        ]);
        $songG->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
            $memberP->id => ['is_center' => false],
            $memberQ->id => ['is_center' => false],
            $memberR->id => ['is_center' => false],
            $memberS->id => ['is_center' => false],
            $memberT->id => ['is_center' => false],
            $memberU->id => ['is_center' => false],
            $memberV->id => ['is_center' => false],
        ]);
    }
}
