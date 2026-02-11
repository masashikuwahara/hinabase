@extends('layouts.main')

@section('title', '日向坂46メンバー一覧')
@section('meta_description', '日向坂46のメンバー一覧。プロフィール、あだ名、生年月日、身長、血液型、参加楽曲などのリンクを整理。期別の在籍メンバーと卒業メンバーを確認できます。')

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
        "name":"日向坂46メンバー一覧 | 日向坂46データベース | HINABASE",
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
        <h1 class="text-2xl font-semibold font-mont">日向坂46メンバー一覧</h1>
        @php
        $labels = [
            'default'    => 'デフォルト',
            'furigana'   => '50音順',
            'blood_type' => '血液型順',
            'birthday'   => '誕生日順',
            'height'     => '身長順',
        ];
        @endphp

        <p>現在のソート: {{ $labels[$sort] ?? 'デフォルト' }}</p>
    
        {{-- 切り替えボタン --}}
        <div x-data="{ open:false }" x-cloak class="relative md:static">
            {{-- モバイル表示時のプルダウンボタン --}}
            <button @click="open = !open" class="md:hidden px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
                並び替え
            </button>
        
            {{-- PC表示時のボタン（モバイルでは非表示） --}}
            <div class="hidden md:flex justify-center space-x-4 mt-4">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
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
                {{-- <a href="{{ route('members.index', ['sort' => 'birthplace', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow-md hover:bg-pink-600">
                    出身地順
                </a> --}}
            </div>
        
            {{-- モバイル表示時のプルダウンメニュー（初期状態では非表示） --}}
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
                    {{-- <a href="{{ route('members.index', ['sort' => 'birthplace', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        出身地順
                    </a> --}}
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
                <h2 class="text-xl font-semibold font-mont text-gray-800">在籍メンバー</h2>
                @if (is_array($currentMembers) || is_object($currentMembers))
                    @if (empty((array)$currentMembers))
                        <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                    @else
                        @foreach ($currentMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-4">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（日向坂46）"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full"
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
    
            {{-- <div class="text-center text-blue-700 mt-8">
                <a href="https://hinatazaka5th.netlify.app/" target="_blank" rel="noopener noreferrer" class="hover:underline">五期生推しメンチェッカー</a>
            </div> --}}
            <!-- 卒業メンバー -->
            <section class="mt-8">
                <h2 class="text-xl font-semibold font-mont text-gray-800">卒業メンバー</h2>
                @if (is_array($graduatedMembers) || is_object($graduatedMembers))
                    @if (empty((array)$graduatedMembers))
                        <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                    @else
                        @foreach ($graduatedMembers as $grade => $members)
                            <h3 class="text-lg font-semibold mt-4">{{ $grade }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}（日向坂46）"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full"
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
                <h2 class="text-xl font-semibold font-mont text-gray-800">在籍メンバー</h2>
                @if ($currentMembers->isEmpty())
                    <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($currentMembers as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                         alt="{{ $member->name }}（日向坂46）"
                                         class="w-32 h-32 object-cover mx-auto rounded-full"
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
                <h2 class="text-xl font-semibold font-mont text-gray-800">卒業メンバー</h2>
                @if ($graduatedMembers->isEmpty())
                    <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($graduatedMembers as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                        alt="{{ $member->name }}（日向坂46）"
                                        class="w-32 h-32 object-cover mx-auto rounded-full"
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
    <button
        id="backToTop"
        class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-700 z-50"
        aria-label="トップに戻る"
    >
        {{-- 上向き矢印（Heroicons） --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

