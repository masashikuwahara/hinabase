@extends('layouts.main')

@section('title', '検索結果')
@push('head_meta')
  <meta name="robots" content="noindex,follow">
@endpush
@section('content')
    <!-- 検索結果 -->
    <main class="container mx-auto mt-8 px-4">
        @php
            $label = match($category) {
                'members' => 'メンバーのみ',
                'songs'   => '楽曲のみ',
                default   => 'すべて',
            };
        @endphp

        <h2 class="text-2xl font-semibold">
            「{{ $query }}」の検索結果 <span class="text-sm text-gray-500">（{{ $label }}）</span>
        </h2>

        @if ($results->isEmpty())
        <p class="mt-4 text-gray-700">該当する結果が見つかりませんでした。</p>
        @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
            @foreach ($results as $result)
            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                <a href="{{ $result['url'] }}" class="block">
                <img
                    src="{{ $result['image_url'] }}"
                    alt="{{ $result['name'] }}"
                    class="w-32 h-32 object-cover mx-auto"
                    loading="lazy" width="128" height="128"
                >
                <p class="mt-2 font-semibold">{{ $result['name'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $result['type'] === 'member' ? 'メンバー' : '楽曲' }}
                </p>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </main>

    {{-- <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">「{{ $query }}」の検索結果</h2>

        @if ($results->isEmpty())
            <p class="mt-4 text-gray-700">該当する結果が見つかりませんでした。</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
                @foreach ($results as $result)
                    <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                        <a href="{{ $result['url'] }}" class="block">
                            <img src="{{ asset('storage/' . ($result['image'] ?? 'default.jpg')) }}" 
                                 alt="{{ $result['name'] }}" 
                                 class="w-32 h-32 object-cover mx-auto">
                            <p class="mt-2 font-semibold">{{ $result['name'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </main> --}}

    <!-- 検索フォーム -->
    <div class="mt-6 text-center">
        @if ($errors->has('query'))
            <div class="text-red-600 font-semibold mb-2">{{ $errors->first('query') }}</div>
        @endif

        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 shadow-md">
            <input
                type="text"
                name="query"
                value="{{ old('query', request('query')) }}"
                placeholder="森田ひかる ほのす BAN"
                class="border p-2 focus:outline-none focus:ring focus:ring-[#f19db5] w-72 md:w-96 lg:w-[500px]"
            >

            <div class="mt-2 flex justify-center" style="--acc:#e91e63;">
            @php $cat = old('category', request('category', 'members')); @endphp

            <fieldset class="inline-flex rounded-full bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden" role="radiogroup" aria-label="検索カテゴリ">
                {{-- すべて
                <label class="relative">
                <input
                    type="radio" name="category" value="all"
                    class="peer sr-only"
                    {{ $cat === 'all' ? 'checked' : '' }}
                >
                <span
                    class="block px-4 py-2 text-sm cursor-pointer select-none
                        text-gray-700 transition
                        hover:bg-gray-50
                        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                        peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                >
                    すべて
                </span>
                </label> --}}

                {{-- メンバー --}}
                <label class="relative border-l border-gray-200">
                <input
                    type="radio" name="category" value="members"
                    class="peer sr-only"
                    {{ $cat === 'members' ? 'checked' : '' }}
                >
                <span
                    class="block px-4 py-2 text-sm cursor-pointer select-none
                        text-gray-700 transition
                        hover:bg-gray-50
                        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                        peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                >
                    メンバー
                </span>
                </label>

                {{-- 楽曲 --}}
                <label class="relative border-l border-gray-2 00">
                <input
                    type="radio" name="category" value="songs"
                    class="peer sr-only"
                    {{ $cat === 'songs' ? 'checked' : '' }}
                >
                <span
                    class="block px-4 py-2 text-sm cursor-pointer select-none
                        text-gray-700 transition
                        hover:bg-gray-50
                        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                        peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                >
                    楽曲
                </span>
                </label>
            </fieldset>
            </div>

            <button type="submit" class="mt-3 bg-[#f19db5] text-white px-4 py-2 hover:bg-[#e488a6]">
                検索
            </button>
        </form>
    </div>
@endsection
