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
        $songA = Song::where('title', '絶対的第六感')->first();
        $songB = Song::where('title', '君を覚えてない')->first();
        $songC = Song::where('title', '永遠のソフィア')->first();
        $songD = Song::where('title', 'どっちが先に言う?')->first();
        $songE = Song::where('title', '妄想コスモス')->first();
        $songF = Song::where('title', '雪は降る 心の世界に')->first();
        $songG = Song::where('title', '夕陽Dance')->first();

        $memberA = Member::where('name', '加藤史帆')->first();
        $memberB = Member::where('name', '佐々木久美')->first();
        $memberC = Member::where('name', '佐々木美玲')->first();
        $memberD = Member::where('name', '東村芽依')->first();
        $memberE = Member::where('name', '金村美玖')->first();
        $memberF = Member::where('name', '河田陽菜')->first();
        $memberG = Member::where('name', '小坂菜緒')->first();
        $memberH = Member::where('name', '富田鈴花')->first();
        $memberI = Member::where('name', '丹生明里')->first();
        $memberJ = Member::where('name', '松田好花')->first();
        $memberK = Member::where('name', '上村ひなの')->first();
        $memberL = Member::where('name', '髙橋未来虹')->first();
        $memberM = Member::where('name', '小西夏菜実')->first();
        $memberN = Member::where('name', '正源司陽子')->first();
        $memberO = Member::where('name', '藤嶌果歩')->first();

        $member1 = Member::where('name', '高瀬愛奈')->first();
        $member2 = Member::where('name', '濱岸ひより')->first();
        $member3 = Member::where('name', '森本茉莉')->first();
        $member4 = Member::where('name', '山口陽世')->first();
        $member5 = Member::where('name', '石塚瑶季')->first();
        $member6 = Member::where('name', '清水理央')->first();
        $member7 = Member::where('name', '竹内希来里')->first();
        $member8 = Member::where('name', '平尾帆夏')->first();
        $member9 = Member::where('name', '平岡海月')->first();
        $member10 = Member::where('name', '宮地すみれ')->first();
        $member11 = Member::where('name', '山下葉留花')->first();
        $member12 = Member::where('name', '渡辺莉奈')->first();

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
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => true],
            $memberO->id => ['is_center' => true],
        ]);
        $songB->members()->attach([
            $member1->id => ['is_center' => false],
            $member2->id => ['is_center' => false],
            $member3->id => ['is_center' => false],
            $member4->id => ['is_center' => false],
            $member5->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $member9->id => ['is_center' => false],
            $member10->id => ['is_center' => true],
            $member11->id => ['is_center' => false],
            $member12->id => ['is_center' => false],
        ]);
        $songC->members()->attach([
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
            $memberO->id => ['is_center' => true],
        ]);
        $songD->members()->attach([
            $memberA->id => ['is_center' => false],
        ]);
        $songE->members()->attach([
            $memberD->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
        ]);
        $songF->members()->attach([
            $member1->id => ['is_center' => false],
            $member2->id => ['is_center' => false],
            $member3->id => ['is_center' => false],
            $member4->id => ['is_center' => false],
            $member5->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $member9->id => ['is_center' => false],
            $member10->id => ['is_center' => true],
            $member11->id => ['is_center' => false],
            $member12->id => ['is_center' => false],
        ]);
        $songG->members()->attach([
            $member5->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $member9->id => ['is_center' => false],
            $memberO->id => ['is_center' => false],
            $member10->id => ['is_center' => false],
            $member11->id => ['is_center' => false],
            $member12->id => ['is_center' => true],
        ]);
    }
}
