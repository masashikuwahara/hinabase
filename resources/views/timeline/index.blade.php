@extends('layouts.main')

@section('title', '日向坂46 ヒストリー（年表） | HINABASE')
@section('meta_description', '日向坂46（ひらがなけやき時代含む）の活動年表。2017年から現在までの出来事を年ごとに振り返ります。デビュー、シングル発売、ライブ、番組出演などを時系列で紹介。')

@push('head_meta')
<link rel="canonical" href="{{ url()->current() }}">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "ItemList",
 "name": "日向坂46 ヒストリー（年表）",
 "description": "日向坂46（ひらがなけやき時代含む）の活動年表。2017年から現在までの出来事を時系列で紹介。",
 "itemListElement": [
   @foreach($timeline as $year => $events)
     @foreach($events as $i => $event)
       {
         "@type": "ListItem",
         "position": {{ ($loop->parent->index * 10) + $loop->index + 1 }},
         {{-- "name": "{{ $year }}年 {{ $event['title'] }}" --}}
       }@if(!($loop->parent->last && $loop->last)),@endif
     @endforeach
   @endforeach
 ]
}
</script>
@endpush

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-8 text-center">日向坂46 ヒストリー</h1>

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
  @foreach($timeline as $year => $events)
  <section id="year-{{ $year }}" class="mb-12 scroll-mt-20">
    <h2 class="text-2xl font-semibold text-[#7cc7e8] border-l-4 border-[#7cc7e8] pl-3 mb-6">
      {{ $year }}年
    </h2>
    <ul class="relative border-l border-gray-300 pl-6 space-y-6">
      @foreach($events as $event)
        <li data-aos="fade-up" class="{{ $year == 2025 ? 'bg-[#ffcf77] p-3 rounded-lg shadow-sm' : '' }}">
          {{-- <div class="absolute -left-2.5 top-1.5 w-3 h-3 bg-blue-600 rounded-full"></div> --}}
          <time class="block text-sm text-gray-500">{{ $event['date'] }}</time>
          {{-- <div class="font-medium text-lg">{{ $event['title'] }}</div> --}}
          <p class="text-gray-700 text-sm leading-relaxed">{{ $event['description'] }}</p>
        </li>
      @endforeach
    </ul>
  </section>
  @endforeach
  <div class="text-xl mb-8 text-center">
    The HINATAZAKA46 story continues even further.<br>
    No one yet knows what awaits us beyond this point...
  </div>
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
