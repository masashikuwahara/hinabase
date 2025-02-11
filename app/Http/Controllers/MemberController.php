<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $currentMembers = Member::where('graduation', 0)->get()->groupBy('grade');
        $graduatedMembers = Member::where('graduation', 1)->get()->groupBy('grade');
        return view('members.index', compact('currentMembers', 'graduatedMembers'));
    }

    public function show($id)
    {
        $member = Member::with('songs')->findOrFail($id); // メンバー情報と参加楽曲を取得
        return view('members.show', compact('member'));
    }
}
