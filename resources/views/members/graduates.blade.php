@extends('layouts.main')

@section('title', '日向坂46 卒業メンバー一覧 | HINABASE')
@section('meta_description', '日向坂46の卒業メンバー一覧ページです。卒業メンバーを期別に掲載し、各プロフィール詳細ページへ移動できます。')

@push('head_meta')
    <link rel="canonical" href="{{ route('members.graduates') }}">

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"CollectionPage",
        "name":"日向坂46 卒業メンバー一覧",
        "url":"{{ route('members.graduates') }}",
        "isPartOf":{
            "@type":"WebSite",
            "name":"HINABASE",
            "url":"{{ url('/') }}"
        },
        "description":"日向坂46の卒業メンバーを期別に掲載した一覧ページです。"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"BreadcrumbList",
        "itemListElement":[
            {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
            {"@type":"ListItem","position":2,"name":"メンバー一覧","item":"{{ route('members.index') }}"},
            {"@type":"ListItem","position":3,"name":"卒業メンバー一覧","item":"{{ route('members.graduates') }}"}
        ]
    }
    </script>

    @php
        $visibleMembers = collect();

        foreach ($gradeOrder as $grade) {
            $visibleMembers = $visibleMembers->merge($membersByGrade[$grade] ?? collect());
        }
    @endphp

    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"ItemList",
        "name":"日向坂46 卒業メンバー一覧",
        "itemListOrder":"https://schema.org/ItemListUnordered",
        "numberOfItems": {{ $visibleMembers->count() }},
        "itemListElement":[
            @foreach($visibleMembers as $i => $member)
            {
                "@type":"ListItem",
                "position": {{ $i + 1 }},
                "url": "{{ route('members.show', $member->id) }}",
                "name": @json($member->name)
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
@endpush

@section('content')
    <nav class="text-sm text-gray-600 mt-2 px-4 max-w-6xl mx-auto" aria-label="パンくず">
        <ol class="flex flex-wrap items-center gap-2">
            <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
            <li>›</li>
            <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
            <li>›</li>
            <li aria-current="page">卒業メンバー一覧</li>
        </ol>
    </nav>

    <main class="container mx-auto mt-8 px-4 max-w-6xl">
        <header>
            <h1 class="text-2xl md:text-3xl font-semibold font-mont text-gray-900">日向坂46 卒業メンバー一覧</h1>
            <p class="text-sm md:text-base text-gray-600 mt-2 leading-7">
                日向坂46の卒業メンバーを期別にまとめた一覧ページです。
                各メンバーのプロフィール詳細ページでは、誕生日・身長・血液型・出身地・参加楽曲数なども確認できます。
            </p>
        </header>

        {{-- 上部導線 --}}
        <section class="mt-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('members.index') }}"
                   class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-900">メンバー一覧トップ</h2>
                    <p class="text-sm text-gray-600 mt-1">在籍・卒業・期別など、メンバー一覧の総合ページへ戻ります。</p>
                </a>

                @if(Route::has('members.current'))
                    <a href="{{ route('members.current') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h2 class="text-lg font-semibold text-gray-900">現役メンバー一覧</h2>
                        <p class="text-sm text-gray-600 mt-1">現在在籍しているメンバーを一覧で確認できます。</p>
                    </a>
                @endif

                @if(Route::has('members.generation'))
                    <a href="{{ route('members.generation') }}"
                       class="block rounded-xl border bg-white p-4 shadow-sm hover:shadow-md transition">
                        <h2 class="text-lg font-semibold text-gray-900">期別メンバー一覧</h2>
                        <p class="text-sm text-gray-600 mt-1">在籍・卒業を含めて、期ごとに一覧で確認できます。</p>
                    </a>
                @endif
            </div>
        </section>

        {{-- 一覧本体 --}}
        <section class="mt-10">
            <h2 class="text-xl font-semibold font-mont text-gray-800">卒業メンバーを期別に掲載</h2>
            <p class="text-sm text-gray-600 mt-1">
                一期生から各期ごとに、卒業メンバーを一覧でまとめています。
            </p>

            @php
                $hasAnyMembers = false;
                foreach ($gradeOrder as $grade) {
                    if (($membersByGrade[$grade] ?? collect())->isNotEmpty()) {
                        $hasAnyMembers = true;
                        break;
                    }
                }
            @endphp

            @if (!$hasAnyMembers)
                <p class="mt-4 text-gray-700">卒業メンバーはいません。</p>
            @else
                @foreach ($gradeOrder as $grade)
                    @php
                        $members = $membersByGrade[$grade] ?? collect();
                    @endphp

                    @if ($members->isNotEmpty())
                        <section class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $grade }}</h3>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-3">
                                @foreach ($members as $member)
                                    <article class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform p-4">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img
                                                src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                alt="{{ $member->name }}（日向坂46）"
                                                class="w-32 h-32 object-cover mx-auto rounded-full"
                                                loading="lazy"
                                                width="128"
                                                height="128"
                                            >
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
                        </section>
                    @endif
                @endforeach
            @endif
        </section>

        {{-- 下部テキスト --}}
        <section class="mt-12 text-sm text-gray-700 leading-7 border-t pt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">日向坂46の卒業メンバーを一覧で確認</h2>
            <p>
                このページでは、日向坂46の卒業メンバーを期別に掲載しています。
                メンバー全体を見たい方は
                <a href="{{ route('members.index') }}" class="text-blue-600 hover:underline">メンバー一覧</a>
                をご覧ください。
                @if(Route::has('members.current'))
                    現役メンバーを確認したい方は
                    <a href="{{ route('members.current') }}" class="text-blue-600 hover:underline">現役メンバー一覧</a>
                    も利用できます。
                @endif
                @if(Route::has('members.generation'))
                    また、
                    <a href="{{ route('members.generation') }}" class="text-blue-600 hover:underline">期別メンバー一覧</a>
                    では在籍・卒業を含めた期ごとの一覧も確認できます。
                @endif
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