<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    public function index()
    {
        $path = storage_path('app/data/timeline.json');

        if (!file_exists($path)) {
            abort(500, "timeline.json が見つかりません: {$path}");
        }

        $json = file_get_contents($path);
        $timeline = json_decode($json, true);

        if ($timeline === null) {
            abort(500, "timeline.json の読み込みに失敗しました。JSON構文または文字コードを確認してください。");
        }

        return view('timeline.index', compact('timeline'));
    }
}
