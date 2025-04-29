<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Member;

class ImageController extends Controller
{
    public function index()
    {
        //
    }
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.images.edit', compact('member'));
    }
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }

            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('images', $filename,'public');
            $member->image = $path;
        }

        $member->save();
        
        return redirect()->route('admin.images')->with('success', 'メンバー画像を更新しました。');
    }
}
