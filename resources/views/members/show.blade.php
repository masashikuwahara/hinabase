@extends('layouts.main')

@section('title', $member->name . '（日向坂46）プロフィール | HINABASE')
@section('meta_description', Str::limit(strip_tags($member->bio ?? ($member->name . 'のプロフィール・出演情報')), 120))

@section('og_title', $member->name . ' | HINABASE')
@section('og_description', Str::limit(strip_tags($member->bio ?? ($member->name . 'のプロフィール・出演情報')), 120))
@section('og_image', $member->image
    ? asset('storage/' . $member->image)
    : ($member->image_url ?? 'https://kasumizaka46.com/storage/images/logo.png'))

@push('head_meta')
    <link rel="canonical" href="{{ route('members.show', $member->id) }}">

    <meta property="og:type" content="profile">
    <meta property="profile:username" content="{{ $member->name }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    @php
        $person = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $member->name,
            'alternateName' => $member->furigana,
            'url' => route('members.show', $member->id),
            'image' => $member->image ? asset('storage/' . $member->image) : ($member->image_url ?? null),
            'memberOf' => [
                '@type' => 'MusicGroup',
                'name' => '日向坂46',
            ],
        ];

        if (!empty($member->height)) {
            $person['height'] = [
                '@type' => 'QuantitativeValue',
                'value' => (float) $member->height,
                'unitText' => 'cm',
            ];
        }

        if (!empty($member->birthday)) {
            $person['birthDate'] = \Carbon\Carbon::parse($member->birthday)->toDateString();
        }

        if (!empty($member->sns)) {
            $person['sameAs'] = [$member->sns];
        }

        if (!empty($member->birthplace)) {
            $person['homeLocation'] = [
                '@type' => 'Place',
                'name' => $member->birthplace,
            ];
        }

        $webPage = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            'name' => $member->name . '（日向坂46）プロフィール | HINABASE',
            'url' => route('members.show', $member->id),
            'mainEntity' => [
                '@type' => 'Person',
                'name' => $member->name,
                'url' => route('members.show', $member->id),
            ],
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => 'HINABASE',
                'url' => url('/'),
            ],
        ];

        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'ホーム',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'メンバー一覧',
                    'item' => route('members.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $member->name,
                    'item' => route('members.show', $member->id),
                ],
            ],
        ];

        $videoLd = null;
        if (!empty($member->promotion_video)) {
            $videoLd = [
                '@context' => 'https://schema.org',
                '@type' => 'VideoObject',
                'name' => $member->name . ' 個人PV',
                'description' => $member->name . 'の個人PV',
                'thumbnailUrl' => [
                    $member->image
                        ? asset('storage/' . $member->image)
                        : ($member->image_url ?? 'https://kasumizaka46.com/storage/images/logo.png')
                ],
            ];

            if (preg_match('/src="([^"]+)"/', $member->promotion_video, $m)) {
                $videoLd['embedUrl'] = $m[1];
            }
        }
    @endphp

    <script type="application/ld+json">{!! json_encode($person, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($webPage, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    @if($videoLd)
        <script type="application/ld+json">{!! json_encode($videoLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-4 px-4 max-w-6xl mx-auto" aria-label="パンくず">
    <ol class="flex flex-wrap items-center gap-2">
        <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
        <li>›</li>
        <li aria-current="page">{{ $member->name }}</li>
    </ol>
</nav>

<main class="container mx-auto mt-8 px-4 max-w-6xl">
    <header>
        <h1 class="text-3xl font-bold font-mont text-center">{{ $member->name }}</h1>
        <p class="text-xl text-center mt-2">{{ $member->furigana }}</p>
        <p class="text-sm text-center text-gray-600 mt-3">
            日向坂46の{{ $member->name }}のプロフィール、参加楽曲、センター曲数、関連情報をまとめています。
        </p>
    </header>

    <section class="flex flex-col md:flex-row items-center mt-8 bg-white p-6 shadow-md rounded-lg">
        <div class="flex-shrink-0">
            <img src="{{ asset('storage/' . $member->image) }}"
                 alt="{{ $member->name }}（日向坂46）"
                 class="w-56 h-72 object-cover rounded-lg shadow-md"
                 loading="lazy"
                 width="384" height="512">
        </div>

        <div class="md:ml-8 mt-4 md:mt-0 flex-1">
            <h2 class="text-xl font-semibold font-mont">プロフィール</h2>
            <ul class="mt-2 text-gray-800 space-y-1">
                <li><strong>ニックネーム:</strong> {{ $member->nickname }}</li>
                <li><strong>生年月日:</strong> {{ \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日') }}</li>
                <li><strong>星座:</strong> {{ $member->constellation }}</li>
                <li><strong>身長:</strong> {{ fmod((float)$member->height, 1.0) === 0.0 ? number_format($member->height, 0) : number_format($member->height, 1) }}cm</li>
                <li><strong>血液型:</strong> {{ $member->blood_type }}</li>
                <li><strong>出身地:</strong> {{ $member->birthplace }}</li>
                <li><strong>加入:</strong> {{ $member->grade }}</li>
                @if ($member->final_membership_date)
                    <li><strong>最終在籍日:</strong> {{ \Carbon\Carbon::parse($member->final_membership_date)->format('Y年m月d日') }}</li>
                @endif
                <li><strong>参加楽曲数:</strong> {{ $songCount }}</li>
                <li><strong>選抜回数:</strong> {{ $titlesongCount }}</li>
                <li><strong>センター曲数:</strong> {{ $centerCount }}</li>
                <li>
                    <strong class="mr-2">ペンライトカラー:</strong>
                    <div class="inline-flex items-center space-x-4 mt-2">
                        <div class="rounded px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color1 }}">
                            {{ $member->colorname1 }}
                        </div>
                        <div class="rounded px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color2 }}">
                            {{ $member->colorname2 }}
                        </div>
                    </div>
                </li>
                @if ($member->sns)
                    <li class="flex items-center">
                        <strong>SNS:</strong>&nbsp;
                        <a href="{{ $member->sns }}" target="_blank" rel="noopener noreferrer nofollow">
                            <img src="{{ asset('/storage/photos/insta.png') }}"
                                 alt="Instagram"
                                 class="w-7 object-cover rounded-lg shadow-md">
                        </a>
                    </li>
                @endif
                <li><strong>キャラクター:</strong> {{ $member->introduction }}</li>
                @if ($member->post_graduation_activity)
                    <li><strong>卒業後の活動:</strong> {{ $member->post_graduation_activity }}</li>
                @endif
            </ul>

            {{-- 一覧導線 --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="{{ route('members.index') }}"
                   class="block rounded-lg border bg-gray-50 px-4 py-3 text-sm font-semibold hover:bg-gray-100 transition">
                    メンバー一覧トップ
                </a>

                @if($member->graduation == 0 && Route::has('members.current'))
                    <a href="{{ route('members.current') }}"
                       class="block rounded-lg border bg-gray-50 px-4 py-3 text-sm font-semibold hover:bg-gray-100 transition">
                        現役メンバー一覧
                    </a>
                @elseif($member->graduation == 1 && Route::has('members.graduates'))
                    <a href="{{ route('members.graduates') }}"
                       class="block rounded-lg border bg-gray-50 px-4 py-3 text-sm font-semibold hover:bg-gray-100 transition">
                        卒業メンバー一覧
                    </a>
                @endif

                @if(Route::has('members.generation'))
                    <a href="{{ route('members.generation') }}"
                       class="block rounded-lg border bg-gray-50 px-4 py-3 text-sm font-semibold hover:bg-gray-100 transition">
                        {{ $member->grade }}を含む期別一覧
                    </a>
                @endif
            </div>
        </div>

        <div class="md:ml-8 w-72 h-72 mt-6 md:mt-0">
            <canvas id="radarChart"></canvas>
            <p class="text-xs text-gray-500 mt-2">注：ぶりっ子は㋳も含む</p>
        </div>
    </section>

    {{-- 公式ブログ --}}
    <section class="flex flex-col md:flex-row items-start mt-8 bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold font-mont mb-4 md:mb-0 md:mr-4 md:flex-none">公式ブログ</h2>
        <div class="mt-2 text-blue-700 font-semibold hover:text-indigo-600 md:mt-0 md:flex-1">
            {!! $blogHtml !!}
        </div>
    </section>

    {{-- 前後メンバー --}}
    @if($previousMember || $nextMember)
        <section class="mt-8 bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold font-mont mb-4">前後のメンバー</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($previousMember)
                    <a href="{{ route('members.show', $previousMember->id) }}"
                    class="block rounded-xl border p-4 hover:bg-gray-50 transition">
                        <p class="text-sm text-gray-500 mb-2">← 前のメンバー</p>
                        <div class="flex items-center gap-4">
                            <img
                                src="{{ asset('storage/' . ($previousMember->image ?? 'default.jpg')) }}"
                                alt="{{ $previousMember->name }}"
                                class="w-16 h-16 object-cover rounded-full shadow"
                                loading="lazy"
                                width="64"
                                height="64"
                            >
                            <div>
                                <p class="font-bold text-gray-900">{{ $previousMember->name }}</p>
                                <p class="text-sm text-gray-600">{{ $previousMember->grade }}</p>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="rounded-xl border p-4 bg-gray-50 text-gray-400">
                        <p class="text-sm">← 前のメンバーはいません</p>
                    </div>
                @endif

                @if($nextMember)
                    <a href="{{ route('members.show', $nextMember->id) }}"
                    class="block rounded-xl border p-4 hover:bg-gray-50 transition">
                        <p class="text-sm text-gray-500 mb-2">次のメンバー →</p>
                        <div class="flex items-center gap-4">
                            <img
                                src="{{ asset('storage/' . ($nextMember->image ?? 'default.jpg')) }}"
                                alt="{{ $nextMember->name }}"
                                class="w-16 h-16 object-cover rounded-full shadow"
                                loading="lazy"
                                width="64"
                                height="64"
                            >
                            <div>
                                <p class="font-bold text-gray-900">{{ $nextMember->name }}</p>
                                <p class="text-sm text-gray-600">{{ $nextMember->grade }}</p>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="rounded-xl border p-4 bg-gray-50 text-gray-400">
                        <p class="text-sm">次のメンバーはいません →</p>
                    </div>
                @endif
            </div>

            <p class="text-xs text-gray-500 mt-4">
                メンバーは50音順を基準に前後表示しています。
            </p>
        </section>
    @endif

    {{-- 同期メンバー --}}
    @if(isset($sameGenMembers) && $sameGenMembers->isNotEmpty())
        <section class="mt-8 bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <h2 class="text-xl font-semibold font-mont">
                    同じ{{ $member->grade }}メンバー
                </h2>

                @if(Route::has('members.generation'))
                    <a href="{{ route('members.generation') }}"
                       class="text-sm text-blue-600 hover:underline">
                        期別メンバー一覧を見る
                    </a>
                @endif
            </div>

            <ul class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($sameGenMembers as $mate)
                    <li class="text-center">
                        <a href="{{ route('members.show', $mate->id) }}" class="block hover:opacity-80">
                            <img
                                src="{{ asset('storage/' . $mate->image) }}"
                                alt="{{ $mate->name }}"
                                class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto shadow"
                                loading="lazy"
                                width="96" height="96"
                            >
                            <span class="mt-2 text-sm font-bold block">{{ $mate->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- 個人PV --}}
    @if (!empty($member->promotion_video))
        <section class="bg-white p-6 shadow-md rounded-lg mt-6">
            <h2 class="text-xl font-bold text-gray-800">個人PV</h2>
            <div class="mt-4 youtube-ratio">
                {!! $member->promotion_video !!}
            </div>
        </section>
    @endif

    {{-- 表示切り替えボタン --}}
    <div class="mt-6 flex flex-wrap gap-4">
        <button
            onclick="showAllSongs()"
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
            すべて表示
        </button>
        <button
            onclick="showCenterOnly()"
            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700 transition">
            センター曲のみ表示
        </button>
    </div>

    {{-- 参加楽曲リスト --}}
    <section class="mt-8">
        <h2 class="text-2xl font-semibold font-mont">参加楽曲</h2>
        @if ($member->songs->isEmpty())
            <p class="mt-2 text-gray-700">まだ参加楽曲はありません。</p>
        @else
            <ul id="songList" class="mt-4 space-y-2">
                @foreach ($member->songs as $song)
                    <li class="bg-white p-4 shadow-md rounded-lg"
                        data-center="{{ $song->pivot->is_center ? '1' : '0' }}">
                        <a href="{{ route('songs.show', $song->id) }}"
                           class="block text-lg font-semibold hover:text-blue-600">
                            {{ $song->title }}
                            @if ($song->pivot->is_center)
                                <strong class="text-red-600">（センター）</strong>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    {{-- 関連コンテンツ --}}
    <section class="mt-10 bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold font-mont">関連コンテンツ</h2>
        <p class="text-sm text-gray-600 mt-2">
            {{ $member->name }}に関連する一覧ページや特集ページです。メンバー情報をあわせて確認できます。
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            {{-- 期別一覧 --}}
            @if(Route::has('members.generation'))
                <a href="{{ route('members.generation') }}"
                class="block rounded-xl border bg-white p-4 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $member->grade }}を含む期別メンバー一覧</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $member->grade }}の在籍メンバー・卒業メンバーを一覧で確認できます。
                    </p>
                </a>
            @endif

            {{-- timeline --}}
            @if(Route::has('timeline.index'))
                <a href="{{ route('timeline.index') }}"
                class="block rounded-xl border bg-white p-4 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-900">日向坂46ヒストリー</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        加入時期やグループの流れを時系列で確認できます。
                    </p>
                </a>
            @endif

            {{-- 相関図 --}}
            @if(Route::has('graphs.index'))
                <a href="{{ route('graphs.index') }}"
                class="block rounded-xl border bg-white p-4 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-900">相関図・関係性まとめ</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        メンバー同士の関係性やつながりを図で確認できます。
                    </p>
                </a>
            @endif
        </div>
    </section>

    <div class="mt-6 text-sm text-gray-700 leading-7">
        <p>
            {{ $member->name }}と同じ{{ $member->grade }}のメンバーを見たい方は
            @if(Route::has('members.generation'))
                <a href="{{ route('members.generation') }}" class="text-blue-600 hover:underline">期別メンバー一覧</a>
            @else
                期別メンバー一覧
            @endif
            をご覧ください。
            グループ全体の流れを知りたい方は
            @if(Route::has('timeline.index'))
                <a href="{{ route('timeline.index') }}" class="text-blue-600 hover:underline">日向坂46ヒストリー</a>
            @else
                日向坂46ヒストリー
            @endif
            、関係性を見たい方は
            @if(Route::has('graphs.index'))
                <a href="{{ route('graphs.index') }}" class="text-blue-600 hover:underline">相関図ページ</a>
            @else
                相関図ページ
            @endif
            も利用できます。
        </p>
    </div>
    @if(isset($relatedContents) && $relatedContents->isNotEmpty())
        <section class="mt-10 bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold font-mont">関連コンテンツ</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                @foreach($relatedContents as $content)
                    <a href="{{ $content['url'] }}"
                    class="block rounded-xl border bg-white p-4 hover:bg-gray-50 transition">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $content['title'] }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $content['description'] }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 下部導線 --}}
    <section class="mt-10 border-t pt-8 text-sm text-gray-700 leading-7">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ $member->name }}の関連一覧</h2>
        <p>
            {{ $member->name }}のプロフィール詳細ページです。
            <a href="{{ route('members.index') }}" class="text-blue-600 hover:underline">メンバー一覧</a>
            から他のメンバーも確認できます。
            @if($member->graduation == 0 && Route::has('members.current'))
                現在在籍しているメンバーをまとめて見たい方は
                <a href="{{ route('members.current') }}" class="text-blue-600 hover:underline">現役メンバー一覧</a>
                をご覧ください。
            @elseif($member->graduation == 1 && Route::has('members.graduates'))
                卒業メンバーをまとめて見たい方は
                <a href="{{ route('members.graduates') }}" class="text-blue-600 hover:underline">卒業メンバー一覧</a>
                をご覧ください。
            @endif
            @if(Route::has('members.generation'))
                また、
                <a href="{{ route('members.generation') }}" class="text-blue-600 hover:underline">期別メンバー一覧</a>
                では{{ $member->grade }}を含む各期のメンバーも確認できます。
            @endif
        </p>
    </section>
    @auth
    {{-- アクセス推移 --}}
    <section class="bg-white p-6 shadow-md mt-6 rounded-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-4">アクセス推移（直近31日）</h2>

        <div class="relative h-64">
            <canvas id="memberAccessChart"></canvas>
        </div>

        <p class="text-sm text-gray-500 mt-3">
            日別アクセス数を表示しています。
        </p>
    </section>
    @endauth
</main>

<button
    id="backToTop"
    class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-700 z-50"
    aria-label="トップに戻る"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
    </svg>
</button>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- スキル表 --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('radarChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['歌唱力', 'ダンス', 'バラエティ', '学力', 'スポーツ', 'ぶりっ子'],
                datasets: [{
                    label: '{{ $member->name }} のスキル',
                    data: [
                        {{ $radar->skill->singing }},
                        {{ $radar->skill->dancing }},
                        {{ $radar->skill->variety }},
                        {{ $radar->skill->intelligence }},
                        {{ $radar->skill->sport }},
                        {{ $radar->skill->burikko }}
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    });
</script>

{{-- アクセス推移 --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('memberAccessChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($accessChartLabels),
            datasets: [{
                label: 'アクセス数',
                data: @json($accessChartData),
                tension: 0.3,
                fill: false,
                borderWidth: 2,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' 回';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>

<script>
    const backToTop = document.getElementById('backToTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100');
        } else {
            backToTop.classList.remove('opacity-100');
            backToTop.classList.add('opacity-0', 'pointer-events-none');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

<script>
    function showAllSongs() {
        const listItems = document.querySelectorAll('#songList li');
        listItems.forEach(item => item.style.display = 'block');
    }

    function showCenterOnly() {
        const listItems = document.querySelectorAll('#songList li');
        listItems.forEach(item => {
            item.style.display = item.dataset.center === '1' ? 'block' : 'none';
        });
    }
</script>

<script>
(() => {
    const item = {
        type: 'member',
        id: {{ $member->id }},
        title: @json($member->name),
        url: @json(route('members.show', $member->id)),
        image: @json($member->image ? asset('storage/' . $member->image) : null),
        viewedAt: Date.now()
    };

    const KEY = 'recentlyViewed';
    const MAX = 12;

    const raw = localStorage.getItem(KEY);
    let list = raw ? JSON.parse(raw) : [];

    list = list.filter(x => !(x.type === item.type && x.id === item.id));
    list.unshift(item);

    if (list.length > MAX) list = list.slice(0, MAX);

    localStorage.setItem(KEY, JSON.stringify(list));
})();
</script>
@endsection