<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;

class HomeController extends Controller
{
    public function index()
    {
        // メンバーを7人ランダム取得
        $members = Member::inRandomOrder()->take(7)->get();

        // 楽曲を7曲ランダム取得
        $songs = Song::inRandomOrder()->take(7)->get();

        // ビューにデータを渡す
        return view('index', compact('members', 'songs'));
    }
}