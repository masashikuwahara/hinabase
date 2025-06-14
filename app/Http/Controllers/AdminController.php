<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Song;
use App\Models\Skill;

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
        $members = Member::paginate(10);
        return view('admin.members.index', compact('members'));
    }

    // メンバー画像管理
    public function images()
    {
        $members = Member::paginate(10);
        return view('admin.images.index', compact('members'));
    }

    // 楽曲管理
    public function songs()
    {
        $songs = Song::paginate(10);
        return view('admin.songs.index', compact('songs'));
    }

    //スキル管理
    public function skills()
    {
        $members = Skill::all();
        return view('admin.skills.index', compact('members'));
    }
}
