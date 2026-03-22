@extends('layouts.main')

@section('title', '日向坂46 データ・ランキングまとめ | HINABASE')
@section('meta_description', '日向坂46の各種データページをまとめてチェック。メンバー統計、人気ページランキング、日向坂ちゃんねる人気動画ランキングなどを一覧で掲載。')

@push('head_meta')
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- パンくず --}}
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"BreadcrumbList",
      "itemListElement":[
        {
          "@type":"ListItem",
          "position":1,
          "name":"ホーム",
          "item":"{{ url('/') }}"
        },
        {
          "@type":"ListItem",
          "position":2,
          "name":"データ・ランキングまとめ",
          "item":"{{ url()->current() }}"
        }
      ]
    }
    </script>

    {{-- 一覧ページ --}}
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"CollectionPage",
      "name":"日向坂46 データ・ランキングまとめ",
      "description":"日向坂46の各種データページをまとめた一覧ページ",
      "url":"{{ url()->current() }}"
    }
    </script>
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-4 px-4 max-w-6xl mx-auto" aria-label="パンくず">
    <ol class="flex flex-wrap items-center gap-2">
        <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li>日向坂46 データ・ランキングまとめ</li>
    </ol>
</nav>
<main class="container mx-auto mt-8 px-4 max-w-6xl">
    <section class="rounded-2xl bg-gradient-to-r from-cyan-50 to-sky-50 border border-sky-100 p-6 md:p-8 shadow-sm">
        <h1 class="text-2xl md:text-3xl font-bold font-mont text-sky-950">
            日向坂46 データ・ランキングまとめ
        </h1>
        <p class="mt-3 text-sm md:text-base leading-7 text-gray-700">
            HINABASE内のデータ系コンテンツをまとめたページです。
            メンバー統計、人気ページ、日向坂ちゃんねる動画ランキングなどを一覧でチェックできます。
        </p>
    </section>

    <section class="mt-8">
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($links as $link)
                <a href="{{ url($link['url']) }}"
                   class="group block rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="text-lg font-semibold text-gray-900 group-hover:text-sky-700">
                            {{ $link['title'] }}
                        </h2>

                        <span class="shrink-0 text-gray-400 group-hover:text-sky-600" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>

                    @isset($link['desc'])
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            {{ $link['desc'] }}
                        </p>
                    @endisset
                </a>
            @endforeach
        </div>
    </section>
</main>

<button id="backToTop"
    class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-500 z-50"
    aria-label="トップに戻る">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
    </svg>
</button>
@endsection

@push('scripts')
<script>
    const backToTop = document.getElementById('backToTop');

    const toggleBtn = () => {
        if (window.scrollY > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100');
        } else {
            backToTop.classList.remove('opacity-100');
            backToTop.classList.add('opacity-0', 'pointer-events-none');
        }
    };

    window.addEventListener('scroll', toggleBtn, { passive: true });
    document.addEventListener('DOMContentLoaded', toggleBtn);

    backToTop?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
@endpush