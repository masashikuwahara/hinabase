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
        $songA = Song::where('title', '卒業写真だけが知ってる')->first();
        $songB = Song::where('title', 'SUZUKA')->first();
        $songC = Song::where('title', '孤独たちよ')->first();
        $songD = Song::where('title', 'あの娘にグイグイ')->first();
        $songE = Song::where('title', '43年待ちのコロッケ')->first();
        $songF = Song::where('title', 'Instead of you')->first();
        $songG = Song::where('title', '足の小指を箪笥の角にぶつけた')->first();

        $memberA = Member::where('name', '佐々木久美')->first();
        $memberB = Member::where('name', '佐々木美玲')->first();
        $memberC = Member::where('name', '金村美玖')->first();
        $memberD = Member::where('name', '河田陽菜')->first();
        $memberE = Member::where('name', '小坂菜緒')->first();
        $memberF = Member::where('name', '松田好花')->first();
        $memberG = Member::where('name', '上村ひなの')->first();
        $memberH = Member::where('name', '森本茉莉')->first();
        $memberI = Member::where('name', '山口陽世')->first();
        $memberJ = Member::where('name', '正源司陽子')->first();
        $memberK = Member::where('name', '平尾帆夏')->first();
        $memberL = Member::where('name', '藤嶌果歩')->first();
        $memberM = Member::where('name', '宮地すみれ')->first();
        $memberN = Member::where('name', '山下葉留花')->first();

        $member1 = Member::where('name', '高瀬愛奈')->first();
        $member2 = Member::where('name', '富田鈴花')->first();
        $member3 = Member::where('name', '髙橋未来虹')->first();
        $member4 = Member::where('name', '石塚瑶季')->first();
        $member5 = Member::where('name', '小西夏菜実')->first();
        $member6 = Member::where('name', '清水理央')->first();
        $member7 = Member::where('name', '竹内希来里')->first();
        $member8 = Member::where('name', '平岡海月')->first();
        $member9 = Member::where('name', '渡辺莉奈')->first();

        $songA->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => true],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
        ]);
        $songB->members()->attach([
            $member1->id => ['is_center' => false],
            $member2->id => ['is_center' => true],
            $member3->id => ['is_center' => false],
            $member4->id => ['is_center' => false],
            $member5->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $member9->id => ['is_center' => false],
        ]);
        $songC->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => true],
            $memberF->id => ['is_center' => false],
            $memberG->id => ['is_center' => false],
            $memberH->id => ['is_center' => false],
            $memberI->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => false],
        ]);
        $songD->members()->attach([
            $member1->id => ['is_center' => false],
            $member2->id => ['is_center' => true],
            $member3->id => ['is_center' => false],
            $member4->id => ['is_center' => false],
            $member5->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $member9->id => ['is_center' => false],
        ]);
        $songE->members()->attach([
            $memberC->id => ['is_center' => false],
            $memberD->id => ['is_center' => false],
            $memberE->id => ['is_center' => false],
            $member2->id => ['is_center' => false],
            $memberF->id => ['is_center' => false],
        ]);
        $songF->members()->attach([
            $memberA->id => ['is_center' => false],
            $memberB->id => ['is_center' => false],
            $member1->id => ['is_center' => false],
        ]);
        $songG->members()->attach([
            $member4->id => ['is_center' => false],
            $member5->id => ['is_center' => false],
            $member6->id => ['is_center' => false],
            $memberJ->id => ['is_center' => false],
            $member7->id => ['is_center' => false],
            $memberK->id => ['is_center' => false],
            $member8->id => ['is_center' => false],
            $memberL->id => ['is_center' => false],
            $memberM->id => ['is_center' => false],
            $memberN->id => ['is_center' => true],
            $member9->id => ['is_center' => false],
        ]);
    }
}
