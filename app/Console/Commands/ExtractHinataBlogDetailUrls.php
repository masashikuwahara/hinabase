<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ExtractHinataBlogDetailUrls extends Command
{
    protected $signature = 'hinata:extract-blog-detail-urls
        {--in=blog_urls_5th.csv : 入力CSV(storage/app配下)}
        {--out=blog_detail_urls_5th.csv : 出力CSV(storage/app配下)}
        {--sleep=500 : 1リクエストごとの待機(ms)}
        {--limit=0 : 0=無制限, 数値ならその件数だけ処理}
        {--timeout=15 : HTTP timeout(秒)}';

    protected $description = '月別一覧(member/list?ct=..&dy=..)から記事detail URL(/diary/detail/..)を抽出してCSV出力';

    public function handle(): int
    {
        $in = (string)$this->option('in');
        $out = (string)$this->option('out');
        $sleepMs = (int)$this->option('sleep');
        $limit = (int)$this->option('limit');
        $timeout = (int)$this->option('timeout');

        if (!Storage::exists($in)) {
            $this->error("入力CSVが見つかりません: storage/app/{$in}");
            return self::FAILURE;
        }

        $raw = Storage::get($in);
        $lines = preg_split("/\r\n|\n|\r/", trim($raw));
        if (!$lines || count($lines) < 2) {
            $this->error("CSVが空、またはヘッダのみです: {$in}");
            return self::FAILURE;
        }

        // ヘッダ: name,ct,dy,url
        array_shift($lines);

        $seenListUrl = [];
        $seenDetailUrl = [];

        $rowsOut = [];
        $processed = 0;

        foreach ($lines as $line) {
            if ($limit > 0 && $processed >= $limit) break;

            $cols = str_getcsv($line);
            if (count($cols) < 4) continue;

            [$name, $ct, $dy, $listUrl] = $cols;

            // 同じlistUrlは1回だけ取りに行く
            if (isset($seenListUrl[$listUrl])) continue;
            $seenListUrl[$listUrl] = true;

            $processed++;
            $this->line("[$processed] fetch: {$name} ct={$ct} dy={$dy}");

            try {
                $res = Http::timeout($timeout)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (compatible; HinataBlogCrawler/1.0)',
                    ])
                    ->get($listUrl);
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

            // /s/official/diary/detail/XXXX または /s/official/diary/detail/O... などを拾う
            preg_match_all('#/s/official/diary/detail/[^"\'>\s]+#u', $html, $m);
            $paths = $m[0] ?? [];

            $count = 0;
            foreach ($paths as $path) {
                $detailUrl = 'https://www.hinatazaka46.com' . $path;
                if (isset($seenDetailUrl[$detailUrl])) continue;
                $seenDetailUrl[$detailUrl] = true;

                $rowsOut[] = [
                    'name' => $name,
                    'ct' => $ct,
                    'dy' => $dy,
                    'list_url' => $listUrl,
                    'detail_url' => $detailUrl,
                ];
                $count++;
            }

            $this->info("  +{$count} detail urls");
            usleep($sleepMs * 1000);
        }

        // 出力CSV
        $csv = "name,ct,dy,list_url,detail_url\n";
        foreach ($rowsOut as $r) {
            $csv .= "{$r['name']},{$r['ct']},{$r['dy']},{$r['list_url']},{$r['detail_url']}\n";
        }
        Storage::put($out, $csv);

        $this->info("OK: detail URLを " . count($rowsOut) . " 件出力しました");
        $this->info("saved: storage/app/{$out}");

        return self::SUCCESS;
    }
}