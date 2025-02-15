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
            'name' => '石塚瑶季',
            'nickname' => 'たまちゃん、たまにゃん',
            'birthday' => '2004-08-06',
            'constellation' => 'しし座',
            'height' => '153.5',
            'blood_type' => 'A型',
            'birthplace' => '東京都',
            'grade' => '四期生',
            'color1' => '#fceeeb',
            'colorname1' => 'サクラピンク',
            'color2' => '#ee7800',
            'colorname2' => 'オレンジ',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/tamaki.jpg'
        ]);
        Member::create([
            'name' => '岸帆夏',
            'nickname' => 'きしほ',
            'birthday' => '2004-08-15',
            'constellation' => 'しし座',
            'height' => '156.5',
            'blood_type' => 'O型',
            'birthplace' => '東京都',
            'grade' => '四期生',
            'color1' => '#ffdc00',
            'colorname1' => 'イエロー',
            'color2' => '#ffffff',
            'colorname2' => 'ホワイト',
            'graduation' => '1',
            'introduction' => '',
            'image' => 'images/kishiho.jpg'
        ]);
        Member::create([
            'name' => '小西夏菜実',
            'nickname' => 'ななぴょん、小西ん、524773、こにガチ',
            'birthday' => '2004-10-03',
            'constellation' => 'てんびん座',
            'height' => '164.8',
            'blood_type' => 'B型',
            'birthplace' => '兵庫県',
            'grade' => '四期生',
            'color1' => '#9b72b0',
            'colorname1' => 'パープル',
            'color2' => '#0000ff',
            'colorname2' => 'ブルー',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/nanami.jpg'
        ]);
        Member::create([
            'name' => '清水理央',
            'nickname' => 'りおたむ',
            'birthday' => '2005-01-15',
            'constellation' => 'やぎ座',
            'height' => '165',
            'blood_type' => 'AB型',
            'birthplace' => '千葉県',
            'grade' => '四期生',
            'color1' => '#98fb98',
            'colorname1' => 'パールグリーン',
            'color2' => '#ee7800',
            'colorname2' => 'オレンジ',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/rio.jpg'
        ]);
        Member::create([
            'name' => '正源司陽子',
            'nickname' => 'しょげこ',
            'birthday' => '2007-02-14',
            'constellation' => 'みずがめ座',
            'height' => '158.4',
            'blood_type' => 'B型',
            'birthplace' => '兵庫県',
            'grade' => '四期生',
            'color1' => '#ee7800',
            'colorname1' => 'オレンジ',
            'color2' => '#ff0000',
            'colorname2' => 'レッド',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/youko.jpg'
        ]);
        Member::create([
            'name' => '竹内希来里',
            'nickname' => 'きらりんちょ',
            'birthday' => '2006-02-20',
            'constellation' => 'うお座',
            'height' => '154.5',
            'blood_type' => 'AB型',
            'birthplace' => '広島県',
            'grade' => '四期生',
            'color1' => '#ffdc00',
            'colorname1' => 'イエロー',
            'color2' => '#ff0000',
            'colorname2' => 'レッド',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/kirari.jpg'
        ]);
        Member::create([
            'name' => '平尾帆夏',
            'nickname' => 'ひらほ〜',
            'birthday' => '2003-07-31',
            'constellation' => 'しし座',
            'height' => '158.5',
            'blood_type' => 'A型',
            'birthplace' => '鳥取県',
            'grade' => '四期生',
            'color1' => '#49BDF0',
            'colorname1' => 'パステルブルー',
            'color2' => '#ee7800',
            'colorname2' => 'オレンジ',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/hiraho.jpg'
        ]);
        Member::create([
            'name' => '平岡海月',
            'nickname' => 'くらげ',
            'birthday' => '2002-04-09',
            'constellation' => 'おひつじ座',
            'height' => '157.9',
            'blood_type' => 'A型',
            'birthplace' => '福井県',
            'grade' => '四期生',
            'color1' => '#0000ff',
            'colorname1' => 'ブルー',
            'color2' => '#ffdc00',
            'colorname2' => 'イエロー',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/mitsuki.jpg'
        ]);
        Member::create([
            'name' => '藤嶌果歩',
            'nickname' => 'かほりん',
            'birthday' => '2006-08-07',
            'constellation' => 'しし座',
            'height' => '160.4',
            'blood_type' => '不明',
            'birthplace' => '北海道',
            'grade' => '四期生',
            'color1' => '#fceeeb',
            'colorname1' => 'サクラピンク',
            'color2' => '#0000ff',
            'colorname2' => 'ブルー',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/kaho.jpg'
        ]);
        Member::create([
            'name' => '宮地すみれ',
            'nickname' => 'すみレジェンド',
            'birthday' => '2005-12-31',
            'constellation' => 'やぎ座',
            'height' => '165',
            'blood_type' => '不明',
            'birthplace' => '神奈川県',
            'grade' => '四期生',
            'color1' => '#5a4498',
            'colorname1' => 'バイオレット',
            'color2' => '#ff0000',
            'colorname2' => 'レッド',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/sumire.jpg'
        ]);
        Member::create([
            'name' => '山下葉留花',
            'nickname' => 'はるはる',
            'birthday' => '2003-05-20',
            'constellation' => 'おうし座',
            'height' => '161',
            'blood_type' => 'O型',
            'birthplace' => '愛知県',
            'grade' => '四期生',
            'color1' => '#ffffff',
            'colorname1' => 'ホワイト',
            'color2' => '#00a968',
            'colorname2' => 'エメラルドグリーン',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/haruka.jpg'
        ]);
        Member::create([
            'name' => '渡辺莉奈',
            'nickname' => 'りなし',
            'birthday' => '2009-02-07',
            'constellation' => 'みずがめ座',
            'height' => '154',
            'blood_type' => 'A型',
            'birthplace' => '福岡県',
            'grade' => '四期生',
            'color1' => '#9b72b0',
            'colorname1' => 'パープル',
            'color2' => '#FFC0CB',
            'colorname2' => 'ピンク',
            'graduation' => '0',
            'introduction' => '',
            'image' => 'images/rina.jpg'
        ]);
    }
}
