<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Song;
use App\Models\Changelog;

class HomeController extends Controller
{
    public function index()
    {
        $members = Member::inRandomOrder()->take(8)->get();

        $songs = Song::inRandomOrder()->take(8)->get();

        $logs = Changelog::ordered()->limit(20)->get();

        return view('index', compact('members','songs' ,'logs'));
    }
}