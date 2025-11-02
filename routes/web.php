<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ImageController as AdminImageController;
use App\Http\Controllers\Admin\SongController as AdminSongController;
use App\Http\Controllers\Admin\ChangelogController as AdminChangelogController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PopularController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Member;
use App\Models\Song;
use Illuminate\Support\Facades\Route;

//ホーム
Route::get('/', [HomeController::class, 'index'])->name('home');

//メンバー、楽曲一覧
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
// Route::get('/songs/{id}', [SongController::class, 'show'])->name('songs.show');
Route::get('/songs/{song}', [SongController::class, 'show'])
    ->name('songs.show')
    ->middleware('count.popularity');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
// Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/{member}', [MemberController::class, 'show'])
    ->name('members.show')
    ->middleware('count.popularity');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::view('/others', 'others.index', [
    'links' => [
        ['title' => '日向坂46推しメンチェッカーver2', 'url' => 'https://hinaselect.netlify.app/'],
        ['title' => '日向坂46推しメンチェッカー', 'url' => 'https://x.gd/8sT9P'],
        ['title' => '日向坂46メンバーのペンライトカラーが検索できます', 'url' => 'https://x.gd/0RLv3'],
        ['title' => '日向坂46クイズ 工事中...', 'url' => 'https://hinata-quiz.netlify.app/']
    ]
])->name('others.index');

Route::get('/popular', [PopularController::class, 'index'])->name('popular.index');

Route::get('/youtube/ranking', [\App\Http\Controllers\YoutubeRankingController::class, 'index'])->name('youtube.ranking');

Route::get('/timeline', [App\Http\Controllers\TimelineController::class, 'index'])->name('timeline.index');

// bot対策
Route::middleware('throttle:songs-limit')
    ->get('/songs/{id}', [SongController::class, 'show'])
    ->name('songs.show');

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

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'sitemap.xml generated';
})->middleware('auth');

require __DIR__.'/auth.php';

// timeline_convert.php (一時スクリプト)

// $text = file_get_contents(base_path('timeline_raw.txt'));
// $lines = preg_split("/\r\n|\n|\r/", trim($text));

// $timeline = [];
// $currentYear = null;

// foreach ($lines as $line) {
//     $line = trim($line);
//     if ($line === '') continue;

//     // 年の行なら新しい配列を作成
//     if (preg_match('/^(\d{4})年/u', $line, $m)) {
//         $currentYear = (int)$m[1];
//         $timeline[$currentYear] = [];
//         continue;
//     }

//     // 年が設定されていて、日付が含まれる行なら分割
//     if ($currentYear && preg_match('/^(\d{1,2}月\d{1,2}日)(.+)/u', $line, $m)) {
//         $timeline[$currentYear][] = [
//             'date' => $m[1],
//             // 'title' => mb_substr(trim($m[2]), 0, 40),
//             'description' => trim($m[2]),
//         ];
//     }
// }

// // 保存先: storage/app/data/timeline.json
// $dir = storage_path('app/data');
// if (!file_exists($dir)) mkdir($dir, 0777, true);
// file_put_contents($dir.'/timeline.json', json_encode($timeline, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

// echo "timeline.json を生成しました！\n";
