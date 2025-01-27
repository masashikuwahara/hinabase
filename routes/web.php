<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
