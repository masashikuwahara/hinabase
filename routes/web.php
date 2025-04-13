<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\SongController as AdminSongController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//ホーム
Route::get('/', [HomeController::class, 'index'])->name('home');

//メンバー、楽曲一覧
Route::get('/songs', [SongController::class, 'index'])->name('songs.index'); // 楽曲一覧
Route::get('/songs/{id}', [SongController::class, 'show'])->name('songs.show'); // 楽曲詳細
Route::get('/members', [MemberController::class, 'index'])->name('members.index'); // メンバー一覧
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show'); // プロフィール詳細

//認証関係
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証が必要な管理ページ用ルート
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/members', [AdminController::class, 'members'])->name('admin.members');
    Route::post('/members', [AdminMemberController::class, 'store'])->name('admin.members.store');
    Route::get('/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/members/{member}', [AdminMemberController::class, 'update'])->name('admin.members.update');
    Route::get('/songs', [AdminController::class, 'songs'])->name('admin.songs');
    Route::post('/songs', [AdminSongController::class, 'store'])->name('admin.songs.store');
    Route::get('/skills', [AdminController::class, 'skills'])->name('admin.skills');
    Route::post('/skills', [SkillController::class, 'store'])->name('admin.skills.store');
});

//検索結果ページへのルート
Route::get('/search', [SearchController::class, 'search'])->name('search');

require __DIR__.'/auth.php';
