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
        $songA = Song::where('title', 'それでも歩いてる')->first();
        $songB = Song::where('title', 'NO WAR in the future')->first();
        $songC = Song::where('title', 'イマニミテイロ')->first();
        $songD = Song::where('title', '半分の記憶')->first();

        $memberA = Member::where('name', '井口眞緒')->first();
        $memberB = Member::where('name', '潮紗理菜')->first();
        $memberC = Member::where('name', '柿崎芽実')->first();
        $memberD = Member::where('name', '影山優佳')->first();
        $memberE = Member::where('name', '加藤史帆')->first();
        $memberF = Member::where('name', '齊藤京子')->first();
        $memberG = Member::where('name', '佐々木久美')->first();
        $memberH = Member::where('name', '佐々木美玲')->first();
        $memberI = Member::where('name', '高瀬愛奈')->first();
        $memberJ = Member::where('name', '高本彩花')->first();
        $memberK = Member::where('name', '東村芽依')->first();
        $memberL = Member::where('name', '金村美玖')->first();
        $memberM = Member::where('name', '河田陽菜')->first();
        $memberN = Member::where('name', '小坂菜緒')->first();
        $memberO = Member::where('name', '富田鈴花')->first();
        $memberP = Member::where('name', '丹生明里')->first();
        $memberQ = Member::where('name', '濱岸ひより')->first();
        $memberR = Member::where('name', '松田好花')->first();
        $memberS = Member::where('name', '宮田愛萌')->first();
        $memberT = Member::where('name', '渡邉美穂')->first();

        $songA->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => true],
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
        ]);
        $songB->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => true],
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
        ]);
        $songC->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => true],
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
        ]);
        $songD->members()->attach([
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
            $memberN->id => ['is_center' => true],
            $memberO->id => ['is_center' => false],
            $memberP->id => ['is_center' => false],
            $memberQ->id => ['is_center' => false],
            $memberR->id => ['is_center' => false],
            $memberS->id => ['is_center' => false],
            $memberT->id => ['is_center' => false],
        ]);
    }
}
