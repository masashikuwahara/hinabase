@extends('layouts.main')

@section('title', ' 日向坂46相関図 | HINABASE')
@section('meta_description', '日向坂46メンバーの相関図を公開！度のメンバーとどんな関係か分かります。')

@push('head_meta')
@endpush

@section('content')
<main class="container mx-auto mt-8 px-4">
  <h1 class="text-2xl font-bold font-mont mb-6">日向坂46相関図</h1>

  <ul id="linkList" class="mt-4 space-y-2">
    @foreach ($links as $link)
      <li class="bg-white dark:bg-neutral-900 p-4 shadow-md rounded-lg transition
                hover:shadow-lg hover:-translate-y-0.5 motion-safe:duration-200">
        <a href="{{ $link['url'] }}" 
          class="block text-lg font-semibold text-gray-800 dark:text-gray-100 hover:text-blue-600"
        >
          <span class="inline-flex items-center gap-2">
            {{-- 外部リンクアイコン --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 7h4m0 0v4m0-4L10 14M7 7h3M7 17h10" />
            </svg>
            {{ $link['title'] }}
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
@endsection