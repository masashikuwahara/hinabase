@extends('layouts.main')

@section('title', '日向坂46 ヒストリー（年表） | HINABASE')
@section('meta_description', '日向坂46（ひらがなけやき時代含む）の活動年表。2015年の発足から現在までの出来事を年ごとに振り返ります。デビュー、シングル発売、ライブ、番組出演などを時系列で紹介。')

@push('head_meta')
<meta property="og:type" content="article">
<meta property="og:title" content="日向坂46 ヒストリー（年表） | HINABASE">
<meta property="og:description" content="日向坂46（ひらがなけやき時代含む）の活動年表。2015年の発足から現在までの出来事を年ごとに振り返ります。デビュー、シングル発売、ライブ、番組出演などを時系列で紹介。">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="HINABASE">
<meta property="og:locale" content="ja_JP">
<meta property="og:image" content="{{ asset('storage/images/logo.png') }}">
<meta property="og:image:alt" content="日向坂46 ヒストリー（年表） | HINABASE">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="日向坂46 ヒストリー（年表） | HINABASE">
<meta name="twitter:description" content="日向坂46（ひらがなけやき時代含む）の活動年表。2015年の発足から現在までの出来事を年ごとに振り返ります。デビュー、シングル発売、ライブ、番組出演などを時系列で紹介。">
<meta name="twitter:image" content="{{ asset('storage/images/logo.png') }}">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

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
      "name":"日向坂46 ヒストリー",
      "item":"{{ url()->current() }}"
    }
  ]
}
</script>
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-4 px-4 max-w-6xl mx-auto" aria-label="パンくず">
    <ol class="flex flex-wrap items-center gap-2">
        <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li>日向坂46 ヒストリー</li>
    </ol>
</nav>

<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-3xl font-bold font-mont mb-8 text-center">日向坂46 ヒストリー</h1>
  <p class="text-sm text-gray-600 text-center mb-8">
    日向坂46の発足から現在までの出来事を、メンバーの加入・卒業やシングル発売とあわせて年表形式でまとめています。
  </p>

  <section class="mb-8 rounded-2xl bg-white shadow p-5">
    <h2 class="text-xl font-bold mb-3">歴史からメンバー情報を探す</h2>
    <p class="text-sm text-gray-700 mb-4">
        日向坂46の歴史を見ながら、現役メンバー・卒業メンバー・期別メンバー一覧へ移動できます。
    </p>

    <div class="grid gap-3 md:grid-cols-3">
        <a href="{{ route('members.index') }}"
          class="block rounded-xl border p-4 hover:bg-gray-50">
            <div class="font-semibold">メンバー一覧</div>
            <div class="text-sm text-gray-600 mt-1">
                現役・卒業・期別をまとめて確認できます
            </div>
        </a>

        <a href="{{ route('members.graduates') }}"
          class="block rounded-xl border p-4 hover:bg-gray-50">
            <div class="font-semibold">卒業メンバー一覧</div>
            <div class="text-sm text-gray-600 mt-1">
                卒業メンバーを一覧で確認できます
            </div>
        </a>

        <a href="{{ route('members.generation') }}"
          class="block rounded-xl border p-4 hover:bg-gray-50">
            <div class="font-semibold">期別メンバー一覧</div>
            <div class="text-sm text-gray-600 mt-1">
                一期生〜五期生まで期ごとに探せます
            </div>
        </a>
    </div>
  </section>

  <!-- 年ナビ（タブ風） -->
  <div class="flex flex-wrap justify-center gap-2 mb-8">
    @foreach(array_keys($timeline) as $year)
      <button
        onclick="document.getElementById('year-{{ $year }}').scrollIntoView({behavior:'smooth'});"
        class="px-3 py-1 border border-blue-500 text-blue-600 hover:bg-blue-500 hover:text-white rounded transition"
      >
        {{ $year }}
      </button>
    @endforeach
  </div>

  <!-- タイムライン本体 -->
  {{-- @foreach($timeline as $year => $events)
  <section id="year-{{ $year }}" class="mb-12 scroll-mt-20">
    <h2 class="text-2xl font-semibold font-mont text-[#7cc7e8] border-l-4 border-[#7cc7e8] pl-3 mb-6">
      {{ $year }}年
    </h2>
    <ul class="relative border-l border-gray-300 pl-6 space-y-6">
      @foreach($events as $event)
        <li data-aos="fade-up" class="{{ $year == 2026 ? 'bg-[#ffcf77] p-3 rounded-lg shadow-sm' : '' }}">
          <time class="block text-sm text-gray-500">{{ $event['date'] }}</time>
          <p class="text-gray-700 text-sm leading-relaxed">{{ $event['description'] }}</p>
        </li>
      @endforeach
    </ul>
  </section>
  @endforeach --}}
  
  @foreach ($timeline as $year => $events)
      <section id="year-{{ $year }}" class="mb-12 scroll-mt-20">
        <h2 class="text-2xl font-semibold font-mont text-[#7cc7e8] border-l-4 border-[#7cc7e8] pl-3 mb-6">
          {{ $year }}年
        </h2>
          <div class="space-y-6">
              @foreach ($events as $event)
                  <article
                    class="rounded-xl shadow p-5 {{ $year == 2026 ? 'bg-amber-50 border border-amber-200' : 'bg-white' }} relative border-l border-gray-300 pl-6 space-y-6"
                    data-aos="fade-up"
                    data-aos-duration="700"
                  >
                      <div class="text-sm text-gray-500">{{ $year }}年{{ $event['date'] }}</div>
                      <p class="mt-2 text-gray-800 leading-7">{{ $event['description'] }}</p>

                      @if (!empty($event['related_links']))
                          <div class="mt-4">
                              <div class="text-sm font-semibold text-gray-700 mb-2">
                                  関連ページ
                              </div>

                              <div class="flex flex-wrap gap-2">
                                  @foreach ($event['related_links'] as $link)
                                      <a href="{{ url($link['url']) }}"
                                        class="inline-flex items-center rounded-full border px-3 py-1 text-sm text-sky-700 border-sky-200 hover:bg-sky-50">
                                          {{ $link['label'] }}
                                      </a>
                                  @endforeach
                              </div>
                          </div>
                      @endif
                  </article>
              @endforeach
          </div>
      </section>
  @endforeach
  <div class="text-xl mb-8 text-center">
    The HINATAZAKA46 story continues even further.<br>
    No one yet knows what awaits us beyond this point...
  </div>

  <section class="mt-12 rounded-2xl bg-white shadow p-5">
    <h2 class="text-xl font-bold mb-3">あわせて見たいページ</h2>
    <div class="grid gap-3 md:grid-cols-3">
      <a href="{{ route('members.index') }}" class="block rounded-xl border p-4 hover:bg-gray-50">メンバー一覧</a>
      <a href="{{ route('members.graduates') }}" class="block rounded-xl border p-4 hover:bg-gray-50">卒業メンバー一覧</a>
      <a href="{{ route('members.generation') }}" class="block rounded-xl border p-4 hover:bg-gray-50">期別メンバー一覧</a>
    </div>
  </section>
</div>

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
        if (window.scrollY > 100) {
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
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
      duration: 800,
      once: true,
      offset: 100
    });
  });
</script>
@endsection
