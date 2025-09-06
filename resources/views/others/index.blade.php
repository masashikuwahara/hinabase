@extends('layouts.main')

@section('title', 'その他いろいろ')

@section('content')
<main class="container mx-auto mt-8 px-4">
  <h1 class="text-2xl font-bold mb-6">リンク集</h1>

  <ul id="linkList" class="mt-4 space-y-2">
    @foreach ($links as $link)
      <li class="bg-white dark:bg-neutral-900 p-4 shadow-md rounded-lg transition
                hover:shadow-lg hover:-translate-y-0.5 motion-safe:duration-200">
        <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
          class="block text-lg font-semibold text-gray-800 dark:text-gray-100 hover:text-blue-600">
          <span class="inline-flex items-center gap-2">
            {{-- 外部リンクアイコン --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 7h4m0 0v4m0-4L10 14M7 7h3M7 17h10" />
            </svg>
            {{ $link['title'] }}
            <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-700
                        dark:bg-blue-900/30 dark:text-blue-300">外部</span>
          </span>
        </a>

        @isset($link['desc'])
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $link['desc'] }}
          </p>
        @endisset
      </li>
    @endforeach
  </ul>
  </main>


  {{-- トップに戻るボタン --}}
  <button id="backToTop" class="opacity-0 pointer-events-none fixed bottom-6 right-6
    bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500
    hover:bg-orange-700 z-50" aria-label="トップに戻る">
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

  backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
@endpush
