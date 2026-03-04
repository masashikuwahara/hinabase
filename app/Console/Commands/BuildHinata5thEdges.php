<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BuildHinata5thEdges extends Command
{
    protected $signature = 'hinata:build-5th-edges
        {--in=relation_candidates_5th.jsonl : 入力JSONL(storage/app配下)}
        {--out=relations_5th_edges.jsonl : 出力JSONL(storage/app配下)}
        {--limit=0 : 0=無制限, 数値ならその件数だけ処理}
        {--skip-existing=1 : 1=既にoutにある(edge_key)はスキップ}
        {--min-to=1 : toが最低何人いれば出力するか（通常1）}';

    protected $description = '候補文(JSONL)から、五期生の関係エッジ(from=author,to=他メン)を生成してJSONLで保存';

    public function handle(): int
    {
        $in = (string)$this->option('in');
        $out = (string)$this->option('out');
        $limit = (int)$this->option('limit');
        $skipExisting = (int)$this->option('skip-existing') === 1;
        $minTo = max(1, (int)$this->option('min-to'));

        if (!Storage::exists($in)) {
            $this->error("入力が見つかりません: storage/app/{$in}");
            return self::FAILURE;
        }

        // 著者名（例: "大田 美月"）→ 五期生id へマップ
        // ※ authorのスペース有無に耐えるため正規化して照合
        $authorToId = [
            $this->norm('大田美月') => 37,
            $this->norm('大野愛実') => 38,
            $this->norm('片山紗希') => 39,
            $this->norm('蔵盛妃那乃') => 40,
            $this->norm('坂井新奈') => 41,
            $this->norm('佐藤優羽') => 42,
            $this->norm('下田衣珠季') => 43,
            $this->norm('高井俐香') => 44,
            $this->norm('鶴崎仁香') => 45,
            $this->norm('松尾桜') => 46,
        ];

        // 既出エッジキー（再開・重複防止）
        $done = [];
        if ($skipExisting && Storage::exists($out)) {
            $existing = trim(Storage::get($out));
            if ($existing !== '') {
                foreach (preg_split("/\r\n|\n|\r/", $existing) as $line) {
                    $j = json_decode($line, true);
                    if (is_array($j) && isset($j['edge_key'])) {
                        $done[$j['edge_key']] = true;
                    }
                }
            }
        }

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

            $cand = json_decode($line, true);
            if (!is_array($cand)) continue;

            $processed++;

            $author = $cand['author'] ?? null;
            $authorId = $author ? ($authorToId[$this->norm($author)] ?? null) : null;
            if (!$authorId) continue; // 五期生以外は対象外

            $members = $cand['members'] ?? [];
            if (!is_array($members) || empty($members)) continue;

            // to: 文中の五期生（author以外）
            $toIds = [];
            foreach ($members as $m) {
                $mid = $m['id'] ?? null;
                if (!$mid) continue;
                if ((int)$mid === (int)$authorId) continue;
                $toIds[(int)$mid] = true;
            }

            if (count($toIds) < $minTo) continue;

            $sentence = (string)($cand['sentence'] ?? '');
            $class = $this->classifySentence($sentence);

            foreach (array_keys($toIds) as $toId) {
                $edge = [
                    'from_id' => (int)$authorId,
                    'to_id' => (int)$toId,
                    'relation_type' => $class['relation_type'], // named_relation/generic_relation/action_relation/mention
                    'label' => $class['label'],                 // 例: "仲良し" / "○○同盟" / "photo" / "member_mention"
                    'subtype' => $class['subtype'],             // 例: photo/meal/outing/gift/relay...
                    'detail_url' => $cand['detail_url'] ?? null,
                    'published_at' => $cand['published_at'] ?? null,
                    'title' => $cand['title'] ?? null,
                    'evidence_sentence' => $sentence,
                ];

                // 重複キー：同一記事×同一文×同一(from,to,type,label)
                $edgeKey = $this->edgeKey($edge);
                $edge['edge_key'] = $edgeKey;

                if ($skipExisting && isset($done[$edgeKey])) continue;

                Storage::append($out, json_encode($edge, JSON_UNESCAPED_UNICODE) . "\n");
                $done[$edgeKey] = true;
                $written++;
            }

            if ($processed % 200 === 0) {
                $this->info("processed={$processed}, written={$written}");
            }
        }

        $this->info("DONE: processed={$processed}, written={$written}");
        $this->info("saved: storage/app/{$out}");

        return self::SUCCESS;
    }

    private function norm(string $s): string
    {
        // スペース除去 + 全角スペース除去
        $s = preg_replace('/[ 　]+/u', '', $s);
        return $s ?? '';
    }

    private function edgeKey(array $edge): string
    {
        $base = implode('|', [
            $edge['detail_url'] ?? '',
            $edge['published_at'] ?? '',
            $edge['from_id'] ?? '',
            $edge['to_id'] ?? '',
            $edge['relation_type'] ?? '',
            $edge['label'] ?? '',
            $edge['subtype'] ?? '',
            $edge['evidence_sentence'] ?? '',
        ]);
        return sha1($base);
    }

    /**
     * 文をルールで分類して relation_type / label / subtype を返す
     */
    private function classifySentence(string $s): array
    {
        // named（固有名ラベル候補）
        $namedKeywords = ['同盟','組','部','軍団','界隈','ファミリー','姉妹','担当','枠','コンビ','ペア','トリオ','ユニット','チーム'];
        foreach ($namedKeywords as $kw) {
            if (mb_strpos($s, $kw) !== false) {
            // named（固有名ラベル候補）
            // 「抽出できた場合のみ named」とする（キーワード事前判定は不要）
            $label = $this->extractNamedLabel($s);
            if ($label !== null) {
                return ['relation_type' => 'named_relation', 'label' => $label, 'subtype' => 'named'];
            }
            }
        }

        // generic（汎用）
        $generic = ['仲良し', '同期', '同い年', '親友', '相棒', 'ライバル'];
        foreach ($generic as $g) {
            if (mb_strpos($s, $g) !== false) {
                return ['relation_type' => 'generic_relation', 'label' => $g, 'subtype' => 'generic'];
            }
        }

        // action（行動）
        $actionMap = [
            'photo' => ['撮って', '撮影', '写真', 'ツーショ', 'ツーショット', '2ショ'],
            'meal'  => ['ご飯', 'ごはん', 'ランチ', 'カフェ', 'ご飯行', 'ごはん行'],
            'outing'=> ['行った', '行ってきた', '行きました', '出かけ', 'おでかけ'],
            'gift'  => ['もらった', '貰った', 'いただいた', 'くれた', 'あげた', '渡した', 'プレゼント', 'お土産', '差し入れ'],
            'relay' => ['バトン', '受け取りました', '受け取りました', '回ってきました', 'リレー'],
        ];
        foreach ($actionMap as $subtype => $words) {
            foreach ($words as $w) {
                if (mb_strpos($s, $w) !== false) {
                    return ['relation_type' => 'action_relation', 'label' => $subtype, 'subtype' => $subtype];
                }
            }
        }

        // 列挙っぽい文（読点が多い）を軽く識別
        $commaCount = mb_substr_count($s, '、');
        if ($commaCount >= 2) {
            return ['relation_type' => 'mention', 'label' => 'member_list', 'subtype' => 'mention_list'];
        }
        // それ以外は mention
        return ['relation_type' => 'mention', 'label' => 'member_mention', 'subtype' => 'mention'];
    }

    private function extractNamedLabel(string $s): ?string
    {
        $t = preg_replace('/[「」『』\(\)（）\[\]【】]/u', ' ', $s);
        $t = preg_replace('/\s+/u', ' ', $t);
        $t = trim($t);

        // 特例：○○のお部屋（最優先）
        if (preg_match('/([ぁ-んァ-ン一-龥A-Za-z0-9・ー]{1,20}のお部屋)/u', $t, $m)) {
            return $m[1];
        }

        $cands = [];

        // 1) 強い named 候補（同盟/組/軍団/界隈など）
        if (preg_match_all('/([ぁ-んァ-ン一-龥A-Za-z0-9・ー]{1,10}(同盟|組|軍団|界隈|ファミリー|姉妹|担当|枠))/u', $t, $mm)) {
            foreach ($mm[1] as $hit) $cands[] = $hit;
        }

        // 2) 「〜部」（部屋は除外）
        if (preg_match_all('/([ぁ-んァ-ン一-龥A-Za-z0-9・ー]{1,10}部)(?!屋)/u', $t, $mm2)) {
            foreach ($mm2[1] as $hit) $cands[] = $hit;
        }

        // 3) 「〜の会」：ただし「会話」を含む文では誤爆しやすいのでスキップ
        if (mb_strpos($t, '会話') === false) {
            if (preg_match_all('/([ぁ-んァ-ン一-龥A-Za-z0-9・ー]{1,10}の会)/u', $t, $mm3)) {
                foreach ($mm3[1] as $hit) $cands[] = $hit;
            }
        }

        if (empty($cands)) return null;

        // 念のため、ラベルが named の語尾型に一致しないものは捨てる（誤爆除去）
        $cands = array_values(array_filter($cands, function ($x) {
            return (bool)preg_match('/(同盟|組|部|軍団|界隈|ファミリー|姉妹|担当|枠|の会)$/u', $x);
        }));
        if (empty($cands)) return null;

        // ストップワード（named にしたくない誤爆）
        $stop = ['番組', '全部', '一部', '二部', '本部', '支部'];
        $cands = array_values(array_filter($cands, function ($x) use ($stop) {
            foreach ($stop as $w) {
                if (mb_substr($x, -mb_strlen($w)) === $w) {
                    return false; // 末尾が stop なら除外
                }
            }
            return true;
        }));
        if (empty($cands)) return null;

        $last = $cands[count($cands) - 1];

        // 「〜組」は、ひらがな接頭辞が混ざりやすいので「漢字/英数字寄り+組」に寄せる
        if (mb_substr($last, -1) === '組') {
            // 例: のがまた嬉しくて地方組 → 地方組
            // 例: こちらの番組 → 番組（ただし stop で弾ける）
            if (preg_match('/([一-龥A-Za-z0-9・ー]{1,10}組)$/u', $last, $m)) {
                $last = $m[1];
            }
            if (in_array($last, $stop, true)) return null;
            return $last;
        }

        // 「〜部」も同様に整形（全部/一部などは弾く）
        if (mb_substr($last, -1) === '部') {
            if (preg_match('/([一-龥A-Za-z0-9・ー]{1,10}部)$/u', $last, $m)) {
                $last = $m[1];
            }
            if (in_array($last, $stop, true)) return null;
            return $last;
        }

        return $last;

    }
}