<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use DateTime;
use DateTimeZone;

class ExportUnitAliases5thJson extends Command
{
    protected $signature = 'hinata:export-unit-aliases-json
        {--in=unit_alias_candidates_5th.csv : 入力CSV(storage/app/private の想定)}
        {--out=private/unit_aliases_5th.json : 出力JSON(storage/app配下)}
        {--min-count=2 : この回数以上のlabelのみ採用}
        {--use-suggest=1 : 1=suggest_is_unit=1のみ採用, 0=無視して全部採用}
        {--exclude= : 除外正規表現（labelにマッチしたら除外）}
        {--top=200 : 最大何件まで出力するか}';

    protected $description = 'unit_alias_candidates_5th.csv からユニット辞書JSONを生成（最短運用用）';

    public function handle(): int
    {
        // あなたの環境は private ディスク運用っぽいので、まずは default Storage を使う
        // ※FILESYSTEM_DISK の設定により private が root になっているケースを考慮
        $in = (string)$this->option('in');
        $out = (string)$this->option('out');
        $minCount = (int)$this->option('min-count');
        $useSuggest = (int)$this->option('use-suggest') === 1;
        $exclude = (string)$this->option('exclude');
        $top = (int)$this->option('top');

        // Windows パスの揺れ対策
        $in = str_replace('\\', '/', $in);
        $out = str_replace('\\', '/', $out);

        if (!Storage::exists($in)) {
            $this->error("入力が見つかりません: {$in}");
            $this->line("※privateディスク運用の場合、--in から private/ を外す必要があることがあります。");
            return self::FAILURE;
        }

        $raw = Storage::get($in);
        $lines = preg_split("/\r\n|\n|\r/", trim($raw));
        if (!$lines || count($lines) < 2) {
            $this->error("CSVが空、またはヘッダのみです: {$in}");
            return self::FAILURE;
        }

        // ヘッダ
        $header = str_getcsv(array_shift($lines));

        if (!empty($header)) {
            // 1) UTF-8 BOM（バイト列）を除去
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

            // 2) U+FEFF（ゼロ幅NBSP）を除去（PHP 7.0+）
            $header[0] = str_replace("\u{FEFF}", '', $header[0]);

            // 3) 念のため先頭の不可視文字をtrim（BOMが別表現で残るケース対策）
            $header[0] = ltrim($header[0], "\xEF\xBB\xBF");
        }

        $idx = array_flip($header);
        foreach (['label','count','top_members','top_pairs','suggest_is_unit'] as $col) {
            if (!isset($idx[$col])) {
                $this->error("CSVに必要な列がありません: {$col}");
                $this->error("header=" . implode(',', $header));
                return self::FAILURE;
            }
        }

        $aliases = [];
        $added = 0;

        foreach ($lines as $line) {
            $cols = str_getcsv($line);
            if (count($cols) < count($header)) continue;

            $label = (string)($cols[$idx['label']] ?? '');
            $count = (int)($cols[$idx['count']] ?? 0);
            $topMembersStr = (string)($cols[$idx['top_members']] ?? '');
            $topPairsStr = (string)($cols[$idx['top_pairs']] ?? '');
            $suggest = (int)($cols[$idx['suggest_is_unit']] ?? 0);

            if ($label === '') continue;
            if ($count < $minCount) continue;
            if ($useSuggest && $suggest !== 1) continue;
            if ($exclude !== '' && @preg_match("/{$exclude}/u", $label)) {
                if (preg_match("/{$exclude}/u", $label)) continue;
            }

            $aliases[] = [
                'label' => $label,
                'count' => $count,
                'top_members' => $this->parseTopMembers($topMembersStr),
                'top_pairs' => $this->parseTopPairs($topPairsStr),
                'is_unit' => true,
                'display_name' => $label,
                'note' => '',
            ];

            $added++;
            if ($top > 0 && $added >= $top) break;
        }

        $now = new DateTime('now', new DateTimeZone('Asia/Tokyo'));

        $json = [
            'generated_at' => $now->format('c'),
            'source_csv' => $in,
            'rules' => [
                'min_count' => $minCount,
                'use_suggest_is_unit' => $useSuggest,
                'excluded_regex' => $exclude,
                'top' => $top,
            ],
            'aliases' => $aliases,
        ];

        Storage::put($out, json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $this->info("saved: storage/app/{$out}");
        $this->info("aliases: " . count($aliases));

        return self::SUCCESS;
    }

    private function parseTopMembers(string $s): array
    {
        // 例: "37:12 | 44:8 | 42:3"
        $out = [];
        foreach (explode('|', $s) as $part) {
            $part = trim($part);
            if ($part === '') continue;
            if (preg_match('/^(\d+):(\d+)$/', $part, $m)) {
                $out[] = ['member_id' => (int)$m[1], 'score' => (int)$m[2]];
            }
        }
        return $out;
    }

    private function parseTopPairs(string $s): array
    {
        // 例: "37-44:5 | 40-44:2"
        $out = [];
        foreach (explode('|', $s) as $part) {
            $part = trim($part);
            if ($part === '') continue;
            if (preg_match('/^(\d+)-(\d+):(\d+)$/', $part, $m)) {
                $out[] = ['from_id' => (int)$m[1], 'to_id' => (int)$m[2], 'score' => (int)$m[3]];
            }
        }
        return $out;
    }
}