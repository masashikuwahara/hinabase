<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Changelog;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = \App\Models\Changelog::ordered()->paginate(20);
        return view('admin.changelogs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.changelogs.create', ['logs' => collect()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => ['required','date'],
            'version' => ['nullable','string','max:20'],
            'title' => ['required','string','max:255'],
            'body' => ['nullable','string'],
            'link' => ['nullable','url'],
            'pinned' => ['sometimes','boolean'],
        ]);
        $data['pinned'] = (bool)($data['pinned'] ?? false);
        \App\Models\Changelog::create($data);
        return redirect()->route('admin.changelogs.index')->with('status', '登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Changelog $changelogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Changelog $changelog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Changelog $changelogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Changelog $changelogs)
    {
        //
    }
}
