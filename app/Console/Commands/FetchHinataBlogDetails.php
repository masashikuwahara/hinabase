<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchHinataBlogDetails extends Command
{
    protected $signature = 'hinata:fetch-blog-details
        {--in=blog_detail_urls_5th.csv : 入力CSV(storage/app配下)}
        {--out=blog_posts_5th.jsonl : 出力JSONL(storage/app配下)}
        {--sleep=700 : 1リクエストごとの待機(ms)}
        {--limit=0 : 0=無制限, 数値ならその件数だけ処理}
        {--timeout=15 : HTTP timeout(秒)}
        {--skip-existing=1 : 1=既にoutにあるURLはスキップ}';

    protected $description = '公式ブログ detail から title / published_at / body_text を抽出して JSONL で保存';

    public function handle(): int
    {
        $in = (string)$this->option('in');
        $out = (string)$this->option('out');
        $sleepMs = (int)$this->option('sleep');
        $limit = (int)$this->option('limit');
        $timeout = (int)$this->option('timeout');
        $skipExisting = (int)$this->option('skip-existing') === 1;

        if (!Storage::exists($in)) {
            $this->error("入力CSVが見つかりません: storage/app/{$in}");
            return self::FAILURE;
        }

        // 既存outからURL集合を作る（再開用）
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

        $raw = Storage::get($in);
        $lines = preg_split("/\r\n|\n|\r/", trim($raw));
        if (!$lines || count($lines) < 2) {
            $this->error("CSVが空、またはヘッダのみです: {$in}");
            return self::FAILURE;
        }
        array_shift($lines); // header

        $written = 0;
        $processed = 0;

        foreach ($lines as $line) {
            if ($limit > 0 && $processed >= $limit) break;

            $cols = str_getcsv($line);
            if (count($cols) < 5) continue;

            [$name, $ct, $dy, $listUrl, $detailUrl] = $cols;

            if ($skipExisting && isset($done[$detailUrl])) {
                continue;
            }

            $processed++;
            $this->line("[{$processed}] fetch detail: {$name} {$detailUrl}");

            try {
                $res = Http::timeout($timeout)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (compatible; HinataBlogCrawler/1.0)',
                    ])
                    ->get($detailUrl);
            } catch (\Throwable $e) {
                $this->warn("  !! request error: {$e->getMessage()}");
                usleep($sleepMs * 1000);
                continue;
            }

            if (!$res->ok()) {
                $this->warn("  !! http status: {$res->status()}");
                usleep($sleepMs * 1000);
                continue;
            }

            $html = (string)$res->body();
            $parsed = $this->parseDetailHtmlToTextBlocks($html);

            // JSONL 1行出力
            $row = [
                'name' => $name,
                'ct' => (int)$ct,
                'dy' => $dy,
                'list_url' => $listUrl,
                'detail_url' => $detailUrl,
                'title' => $parsed['title'] ?? null,
                'published_at' => $parsed['published_at'] ?? null, // "2026-02-21 18:30"
                'author' => $parsed['author'] ?? null,
                'body_text' => $parsed['body_text'] ?? null,
            ];

            Storage::append($out, json_encode($row, JSON_UNESCAPED_UNICODE));
            $written++;

            $this->info("  OK: {$row['title']} / {$row['published_at']}");
            usleep($sleepMs * 1000);
        }

        $this->info("DONE: {$written}件を書き込みました -> storage/app/{$out}");
        return self::SUCCESS;
    }

    /**
     * 公式ブログdetail HTMLを「テキスト化→行解析」で抽出する。
     * class/DOMに依存しない（構造が多少変わっても壊れにくい）方式。
     */
    private function parseDetailHtmlToTextBlocks(string $html): array
    {
        // 1) 改行を入れたいタグを先に改行へ変換
        $html = preg_replace('#<\s*br\s*/?\s*>#i', "\n", $html);
        $html = preg_replace('#</\s*(p|div|li|h1|h2|h3|h4|h5|tr)\s*>#i', "\n", $html);

        // 2) タグ除去→HTMLエンティティ復号→行分割
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace("/\r\n|\r/", "\n", $text);

        $lines = array_values(array_filter(array_map(
            fn($l) => trim(preg_replace('/\s+/u', ' ', $l)),
            explode("\n", $text)
        ), fn($l) => $l !== ''));

        // 3) published_at 行（例: 2026.2.21 18:30）を探す
        $dtIdx = null;
        for ($i = 0; $i < count($lines); $i++) {
            if (preg_match('/^\d{4}\.\d{1,2}\.\d{1,2}\s+\d{1,2}:\d{2}$/u', $lines[$i])) {
                $dtIdx = $i;
                break;
            }
        }

        $title = null;
        $publishedAt = null;
        $author = null;

        if ($dtIdx !== null) {
            // タイトルは日時の直前行（空は除去済み）
            $title = $lines[$dtIdx - 1] ?? null;

            // 著者は日時の次の行（このページでは「大野 愛実」など）
            $author = $lines[$dtIdx + 1] ?? null;

            // 日時を YYYY-MM-DD HH:MM に整形
            if (preg_match('/^(\d{4})\.(\d{1,2})\.(\d{1,2})\s+(\d{1,2}:\d{2})$/u', $lines[$dtIdx], $m)) {
                $y = $m[1];
                $mo = str_pad($m[2], 2, '0', STR_PAD_LEFT);
                $d = str_pad($m[3], 2, '0', STR_PAD_LEFT);
                $publishedAt = "{$y}-{$mo}-{$d} {$m[4]}";
            }
        }

        // 4) 本文は「著者の次の行」から、「NEW ENTRY」手前まで
        $startBodyIdx = ($dtIdx !== null) ? ($dtIdx + 2) : 0;

        $endBodyIdx = count($lines);
        for ($i = $startBodyIdx; $i < count($lines); $i++) {
            if ($lines[$i] === 'NEW ENTRY') {
                $endBodyIdx = $i;
                break;
            }
        }

        // さらに安全策：NEW ENTRYが無い場合は「記事一覧」「メンバー別ブログ」等を終端候補に
        if ($endBodyIdx === count($lines)) {
            foreach (['記事一覧', 'メンバー別ブログ', '日向坂46の', 'OFFICIAL BLOG'] as $marker) {
                for ($i = $startBodyIdx; $i < count($lines); $i++) {
                    if (mb_strpos($lines[$i], $marker) !== false) {
                        $endBodyIdx = $i;
                        break 2;
                    }
                }
            }
        }

        $bodyLines = array_slice($lines, $startBodyIdx, max(0, $endBodyIdx - $startBodyIdx));
        // 5) 本文の「終端っぽい行」を見つけたら、そこまでで切る（NEW ENTRYが無いケース対策）
        $cutIdx = null;
        for ($i = 0; $i < count($bodyLines); $i++) {
            $l = $bodyLines[$i];

            // 例: "チョコバナナかバナナチョコか2026.2.2 20:51" のように別記事日時が混ざる
            if (preg_match('/\d{4}\.\d{1,2}\.\d{1,2}\s+\d{1,2}:\d{2}/u', $l)) {
                $cutIdx = $i;
                break;
            }

            // 記事一覧などのナビ
            if (mb_strpos($l, '記事一覧') !== false) {
                $cutIdx = $i;
                break;
            }
            if (mb_strpos($l, 'メンバー別ブログ') !== false) {
                $cutIdx = $i;
                break;
            }
            if (mb_strpos($l, 'OFFICIAL BLOG') !== false) {
                $cutIdx = $i;
                break;
            }
        }

        if ($cutIdx !== null) {
            $bodyLines = array_slice($bodyLines, 0, $cutIdx);
        }

        // 6) 仕上げ
        $bodyText = trim(implode("\n", $bodyLines));

        return [
            'title' => $title,
            'published_at' => $publishedAt,
            'author' => $author,
            'body_text' => $bodyText,
        ];
    }
}