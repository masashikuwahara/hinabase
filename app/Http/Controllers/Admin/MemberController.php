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
            'birthday' => 'required|date',
            'constellation' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:255',
            'birthplace' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'color1' => 'nullable|string|max:255',
            'color2' => 'nullable|string|max:255',
            'selection' => 'nullable|string|max:255',
            'graduation' => 'required|boolean',
        ]);

        Member::create($request->all());

        return redirect()->route('admin.members.create')->with('success', 'メンバーが追加されました！');
    }
}
