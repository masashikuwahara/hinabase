@extends('layouts.main')

@section('title', '櫻坂46メンバー一覧')
@section('meta_description', '櫻坂46のメンバー一覧。プロフィール、あだ名、生年月日、身長、血液型、参加楽曲などのリンクを整理。期別の在籍メンバーと卒業メンバーを確認できます。')

@push('head_meta')
  @if(request('sort') || request('order'))
    <meta name="robots" content="noindex,follow">
    <link rel="canonical" href="{{ route('members.index') }}">
  @else
    <link rel="canonical" href="{{ url()->current() }}">
  @endif

  @php
    $hasSort = request()->has('sort') || request()->has('order');
    $hasPage = (int)request('page') > 1;
  @endphp

  @if($hasSort)
    <meta name="robots" content="noindex,follow">
    <link rel="canonical" href="{{ route('members.index') }}">
  @else
    <link rel="canonical" href="{{ $hasPage ? request()->fullUrl() : url()->current() }}">
  @endif
  <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"CollectionPage",
        "name":"櫻坂46メンバー一覧 | 櫻坂46データベース | HINABASE",
        "url":"{{ request()->fullUrl() }}",
        "isPartOf":{"@type":"WebSite","name":"HINABASE","url":"{{ url('/') }}"},
        "mainEntity":{
            "@type":"ItemList",
            "itemListElement":[
            @php
                // 在籍メンバーを配列化 → 配列の配列なら flatten
                $currentData =
                $sort === 'default'
                    ? collect($currentMembers)->flatten(1)                       // 期ごと配列ケース
                    : (method_exists($currentMembers, 'items')                   // LengthAwarePaginatorなど
                        ? collect($currentMembers->items())
                        : collect($currentMembers));                              // すでにコレクション/配列

                // 卒業メンバーも含めたい場合はここで merge
                // $graduatedData = $sort === 'default'
                //    ? collect($graduatedMembers)->flatten(1)
                //    : (method_exists($graduatedMembers, 'items') ? collect($graduatedMembers->items()) : collect($graduatedMembers));
                // $list = $currentData->merge($graduatedData);

                $list = $currentData; // 今回は在籍のみ。両方入れるなら上のmergeを使用
                $pos = 1;
            @endphp
            @foreach($list as $m)
                {
                "@type":"ListItem",
                "position": {{ $pos++ }},
                "url": "{{ route('members.show', $m->id) }}",
                "name": "{{ $m->name }}"
                }@if(!$loop->last),@endif
            @endforeach
            ]
        }
    }
    </script>
    
    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"BreadcrumbList",
            "itemListElement":[
                {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
                {"@type":"ListItem","position":2,"name":"メンバー一覧","item":"{{ request()->fullUrl() }}"}
            ]
        }
  </script>
@endpush

@section('content')
    <nav class="text-sm text-gray-600 mt-2" aria-label="パンくず">
    <ol class="flex space-x-2">
        <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li aria-current="page">メンバー一覧</li>
    </ol>
    </nav>
    <main class="container mx-auto mt-8 px-4">
        {{-- 現在の状態を表示 --}}
        <h1 class="text-2xl font-semibold">櫻坂46メンバー一覧</h1>
        @php
        $labels = [
            'default'    => 'デフォルト',
            'furigana'   => '50音順',
            'blood' => '血液型順',
            'birth'   => '誕生日順',
            'height'     => '身長順',
        ];
        @endphp

        <p>現在のソート: {{ $labels[$sort] ?? 'デフォルト' }}</p>
    
        {{-- 切り替えボタン --}}
        <div x-data="{ open:false }" x-cloak class="relative md:static">
        
            {{-- PC表示時のボタン（モバイルでは非表示） --}}
            <div class="hidden md:flex justify-center space-x-4 mt-4">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    デフォルトに戻す
                </a>
                <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    50音順
                </a>
                <a href="{{ route('members.index', ['sort' => 'blood', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    血液型順
                </a>
                <a href="{{ route('members.index', ['sort' => 'birth', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    誕生日順
                </a>
                <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    身長順
                </a>
                <a href="{{ route('members.index', ['sort' => 'songs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    参加楽曲順
                </a>
                <a href="{{ route('members.index', ['sort' => 'titlesongs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    表題曲参加順
                </a>
                <a href="{{ route('members.index', ['sort' => 'center', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-[#f19db5] text-white shadow-md hover:bg-[#e488a6]">
                    センター回数順
                </a>
            </div>
        
            {{-- モバイル表示時のプルダウンメニュー（初期状態では非表示） --}}
            <div x-data="{ open:false }" class="md:hidden">
            <!-- アコーディオンのヘッダー -->
            <div x-data="{ open:false }" class="md:hidden">
            <button @click="open=!open" class="w-full flex items-center justify-between bg-[#f19db5] text-white px-4 py-3">
                <span class="text-sm font-medium">ソートメニュー</span>
                <svg class="h-5 w-5 transition-transform" :class="open ? 'rotate-180' : ''}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
            </button>

            <div
                x-ref="panel"
                x-bind:style="open ? 'max-height:' + $refs.panel.scrollHeight + 'px' : 'max-height:0px'"
                class="overflow-hidden transition-all duration-300 mt-2 shadow-lg bg-[#f19db5]"
            >
                <div class="py-1">
                <a href="{{ route('members.index') }}"
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">デフォルトに戻す</a>

                <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">50音順</a>

                <a href="{{ route('members.index', ['sort' => 'blood', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">血液型順</a>

                <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">誕生日順</a>

                <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}"
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">身長順</a>

                <a href="{{ route('members.index', ['sort' => 'songs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">参加楽曲順</a>

                <a href="{{ route('members.index', ['sort' => 'titlesongs', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">表題曲参加順</a>
                    
                <a href="{{ route('members.index', ['sort' => 'center', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="block px-4 py-2 text-sm text-white hover:bg-gray-100">センター回数順</a>
                </div>
            </div>
            </div>

        </div>
        <div class="text-center mt-6">
            <p class="text-sm">ボタンを繰り返し押すと昇順、降順を切り替えることができます</p>
        </div>
    
        @if ($sort === 'default')
            {{-- デフォルト: gradeごとに表示 --}}
            <!-- 在籍メンバー -->
            <section class="mt-6">
                <h2 class="text-xl font-bold text-gray-800">在籍メンバー</h2>
                @if (is_array($currentMembers) || is_object($currentMembers))
                    @if (empty((array)$currentMembers))
                        <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                    @else
                        @foreach ($currentMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-4">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/images/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（櫻坂46）"
                                                 class="w-32 h-32 object-cover mx-auto"
                                                 loading="lazy"
                                                 width="128" height="128"/>
                                            <span class="mt-2 font-semibold">{{ $member->name }}
                                                @if ($member->is_recently_updated)
                                                <span class="text-red-600 font-bold">NEW!</span>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
    
            <!-- 卒業メンバー -->
            <section class="mt-8">
                <h2 class="text-xl font-bold text-gray-800">卒業メンバー</h2>
                @if (is_array($graduatedMembers) || is_object($graduatedMembers))
                    @if (empty((array)$graduatedMembers))
                        <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                    @else
                        @foreach ($graduatedMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-4">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/images/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（櫻坂46）"
                                                 class="w-32 h-32 object-cover mx-auto"
                                                 loading="lazy"
                                                 width="128" height="128"/>
                                            <span class="mt-2 font-semibold">{{ $member->name }}</span>
                                            @if ($member->is_recently_updated)
                                            <span class="text-red-600 font-bold">NEW!</span>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
        @else
            {{-- gradeを無視してソート --}}
            <section class="mt-6">
                <h2 class="text-xl font-bold text-gray-800">在籍メンバー</h2>
                @if ($currentMembers->isEmpty())
                    <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($currentMembers as $member)
                            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/images/' . ($member->image ?? 'default.jpg')) }}"
                                         alt="{{ $member->name }}（櫻坂46）"
                                         class="w-32 h-32 object-cover mx-auto"
                                         loading="lazy"
                                         width="128" height="128"/>
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                    <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                    <span class="mt-2 font-semibold">
                                        @if ($member->is_recently_updated)
                                        <span class="text-red-600 font-bold">NEW!</span>
                                        @endif
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            
            <section class="mt-8">
                <h2 class="text-xl font-bold text-gray-800">卒業メンバー</h2>
                @if ($graduatedMembers->isEmpty())
                    <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($graduatedMembers as $member)
                            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/images/' . ($member->image ?? 'default.jpg')) }}"
                                        alt="{{ $member->name }}（櫻坂46）"
                                        class="w-32 h-32 object-cover mx-auto"
                                        loading="lazy"
                                        width="128" height="128"/>
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                    <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </main>

    {{-- トップに戻るボタン --}}
    <button id="back-to-top" title="トップへ戻る">TOP</button>
    <script>
    const button = document.getElementById("back-to-top");
    window.addEventListener("scroll", function () {
        if (window.pageYOffset > 300) {
            button.classList.add("show");
        } else {
            button.classList.remove("show");
        }
    });
    
    button.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>
@endsection

