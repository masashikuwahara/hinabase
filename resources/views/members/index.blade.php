@extends('layouts.main')

@section('title', '日向坂46メンバー一覧｜現役・卒業・期別メンバー | HINABASE')
@section('meta_description', '日向坂46のメンバー一覧ページです。現役・卒業・期別の一覧や、誕生日順・身長順・年齢順などの切り口からメンバー情報を探せます。プロフィール詳細ページへのリンクも掲載。')

@push('head_meta')
    @php
        $hasSort = request()->has('sort') || request()->has('order');
        $hasPage = (int) request('page') > 1;

        $canonicalUrl = $hasSort
            ? route('members.index')
            : ($hasPage ? request()->fullUrl() : route('members.index'));

        $labels = [
            'default'    => 'デフォルト',
            'furigana'   => '50音順',
            'blood_type' => '血液型順',
            'birthday'   => '誕生日順',
            'height'     => '身長順',
        ];

        $currentVisibleMembers =
            $sort === 'default'
                ? collect($currentMembers)->flatten(1)
                : (method_exists($currentMembers, 'items')
                    ? collect($currentMembers->items())
                    : collect($currentMembers));

        $graduatedVisibleMembers =
            $sort === 'default'
                ? collect($graduatedMembers)->flatten(1)
                : (method_exists($graduatedMembers, 'items')
                    ? collect($graduatedMembers->items())
                    : collect($graduatedMembers));

        $visibleMembers = $currentVisibleMembers->merge($graduatedVisibleMembers)->values();
    @endphp

    @if($hasSort)
        <meta name="robots" content="noindex,follow">
    @endif

    <link rel="canonical" href="{{ $canonicalUrl }}">

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"CollectionPage",
        "name":"日向坂46メンバー一覧",
        "url":"{{ route('members.index') }}",
        "isPartOf":{
            "@type":"WebSite",
            "name":"HINABASE",
            "url":"{{ url('/') }}"
        },
        "description":"日向坂46の現役・卒業・期別の一覧や、誕生日順・身長順などの切り口からメンバー情報を探せる総合ページです。"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"BreadcrumbList",
        "itemListElement":[
            {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
            {"@type":"ListItem","position":2,"name":"メンバー一覧","item":"{{ route('members.index') }}"}
        ]
    }
    </script>

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"ItemList",
        "name":"日向坂46メンバー一覧",
        "itemListOrder":"https://schema.org/ItemListUnordered",
        "numberOfItems": {{ $visibleMembers->count() }},
        "itemListElement":[
            @foreach($visibleMembers as $i => $m)
            {
                "@type":"ListItem",
                "position": {{ $i + 1 }},
                "url": "{{ route('members.show', $m->id) }}",
                "name": @json($m->name)
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
@endpush

@section('content')
    <nav class="text-sm text-gray-600 mt-4 px-4 max-w-6xl mx-auto" aria-label="パンくず">
        <ol class="flex flex-wrap items-center gap-2">
            <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
            <li>›</li>
            <li>メンバー一覧</li>
        </ol>
    </nav>

    <main class="container mx-auto mt-8 px-4 max-w-6xl">
        <header>
            <h1 class="text-2xl md:text-3xl font-semibold font-mont text-gray-900">日向坂46メンバー一覧</h1>
            <p class="text-sm md:text-base text-gray-600 mt-2 leading-7">
                日向坂46のメンバーを一覧でまとめたHINABASEの総合ページです。
                現役・卒業・期別の一覧や、誕生日順・身長順などの切り口からメンバー情報を探せます。
                各メンバーのプロフィール詳細ページへも移動できます。
            </p>
        </header>

        {{-- 一覧ハブ導線 --}}
        <section class="mt-8">
            <h2 class="text-xl font-semibold font-mont text-gray-800">一覧から探す</h2>
            <p class="text-sm text-gray-600 mt-1">
                探したい条件に合わせて、専用の一覧ページや関連ページへ移動できます。
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @if(Route::has('members.current'))
                    <a href="{{ route('members.current') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">現役メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">現在在籍しているメンバーを一覧で確認できます。</p>
                    </a>
                @else
                    <div class="rounded-xl border bg-gray-50 p-4">
                        <h3 class="font-semibold text-gray-900">現役メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">現在在籍しているメンバーの専用一覧ページを準備中です。</p>
                    </div>
                @endif

                @if(Route::has('members.graduates'))
                    <a href="{{ route('members.graduates') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">卒業メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">卒業メンバーをまとめて確認できます。</p>
                    </a>
                @else
                    <div class="rounded-xl border bg-gray-50 p-4">
                        <h3 class="font-semibold text-gray-900">卒業メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">卒業メンバー専用の一覧ページを準備中です。</p>
                    </div>
                @endif

                @if(Route::has('members.generation'))
                    <a href="{{ route('members.generation') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">期別メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">一期生から現在の各期まで、期ごとに一覧で探せます。</p>
                    </a>
                @else
                    <div class="rounded-xl border bg-gray-50 p-4">
                        <h3 class="font-semibold text-gray-900">期別メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">期別に探せる専用一覧ページを準備中です。</p>
                    </div>
                @endif

                @if(Route::has('members.stats'))
                    <a href="{{ route('members.stats') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">メンバー統計・ランキング</h3>
                        <p class="text-sm text-gray-600 mt-1">参加楽曲数、センター回数、身長順、誕生日順などの統計ページです。</p>
                    </a>
                @else
                    <div class="rounded-xl border bg-gray-50 p-4">
                        <h3 class="font-semibold text-gray-900">期別メンバー一覧</h3>
                        <p class="text-sm text-gray-600 mt-1">参加楽曲数、センター回数、身長順、誕生日順などの統計ページを準備中です。</p>
                    </div>
                @endif

                {{-- @if(Route::has('members.birthdays'))
                    <a href="{{ route('members.birthdays') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">誕生日順</h3>
                        <p class="text-sm text-gray-600 mt-1">誕生日の月日順でメンバーを確認できます。</p>
                    </a>
                @else
                    <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => 'asc']) }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">誕生日順</h3>
                        <p class="text-sm text-gray-600 mt-1">現状はこのページ内の並び替えで誕生日順を確認できます。</p>
                    </a>
                @endif

                @if(Route::has('members.heights'))
                    <a href="{{ route('members.heights') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">身長順</h3>
                        <p class="text-sm text-gray-600 mt-1">身長順でメンバーを比較できます。</p>
                    </a>
                @else
                    <a href="{{ route('members.index', ['sort' => 'height', 'order' => 'asc']) }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900">身長順</h3>
                        <p class="text-sm text-gray-600 mt-1">現状はこのページ内の並び替えで身長順を確認できます。</p>
                    </a>
                @endif --}}
            </div>
        </section>

        {{-- 補助導線 --}}
        <section class="mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(Route::has('members.ages'))
                    <a href="{{ route('members.ages') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h2 class="text-lg font-semibold text-gray-900">年齢順メンバー一覧</h2>
                        <p class="text-sm text-gray-600 mt-1">年齢や生年月日ベースでメンバーを見たい方向けの一覧です。</p>
                    </a>
                @endif
            </div>
        </section>

        {{-- 現在のソート状態 --}}
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-700">現在の表示: {{ $labels[$sort] ?? 'デフォルト' }}</p>
            <p class="text-xs text-gray-500 mt-1">
                このページ内でも、50音順・血液型順・誕生日順・身長順で表示を切り替えられます。
            </p>
        </div>

        {{-- 並び替えボタン --}}
        <div x-data="{ open:false }" x-cloak class="relative md:static mt-4">
            <div class="md:hidden text-center">
                <button @click="open = !open"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
                    並び替え
                </button>
            </div>

            <div class="hidden md:flex flex-wrap justify-center gap-3 mt-4">
                <a href="{{ route('members.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
                    デフォルトに戻す
                </a>
                <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600">
                    50音順
                </a>
                <a href="{{ route('members.index', ['sort' => 'blood_type', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                   class="px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600">
                    血液型順
                </a>
                <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600">
                    誕生日順
                </a>
                <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600">
                    身長順
                </a>
                {{-- <a href="{{ route('members.stats') }}"
                   class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow-md hover:bg-pink-600">
                    メンバー統計・ランキングはこちら
                </a> --}}
            </div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-y-95"
                 x-transition:enter-end="opacity-100 transform scale-y-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-y-100"
                 x-transition:leave-end="opacity-0 transform scale-y-95"
                 class="absolute left-0 mt-2 w-full rounded-md shadow-lg bg-blue-100 z-10 md:hidden">
                <div class="py-1">
                    <a href="{{ route('members.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        デフォルトに戻す
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        50音順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'blood_type', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        血液型順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        誕生日順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        身長順
                    </a>
                    {{-- <a href="{{ route('members.stats') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        メンバー統計・ランキングはこちら
                    </a> --}}
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-500">並び替えボタンを繰り返し押すと、昇順・降順を切り替えられます。</p>
        </div>

        @if ($sort === 'default')
            <section class="mt-8">
                <h2 class="text-xl font-semibold font-mont text-gray-800">在籍メンバー</h2>
                <p class="text-sm text-gray-600 mt-1">
                    現在在籍している日向坂46メンバーを期別に掲載しています。
                </p>

                @if (is_array($currentMembers) || is_object($currentMembers))
                    @if (empty((array)$currentMembers))
                        <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                    @else
                        @foreach ($currentMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-6">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-3">
                                @foreach ($members as $member)
                                    <article class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform p-4">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（日向坂46）"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full"
                                                 loading="lazy"
                                                 width="128"
                                                 height="128">
                                            <div class="mt-3">
                                                <span class="font-semibold">{{ $member->name }}</span>
                                                @if ($member->is_recently_updated)
                                                    <span class="text-red-600 font-bold ml-1">NEW!</span>
                                                @endif
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>

            <section class="mt-10">
                <h2 class="text-xl font-semibold font-mont text-gray-800">卒業メンバー</h2>
                <p class="text-sm text-gray-600 mt-1">
                    卒業メンバーも期別にまとめて掲載しています。
                </p>

                @if (is_array($graduatedMembers) || is_object($graduatedMembers))
                    @if (empty((array)$graduatedMembers))
                        <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                    @else
                        @foreach ($graduatedMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-6">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-3">
                                @foreach ($members as $member)
                                    <article class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform p-4">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（日向坂46）"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full"
                                                 loading="lazy"
                                                 width="128"
                                                 height="128">
                                            <div class="mt-3">
                                                <span class="font-semibold">{{ $member->name }}</span>
                                                @if ($member->is_recently_updated)
                                                    <span class="text-red-600 font-bold ml-1">NEW!</span>
                                                @endif
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
        @else
            <section class="mt-8">
                <h2 class="text-xl font-semibold font-mont text-gray-800">在籍メンバー</h2>
                @if ($currentMembers->isEmpty())
                    <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-3">
                        @foreach ($currentMembers as $member)
                            <article class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform p-4">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                         alt="{{ $member->name }}（日向坂46）"
                                         class="w-32 h-32 object-cover mx-auto rounded-full"
                                         loading="lazy"
                                         width="128"
                                         height="128">
                                    <p class="mt-3 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                        <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                    @if ($member->is_recently_updated)
                                        <span class="text-red-600 font-bold">NEW!</span>
                                    @endif
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="mt-10">
                <h2 class="text-xl font-semibold font-mont text-gray-800">卒業メンバー</h2>
                @if ($graduatedMembers->isEmpty())
                    <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-3">
                        @foreach ($graduatedMembers as $member)
                            <article class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform p-4">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                         alt="{{ $member->name }}（日向坂46）"
                                         class="w-32 h-32 object-cover mx-auto rounded-full"
                                         loading="lazy"
                                         width="128"
                                         height="128">
                                    <p class="mt-3 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                        <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                    @if ($member->is_recently_updated)
                                        <span class="text-red-600 font-bold">NEW!</span>
                                    @endif
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        <section class="mt-12 text-sm text-gray-700 leading-7 border-t pt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">日向坂46メンバー一覧の見方</h2>
            <p>
                このページでは、日向坂46の在籍メンバー・卒業メンバーを一覧で掲載しています。
                @if(Route::has('members.current'))
                    <a href="{{ route('members.current') }}" class="text-blue-600 hover:underline">現役メンバー一覧</a>、
                @endif
                @if(Route::has('members.graduates'))
                    <a href="{{ route('members.graduates') }}" class="text-blue-600 hover:underline">卒業メンバー一覧</a>、
                @endif
                @if(Route::has('members.generation'))
                    <a href="{{ route('members.generation') }}" class="text-blue-600 hover:underline">期別メンバー一覧</a>、
                @endif
                @if(Route::has('members.birthdays'))
                    <a href="{{ route('members.birthdays') }}" class="text-blue-600 hover:underline">誕生日順</a>、
                @else
                    <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => 'asc']) }}" class="text-blue-600 hover:underline">誕生日順</a>、
                @endif
                @if(Route::has('members.heights'))
                    <a href="{{ route('members.heights') }}" class="text-blue-600 hover:underline">身長順</a>
                @else
                    <a href="{{ route('members.index', ['sort' => 'height', 'order' => 'asc']) }}" class="text-blue-600 hover:underline">身長順</a>
                @endif
                など、目的に合わせた切り口からメンバー情報を探せるようにしています。
                各メンバーのプロフィール詳細ページでは、誕生日・身長・血液型・出身地・参加楽曲数なども確認できます。
            </p>
        </section>
    </main>

    <button
        id="backToTop"
        class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-700 z-50"
        aria-label="トップに戻る"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

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
@endsection