<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ImageController as AdminImageController;
use App\Http\Controllers\Admin\SongController as AdminSongController;
use App\Http\Controllers\Admin\ChangelogController as AdminChangelogController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AccountController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Member;
use App\Models\Song;
use Illuminate\Support\Facades\Route;

//ホーム
Route::get('/', [HomeController::class, 'index'])->name('home');

//メンバー、楽曲一覧
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('songs.show');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::view('/others', 'others.index', [
    'links' => [
        ['title' => '日向坂46推しメンチェッカーです。', 'url' => 'https://x.gd/8sT9P'],
        ['title' => '日向坂46のペンライトカラーが検索できます。', 'url' => 'https://x.gd/0RLv3'],
        ['title' => '工事中', 'url' => ''],
        ['title' => '櫻坂46のデータベースサイトです。', 'url' => 'https://x.gd/edKLP'],
    ]
])->name('others.index');

//認証関係
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証が必要な管理ページ用ルート
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [AdminMemberController::class, 'update'])->name('members.update');
    Route::get('/images', [AdminController::class, 'images'])->name('images');
    Route::get('/images/{member}/edit', [AdminImageController::class, 'edit'])->name('images.edit');
    Route::put('/images/{member}', [AdminImageController::class, 'update'])->name('images.update');
    Route::get('/songs', [AdminController::class, 'songs'])->name('songs');
    Route::get('/songs/{song}/edit', [AdminSongController::class, 'edit'])->name('songs.edit');
    Route::put('/songs/{song}', [AdminSongController::class, 'update'])->name('songs.update');
    Route::get('/skills', [AdminController::class, 'skills'])->name('skills');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::resource('changelogs', AdminChangelogController::class)->only(['index','create','store','destroy']);
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'edit'])->name('edit');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');
        Route::put('/email', [AccountController::class, 'updateEmail'])->name('email.update');
    });
});

// サイトマップ生成
Route::get('/_make-sitemap', function () {
    $sitemap = Sitemap::create()
        // 固定ページ
        ->add(
            Url::create(route('home'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        )
        ->add(
            Url::create(route('members.index'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        )
        ->add(
            Url::create(route('songs.index'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );

    // メンバー詳細
    Member::select('id','updated_at')->chunk(500, function($chunk) use (&$sitemap){
        foreach ($chunk as $m) {
            $sitemap->add(
                Url::create(route('members.show', $m->id))
                    ->setLastModificationDate($m->updated_at ?? now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }
    });

    // 楽曲詳細
    Song::select('id','updated_at')->chunk(500, function($chunk) use (&$sitemap){
        foreach ($chunk as $s) {
            $sitemap->add(
                Url::create(route('songs.show', $s->id))
                    ->setLastModificationDate($s->updated_at ?? now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }
    });

    // public/sitemap.xml に書き出し
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'sitemap.xml generated';
})->middleware('auth');

require __DIR__.'/auth.php';
