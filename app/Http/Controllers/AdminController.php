<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;

class AdminController extends Controller
{
    // 管理ページのトップ
    public function index()
    {
        return view('admin.dashboard');
    }

    // メンバー管理
    public function members()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    // 楽曲管理
    public function songs()
    {
        $songs = Song::all();
        return view('admin.songs.index', compact('songs'));
    }
}
