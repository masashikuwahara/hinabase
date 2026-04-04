<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Song;
use App\Models\Changelog;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Tokyo')->startOfDay();

        $members = Member::inRandomOrder()->where('graduation', 0)->take(7)->get();

        $songs = Song::inRandomOrder()->take(7)->get();

        $logs = Changelog::ordered()->limit(50)->get();

        $birthdayMembers = Member::query()
            ->whereMonth('birthday', $today->month)
            ->whereDay('birthday', $today->day)
            ->orderBy('furigana')
            ->get();

        return view('index', compact('members','songs' ,'logs' ,'birthdayMembers'));
        // return view('index', compact('members','songs' ,'logs'));
    }
}