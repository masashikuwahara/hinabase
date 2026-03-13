<?php

namespace App\Http\Controllers;

use App\Models\Member;

class HinatansaiController extends Controller
{
    public function index()
    {
        $members = Member::query()
            ->where('graduation', 0)
            ->orderByGrade()
            ->orderBy('furigana')
            ->get([
                'id',
                'name',
                'furigana',
                'grade',
                'color1',
                'colorname1',
                'color2',
                'colorname2',
        ])
        ->groupBy('grade');

        return view('hinatansai.index', compact('members'));
    }
}