<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'constellation' => 'nullable|string|max:255',
            'height' => 'nullable|numeric',
            'blood_type' => 'nullable|string|max:3',
            'birthplace' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'color1' => 'nullable|string|max:20',
            'color2' => 'nullable|string|max:20',
            'colorname1' => 'nullable|string|max:50',
            'colorname2' => 'nullable|string|max:50',
            'introduction' => 'nullable|string',
            'sns' => 'nullable|url',
        ]);
        $member->update($request->all());
        
        return redirect()->route('members.show', $member)->with('success', 'メンバー情報を更新しました。');
    }
}
