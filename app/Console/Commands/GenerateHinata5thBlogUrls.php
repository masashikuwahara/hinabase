<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use DateTime;
use DateTimeZone;

class GenerateHinata5thBlogUrls extends Command
{
    /**
     * コマンド名
     */
    protected $signature = 'hinata:5th-blog-urls
        {--start=202504 : 開始月(YYYYMM)}
        {--end=auto : 終了月(YYYYMM) or auto(今月)}
        {--order=desc : 月の順序 desc(最新→過去) / asc(過去→最新)}
        {--out=blog_urls_5th.csv : 出力ファイル(storage/app 配下)}';

    /**
     * 説明
     */
    protected $description = '日向坂46 五期生10名の公式ブログ(月別dy付き)URLを一括生成してCSV出力します';

    public function handle(): int
    {
        $members = [
            ['name' => '大田美月',   'ct' => 37],
            ['name' => '大野愛実',   'ct' => 38],
            ['name' => '片山紗希',   'ct' => 39],
            ['name' => '蔵盛妃那乃', 'ct' => 40],
            ['name' => '坂井新奈',   'ct' => 41],
            ['name' => '佐藤優羽',   'ct' => 42],
            ['name' => '下田衣珠季', 'ct' => 43],
            ['name' => '高井俐香',   'ct' => 44],
            ['name' => '鶴崎仁香',   'ct' => 45],
            ['name' => '松尾桜',     'ct' => 46],
        ];

        $startYm = (string)$this->option('start');
        $endOpt  = (string)$this->option('end');
        $order   = (string)$this->option('order');
        $out     = (string)$this->option('out');

        $endYm = $endOpt === 'auto'
            ? (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('Ym')
            : $endOpt;

        if (!preg_match('/^\d{6}$/', $startYm)) {
            $this->error("start は YYYYMM 形式で指定してください: {$startYm}");
            return self::FAILURE;
        }
        if (!preg_match('/^\d{6}$/', $endYm)) {
            $this->error("end は YYYYMM 形式(または auto)で指定してください: {$endOpt}");
            return self::FAILURE;
        }

        $months = $this->generateYmList($startYm, $endYm);
        if (empty($months)) {
            $this->error("月リストが空です。start/end を確認してください: {$startYm}〜{$endYm}");
            return self::FAILURE;
        }

        if ($order === 'desc') {
            $months = array_reverse($months); // 最新→過去
        } elseif ($order !== 'asc') {
            $this->error("order は asc または desc を指定してください: {$order}");
            return self::FAILURE;
        }

        $base = 'https://www.hinatazaka46.com/s/official/diary/member/list?ima=0000&ct=%d&dy=%s';

        // CSV生成
        $csv = "name,ct,dy,url\n";
        $count = 0;

        foreach ($members as $m) {
            foreach ($months as $ym) {
                $url = sprintf($base, $m['ct'], $ym);
                $csv .= "{$m['name']},{$m['ct']},{$ym},{$url}\n";
                $count++;
            }
        }

        Storage::put($out, $csv);

        $this->info("OK: {$count}件のURLを出力しました");
        $this->info("saved: storage/app/{$out}");
        $this->info("range: {$startYm}〜{$endYm} / order: {$order}");

        return self::SUCCESS;
    }

    /**
     * 月リスト(YYYYMM)を生成（昇順）
     */
    private function generateYmList(string $startYm, string $endYm): array
    {
        $start = DateTime::createFromFormat('Ym', $startYm);
        $end   = DateTime::createFromFormat('Ym', $endYm);

        if (!$start || !$end) return [];

        $start->setTime(0, 0, 0);
        $end->setTime(0, 0, 0);

        if ($start > $end) return [];

        $list = [];
        $cur = clone $start;

        while ($cur <= $end) {
            $list[] = $cur->format('Ym');
            $cur->modify('+1 month');
        }

        return $list;
    }
}