<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
        ]);

        Member::create([
            'name' => $request->name,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.members.create')->with('success', 'メンバーが追加されました！');
    }
}
