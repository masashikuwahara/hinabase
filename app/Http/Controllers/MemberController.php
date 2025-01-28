<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all(); // メンバー情報を全件取得
        return view('members.index', compact('members'));
    }

    public function show($id)
    {
        $member = Member::with('songs')->findOrFail($id); // メンバー情報と参加楽曲を取得
        return view('members.show', compact('member'));
    }
}
