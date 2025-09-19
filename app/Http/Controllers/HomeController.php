<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;
use App\Models\Changelog;

class HomeController extends Controller
{
    public function index()
    {
        // メンバーを7人ランダム取得
        $members = Member::inRandomOrder()->take(7)->get();

        // 楽曲を7曲ランダム取得
        $songs = Song::inRandomOrder()->take(7)->get();

        // 更新履歴を50件取得
        $logs = Changelog::ordered()->limit(20)->get();

        // ビューにデータを渡す
        return view('index', compact('members', 'songs' ,'logs'));
    }
}