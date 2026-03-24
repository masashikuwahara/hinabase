<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Song;
use Illuminate\Console\Command;

class BackfillSlugs extends Command
{
    protected $signature = 'slugs:backfill {--force : Overwrite existing slugs}';
    protected $description = 'Backfill slug values for members and songs';

    public function handle(): int
    {
        $force = (bool) $this->option('force');

        $memberSlugs = [
            '長濱ねる'   => 'neru-nagahama',
            '井口眞緒'   => 'mao-iguchi',
            '潮紗理菜'   => 'sarina-ushio',
            '柿崎芽実'   => 'memi-kakizaki',
            '影山優佳'   => 'yuka-kageyama',
            '加藤史帆'   => 'shiho-kato',
            '齊藤京子'   => 'kyoko-saito',
            '佐々木久美' => 'kumi-sasaki',
            '佐々木美玲' => 'mirei-sasaki',
            '高瀬愛奈'   => 'mana-takase',
            '高本彩花'   => 'ayaka-takamoto',
            '東村芽依'   => 'mei-higashimura',
            '金村美玖'   => 'miku-kanemura',
            '河田陽菜'   => 'hina-kawata',
            '小坂菜緒'   => 'nao-kosaka',
            '富田鈴花'   => 'suzuka-tomita',
            '丹生明里'   => 'akari-nibu',
            '濱岸ひより' => 'hiyori-hamagishi',
            '松田好花'   => 'konoka-matsuda',
            '宮田愛萌'   => 'manamo-miyata',
            '渡邉美穂'   => 'miho-watanabe',
            '上村ひなの' => 'hinano-kamimura',
            '髙橋未来虹' => 'mikuni-takahashi',
            '森本茉莉'   => 'marie-morimoto',
            '山口陽世'   => 'haruyo-yamaguchi',
            '石塚瑶季'   => 'tamaki-ishizuka',
            '岸帆夏'     => 'honoka-kishi',
            '小西夏菜実' => 'nanami-konishi',
            '清水理央'   => 'rio-shimizu',
            '正源司陽子' => 'yoko-shogenji',
            '竹内希来里' => 'kirari-takeuchi',
            '平尾帆夏'   => 'honoka-hirao',
            '平岡海月'   => 'mitsuki-hiraoka',
            '藤嶌果歩'   => 'kaho-fujishima',
            '宮地すみれ' => 'sumire-miyachi',
            '山下葉留花' => 'haruka-yamashita',
            '渡辺莉奈'   => 'rina-watanabe',
            '大田美月'   => 'mizuki-ota',
            '大野愛実'   => 'manami-ono',
            '片山紗希'   => 'saki-katayama',
            '蔵盛妃那乃' => 'hinano-kuramori',
            '坂井新奈'   => 'nina-sakai',
            '佐藤優羽'   => 'yu-sato',
            '下田衣珠季' => 'izuki-shimoda',
            '高井俐香'   => 'rika-takai',
            '鶴崎仁香'   => 'niko-tsurusaki',
            '松尾桜'     => 'sakura-matsuo',
        ];

        $songSlugs = [
            'ひらがなけやき' => 'hiragana-keyaki',
            '誰よりも高く跳べ!' => 'dare-yori-mo-takaku-tobe',
            'W-KEYAKIZAKAの詩' => 'w-keyakizaka-no-uta',
            '僕たちは付き合っている' => 'bokutachi-wa-tsukiatteiru',
            '沈黙した恋人よ' => 'chinmoku-shita-koibito-yo',
            '永遠の白線' => 'eien-no-hakusen',
            'それでも歩いてる' => 'soredemo-aruiteru',
            'NO WAR in the future' => 'no-war-in-the-future',
            'イマニミテイロ' => 'ima-ni-miteiro',
            '半分の記憶' => 'hanbun-no-kioku',
            '期待していない自分' => 'kitai-shiteinai-jibun',
            '線香花火が消えるまで' => 'senko-hanabi-ga-kieru-made',
            '未熟な怒り' => 'mijuku-na-ikari',
            'わずかな光' => 'wazuka-na-hikari',
            'ノックをするな!' => 'nokku-o-suru-na',
            'ハロウィンのカボチャが割れた' => 'halloween-no-kabocha-ga-wareta',
            '約束の卵' => 'yakusoku-no-tamago',
            'キレイになりたい' => 'kirei-ni-naritai',
            '夏色のミュール' => 'natsuiro-no-mule',
            '男友達だから' => 'otoko-tomodachi-dakara',
            '最前列へ' => 'saizenretsu-e',
            'おいで夏の境界線' => 'oide-natsu-no-kyokaisen',
            '車輪が軋むように君が泣く' => 'sharin-ga-kishimu-you-ni-kimi-ga-naku',
            '三輪車に乗りたい' => 'sanrinsha-ni-noritai',
            'こんな整列を誰がさせるのか?' => 'konna-seiretsu-o-dare-ga-saseru-no-ka',
            '居心地悪く、大人になった' => 'igokochi-waruku-otona-ni-natta',
            '割れないシャボン玉' => 'warenai-shabondama',
            'ひらがなで恋したい' => 'hiragana-de-koishitai',
            'ハッピーオーラ' => 'happy-aura',
            '君に話しておきたいこと' => 'kimi-ni-hanashiteokitai-koto',
            '抱きしめてやる' => 'dakishimete-yaru',
            'キュン' => 'kyun',
            'JOYFUL LOVE' => 'joyful-love',
            '耳に落ちる涙' => 'mimi-ni-ochiru-namida',
            'Footsteps' => 'footsteps',
            'ときめき草' => 'tokimeki-gusa',
            '沈黙が愛なら' => 'chinmoku-ga-ai-nara',
            'ドレミソラシド' => 'doremisorashido',
            'キツネ' => 'kitsune',
            'My god' => 'my-god',
            'Cage' => 'cage',
            'やさしさが邪魔をする' => 'yasashisa-ga-jama-o-suru',
            'Dash&Rush' => 'dash-and-rush',
            'こんなに好きになっちゃっていいの?' => 'konnani-suki-ni-nacchatte-iino',
            'ホントの時間' => 'honto-no-jikan',
            'まさか 偶然…' => 'masaka-guzen',
            '一番好きだとみんなに言っていた小説のタイトルを思い出せない' => 'ichiban-suki-da-to-minna-ni-itteita-shosetsu-no-taitoru-o-omoidasenai',
            'ママのドレス' => 'mama-no-dress',
            '川は流れる' => 'kawa-wa-nagareru',
            'ソンナコトナイヨ' => 'sonna-koto-nai-yo',
            '青春の馬' => 'seishun-no-uma',
            '好きということは…' => 'suki-to-iu-koto-wa',
            '窓を開けなくても' => 'mado-o-akenakutemo',
            'ナゼー' => 'nazee',
            '君のため何ができるだろう' => 'kimi-no-tame-nani-ga-dekiru-daro',
            'Overture' => 'overture',
            'アザトカワイイ' => 'azato-kawaii',
            'この夏をジャムにしよう' => 'kono-natsu-o-jam-ni-shiyo',
            '誰よりも高く跳べ!2020' => 'dare-yori-mo-takaku-tobe-2020',
            '日向坂' => 'hinatazaka',
            'NO WAR in the future 2020' => 'no-war-in-the-future-2020',
            'ただがむしゃらに' => 'tada-gamushara-ni',
            'どうして雨だと言ったんだろう?' => 'doshite-ame-da-to-ittandarou',
            'My fans' => 'my-fans',
            'See Through' => 'see-through',
            '約束の卵 2020' => 'yakusoku-no-tamago-2020',
            '君しか勝たん' => 'kimi-shika-katan',
            '声の足跡' => 'koe-no-ashiato',
            '嘆きのDelete' => 'nageki-no-delete',
            'Right?' => 'right',
            'どうする?どうする?どうする?' => 'do-suru-do-suru-do-suru',
            '世界にはThank you!が溢れている' => 'sekai-ni-wa-thank-you-ga-afureteiru',
            '膨大な夢に押し潰されて' => 'boudai-na-yume-ni-oshitsubusarete',
            'ってか' => 'tteka',
            '何度でも何度でも' => 'nando-demo-nando-demo',
            '思いがけないダブルレインボー' => 'omoigakenai-double-rainbow',
            '夢は何歳まで?' => 'yume-wa-nansai-made',
            'あくびLetter' => 'akubi-letter',
            '酸っぱい自己嫌悪' => 'suppai-jiko-keno',
            'アディショナルタイム' => 'additional-time',
            '僕なんか' => 'boku-nanka',
            '飛行機雲ができる理由' => 'hikokigumo-ga-dekiru-riyu',
            'もうこんなに好きになれない' => 'mou-konnani-suki-ni-narenai',
            'ゴーフルと君' => 'gofuru-to-kimi',
            '真夜中の懺悔大会' => 'mayonaka-no-zange-taikai',
            '恋した魚は空を飛ぶ' => 'koishita-sakana-wa-sora-o-tobu',
            '知らないうちに愛されていた' => 'shiranai-uchi-ni-aisareteita',
            '月と星が踊るMidnight' => 'tsuki-to-hoshi-ga-odoru-midnight',
            'HEY!OHISAMA!' => 'hey-ohisama',
            '孤独な瞬間' => 'kodoku-na-shunkan',
            '10秒天使' => 'juu-byo-tenshi',
            'その他大勢タイプ' => 'sonota-ozei-type',
            'ブルーベリー＆ラズベリー' => 'blueberry-and-raspberry',
            '一生一度の夏' => 'issho-ichido-no-natsu',
            'One choice' => 'one-choice',
            '恋は逃げ足が早い' => 'koi-wa-nigeashi-ga-hayai',
            '愛はこっちのものだ' => 'ai-wa-kotchi-no-mono-da',
            'Youre in my way' => 'youre-in-my-way',
            'パクチー ピーマン グリーンピース' => 'pakuchi-piiman-green-peas',
            'シーラカンス' => 'coelacanth',
            '友よ 一番星だ' => 'tomo-yo-ichibanboshi-da',
            'Am I ready?' => 'am-i-ready',
            '見たことない魔物' => 'mita-koto-nai-mamono',
            '接触と感情' => 'sesshoku-to-kanjo',
            '骨組みだらけの夏休み' => 'honegumi-darake-no-natsuyasumi',
            '君は逆立ちできるか?' => 'kimi-wa-sakadachi-dekiru-ka',
            '愛のひきこもり' => 'ai-no-hikikomori',
            'ガラス窓が汚れてる' => 'garasu-mado-ga-yogoreteru',
            '君は0から1になれ' => 'kimi-wa-zero-kara-ichi-ni-nare',
            '最初の白夜' => 'saisho-no-byakuya',
            '自販機と主体性' => 'jihanki-to-shutaisei',
            '青春ポップコーン' => 'seishun-popcorn',
            'ロッククライミング' => 'rock-climbing',
            '君はハニーデュー' => 'kimi-wa-honeydew',
            '錆つかない剣を持て!' => 'sabitsukanai-ken-o-mote',
            'どこまでが道なんだ?' => 'doko-made-ga-michi-nanda',
            '恋とあんバター' => 'koi-to-an-butter',
            '夜明けのスピード' => 'yoake-no-speed',
            '雨が降ったって' => 'ame-ga-futtatte',
            '僕に続け' => 'boku-ni-tsuzuke',
            '絶対的第六感' => 'zettai-teki-dairokkan',
            '君を覚えてない' => 'kimi-o-oboetenai',
            '永遠のソフィア' => 'eien-no-sophia',
            'どっちが先に言う?' => 'docchi-ga-saki-ni-iu',
            '妄想コスモス' => 'moso-cosmos',
            '雪は降る 心の世界に' => 'yuki-wa-furu-kokoro-no-sekai-ni',
            '夕陽Dance' => 'yuhi-dance',
            '卒業写真だけが知ってる' => 'sotsugyo-shashin-dake-ga-shitteru',
            'SUZUKA' => 'suzuka',
            '孤独たちよ' => 'kodoku-tachi-yo',
            'あの娘にグイグイ' => 'ano-ko-ni-guigui',
            '43年待ちのコロッケ' => '43-nen-machi-no-korokke',
            'Instead of you' => 'instead-of-you',
            '足の小指を箪笥の角にぶつけた' => 'ashi-no-koyubi-o-tansu-no-kado-ni-butsuketa',
            'レントゲン眼鏡' => 'rentogen-megane',
            'HELL ROSE' => 'hell-rose',
            '恋のトレイン' => 'koi-no-train',
            'Love yourself!' => 'love-yourself',
            'ジャーマンアイリス' => 'german-iris',
            'You are forever' => 'you-are-forever',
            'やらかした' => 'yarakashita',
            'What you like!' => 'what-you-like',
            'あのね そのね' => 'anone-sonone',
            '海風とわがまま' => 'umikaze-to-wagamama',
            'お願いバッハ！' => 'onegai-bach',
            '空飛ぶ車' => 'soratobu-kuruma',
            'ライバル多すぎ問題' => 'raibaru-oosugi-mondai',
            '愛はこっちのものだ 2025' => 'ai-wa-kotchi-no-mono-da-2025',
            '言葉の限界' => 'kotoba-no-genkai',
            'ハロウィンのカボチャが割れた 2025' => 'halloween-no-kabocha-ga-wareta-2025',
            'Expected value' => 'expected-value',
            'クリフハンガー' => 'cliffhanger',
            '君と生きる' => 'kimi-to-ikiru',
            '好きになるクレッシェンド' => 'suki-ni-naru-crescendo',
            'Surf’s up girl' => 'surfs-up-girl',
            '涙目の太陽' => 'namidame-no-taiyo',
            '恋と慣性の法則' => 'koi-to-kansei-no-hosoku',
            'Second Jump' => 'second-jump',
        ];

        $this->info('--- members ---');
        $this->fillMembers($memberSlugs, $force);

        $this->newLine();
        $this->info('--- songs ---');
        $this->fillSongs($songSlugs, $force);

        $this->newLine();
        $this->info('Slug backfill finished.');

        return self::SUCCESS;
    }

    private function fillMembers(array $memberSlugs, bool $force): void
    {
        $duplicates = array_diff_assoc($memberSlugs, array_unique($memberSlugs));
        if (!empty($duplicates)) {
            $this->error('memberSlugs に重複slugがあります。処理を中断しました。');
            return;
        }

        $members = Member::query()->get();

        foreach ($members as $member) {
            $name = $member->name ?? null;

            if (!$name) {
                $this->warn("member id={$member->id}: name がないためスキップ");
                continue;
            }

            if (!array_key_exists($name, $memberSlugs)) {
                $this->warn("member id={$member->id} {$name}: slug未定義のためスキップ");
                continue;
            }

            if (!$force && !empty($member->slug)) {
                $this->line("member id={$member->id} {$name}: 既存slugあり ({$member->slug})");
                continue;
            }

            $slug = $memberSlugs[$name];

            $exists = Member::query()
                ->where('slug', $slug)
                ->where('id', '!=', $member->id)
                ->exists();

            if ($exists) {
                $this->error("member id={$member->id} {$name}: slug重複 {$slug}");
                continue;
            }

            $member->slug = $slug;
            $member->save();

            $this->info("member id={$member->id} {$name} => {$slug}");
        }
    }

    private function fillSongs(array $songSlugs, bool $force): void
    {
        $duplicates = array_diff_assoc($songSlugs, array_unique($songSlugs));
        if (!empty($duplicates)) {
            $this->error('songSlugs に重複slugがあります。処理を中断しました。');
            return;
        }

        $songs = Song::query()->get();

        foreach ($songs as $song) {
            $title = $song->title ?? null;

            if (!$title) {
                $this->warn("song id={$song->id}: title がないためスキップ");
                continue;
            }

            if (!array_key_exists($title, $songSlugs)) {
                $this->warn("song id={$song->id} {$title}: slug未定義のためスキップ");
                continue;
            }

            if (!$force && !empty($song->slug)) {
                $this->line("song id={$song->id} {$title}: 既存slugあり ({$song->slug})");
                continue;
            }

            $slug = $songSlugs[$title];

            $exists = Song::query()
                ->where('slug', $slug)
                ->where('id', '!=', $song->id)
                ->exists();

            if ($exists) {
                $this->error("song id={$song->id} {$title}: slug重複 {$slug}");
                continue;
            }

            $song->slug = $slug;
            $song->save();

            $this->info("song id={$song->id} {$title} => {$slug}");
        }
    }
}