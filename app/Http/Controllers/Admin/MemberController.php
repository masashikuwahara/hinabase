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
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'constellation' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:255',
            'birthplace' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'color1' => 'nullable|string|max:255',
            'colorname1' => 'nullable|string|max:255',
            'color2' => 'nullable|string|max:255',
            'colorname2' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'graduation' => 'required|boolean',
        ]);

        Member::create([
            'name' => $request->name,
            'birthday' => $request->birthday,
            'constellation' => $request->constellation,
            'height' => $request->height,
            'blood_type' => $request->blood_type,
            'birthplace' => $request->birthplace,
            'grade' => $request->grade,
            'color1' => $request->color1,
            'colorname1' => $request->colorname1,
            'color2' => $request->color2,
            'colorname2' => $request->colorname2,
            'graduation' => $request->graduation,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.members.create')->with('success', 'メンバーを追加しました！');
    }
}
