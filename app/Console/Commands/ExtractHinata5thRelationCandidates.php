<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExtractHinata5thRelationCandidates extends Command
{
    protected $signature = 'hinata:extract-5th-rel-candidates
        {--in=blog_posts_5th.jsonl : 入力JSONL(storage/app配下)}
        {--out=relation_candidates_5th.jsonl : 出力JSONL(storage/app配下)}
        {--limit=0 : 0=無制限, 数値ならその件数だけ処理}
        {--min-members=1 : 1文内に含まれる五期生メンバー最小人数（通常2）}
        {--include-self=1 : 1=著者(五期生)のみでも抽出する（通常0）}
        {--skip-existing=1 : 1=既にoutにある post_url(=detail_url) はスキップ}';

    protected $description = '五期生ブログ本文から、関係性抽出の候補文（evidence）をJSONLで出力（五期生10名のみ検出）';

    public function handle(): int
    {
        $in = (string)$this->option('in');
        $out = (string)$this->option('out');
        $limit = (int)$this->option('limit');
        $minMembers = max(1, (int)$this->option('min-members'));
        $includeSelf = (int)$this->option('include-self') === 1;
        $skipExisting = (int)$this->option('skip-existing') === 1;

        if (!Storage::exists($in)) {
            $this->error("入力が見つかりません: storage/app/{$in}");
            return self::FAILURE;
        }

        // 再開用：既に出力済みの detail_url をスキップ
        $done = [];
        if ($skipExisting && Storage::exists($out)) {
            $existing = trim(Storage::get($out));
            if ($existing !== '') {
                foreach (preg_split("/\r\n|\n|\r/", $existing) as $line) {
                    $j = json_decode($line, true);
                    if (is_array($j) && isset($j['detail_url'])) {
                        $done[$j['detail_url']] = true;
                    }
                }
            }
        }

        // 五期生10名の検出辞書（表記ゆれ・愛称もここに足せる）
        // ※まずは確実性重視：フルネーム + よくある呼び方（例：おおたみ、にこみ）
        $members = [
            37 => ['大田美月', '大田', '美月', '美月さん', '美月ちゃん', 'おおたみ', 'おおたみさん'],
            38 => ['大野愛実', '大野', '愛実', '愛実さん', '愛実ちゃん'],
            39 => ['片山紗希', '片山', '紗希', '紗希さん', '紗希ちゃん'],
            40 => ['蔵盛妃那乃', '蔵盛', '妃那乃', '妃那乃さん', '妃那乃ちゃん'],
            41 => ['坂井新奈', '坂井', '新奈', '新奈さん', '新奈ちゃん'],
            42 => ['佐藤優羽', '佐藤', '優羽', '優羽さん', '優羽ちゃん'],
            43 => ['下田衣珠季', '下田', '衣珠季', '衣珠季さん', '衣珠季ちゃん'],
            44 => ['高井俐香', '高井', '俐香', '俐香さん', '俐香ちゃん'],
            45 => ['鶴崎仁香', '鶴崎', '仁香', '仁香さん', '仁香ちゃん', 'にこみ', 'にこみさん'],
            46 => ['松尾桜', '松尾', '桜', '桜さん', '桜ちゃん'],
        ];

        // トリガー語（まずは最小セット）
        $triggers = [
            // 行動/同行
            '一緒', '行った', '行きました', '行ってきた', '会った', '遊んだ', 'ご飯', 'ごはん', 'ランチ', 'カフェ',
            '撮ってくれた', '撮ってもらった', '行こ','行って','行けた','行けて','行きたい','行きたかった','行けなかった','一緒に',
            '撮って','撮影','写真','ツーショ','ツーショット','2ショ',
            // 授受
            'もらった', '貰った', 'いただいた', 'くれた', 'あげた', '渡した', 'プレゼント','いただきました','頂いた','差し入れ','お土産','おそろい',
            // named（固有名ラベル候補）
            '同盟', '仲間', '組', '部', '会', 'コンビ', 'ペア', 'トリオ', 'ユニット', 'チーム','界隈','担当','枠','一味','軍団',
            // generic（汎用ラベル）
            '仲良し', '同期', '同い年', '親友', '相棒', 'ライバル',
        ];

        $raw = trim(Storage::get($in));
        if ($raw === '') {
            $this->error("入力が空です: {$in}");
            return self::FAILURE;
        }

        $lines = preg_split("/\r\n|\n|\r/", $raw);

        $processed = 0;
        $written = 0;

        foreach ($lines as $line) {
            if ($limit > 0 && $processed >= $limit) break;

            $post = json_decode($line, true);
            if (!is_array($post)) continue;

            $detailUrl = $post['detail_url'] ?? null;
            $author = $post['author'] ?? null;
            $body = $post['body_text'] ?? null;

            if (!$detailUrl || !$body) continue;
            if ($skipExisting && isset($done[$detailUrl])) continue;

            $processed++;

            // 文分割
            $sentences = $this->splitSentences($body);

            foreach ($sentences as $s) {
                // 1) 五期生の検出（先にやる）
                $hits = $this->detect5thMembers($s, $members);

                // include-self=0 の場合、著者しか出てない文は落とす（既存ロジック）
                if (!$includeSelf && $author) {
                    if (count($hits) === 1) {
                        $only = array_values($hits)[0];
                        if ($only['name'] === $author || str_replace(' ', '', $only['name']) === str_replace(' ', '', $author)) {
                            continue;
                        }
                    }
                }

                // 2) ここが重要：五期生が1人以上（または2人以上）出たら候補
                if (count($hits) < $minMembers) continue;

                // 著者名を正規化（スペース除去）
                $authorNorm = $author ? preg_replace('/\s+/u', '', $author) : null;

                // hitsが1人だけで、その1人が著者なら除外（自己紹介ノイズ対策）
                if ($authorNorm && count($hits) === 1) {
                    $only = array_values($hits)[0];
                    $onlyNorm = preg_replace('/\s+/u', '', $only['name']);
                    if ($onlyNorm === $authorNorm) {
                        continue;
                    }
                }

                // 3) トリガー語（あれば付与、なければ member_mention）
                $matched = $this->matchedTriggers($s, $triggers);
                if (empty($matched)) {
                    $matched = ['member_mention'];
                }

                $candidate = [
                    'detail_url' => $detailUrl,
                    'published_at' => $post['published_at'] ?? null,
                    'author' => $author,
                    'title' => $post['title'] ?? null,
                    'sentence' => $s,
                    'triggered_by' => $matched,
                    'members' => array_values($hits),
                ];

                Storage::append($out, json_encode($candidate, JSON_UNESCAPED_UNICODE) . "\n");
                $written++;
            }

            // 進捗表示（軽め）
            if ($processed % 50 === 0) {
                $this->info("processed={$processed}, written={$written}");
            }

            $done[$detailUrl] = true;
        }

        $this->info("DONE: processed={$processed}, written={$written}");
        $this->info("saved: storage/app/{$out}");

        return self::SUCCESS;
    }

    private function splitSentences(string $text): array
    {
        // 改行は一旦スペースに寄せる（ただしURL行等は残る）
        $t = preg_replace("/\r\n|\r/", "\n", $text);
        $t = preg_replace("/[ \t]+/u", " ", $t);
        $t = preg_replace("/\n+/u", "\n", $t);

        // 句点/感嘆/疑問 + 改行 で分割（日本語寄りの簡易）
        $parts = preg_split('/(?<=[。！？\?])\s+|\n/u', $t);

        $out = [];
        foreach ($parts as $p) {
            $p = trim($p);
            if ($p === '') continue;
            // 1文が極端に短い場合はノイズになりがちなので任意で弾ける（いったん残す）
            $out[] = $p;
        }
        return $out;
    }

    private function containsAny(string $s, array $needles): bool
    {
        foreach ($needles as $n) {
            if (mb_strpos($s, $n) !== false) return true;
        }
        return false;
    }

    private function matchedTriggers(string $s, array $triggers): array
    {
        $found = [];
        foreach ($triggers as $t) {
            if (mb_strpos($s, $t) !== false) $found[] = $t;
        }
        return $found;
    }

    private function detect5thMembers(string $sentence, array $members): array
    {
        $hits = [];
        foreach ($members as $id => $terms) {
            $matched = [];
            foreach ($terms as $term) {
                if ($term === '') continue;
                if (mb_strpos($sentence, $term) !== false) {
                    $matched[] = $term;
                }
            }
            if (!empty($matched)) {
                // 表示名は辞書の先頭（フルネーム）に寄せる
                $hits[$id] = [
                    'id' => (int)$id,
                    'name' => $terms[0],
                    'matched_terms' => $matched,
                ];
            }
        }
        return $hits;
    }
}