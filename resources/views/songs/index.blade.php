@extends('layouts.main')

@section('title', '日向坂46楽曲一覧')

@section('content')
    <!-- 楽曲一覧 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">楽曲一覧</h2>

        <!-- 表題曲 -->
        <section class="mt-6">
            <h3 class="text-xl font-bold text-gray-800">表題曲</h3>
            @if ($singles->isEmpty())
                <p class="mt-2 text-gray-700">表題曲はまだありません。</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                    @foreach ($singles as $song)
                    <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                        <a href="{{ route('songs.show', $song->id) }}" class="block">
                            <img src="{{ asset('storage/' . ($song->photo ?? 'default.jpg')) }}" 
                                alt="{{ $song->title }}" 
                                class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto"">
                            <p class="mt-2 font-semibold">{{ $song->title }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- c/w、その他 -->
        <section class="mt-8">
            <h3 class="text-xl font-bold text-gray-800">c/w、その他</h3>
            @if ($others->isEmpty())
                <p class="mt-2 text-gray-700">c/wやその他の楽曲はまだありません。</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                    @foreach ($others as $song)
                        <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                            <a href="{{ route('songs.show', $song->id) }}" class="block">
                                <img src="{{ asset('storage/' . ($song->photo ?? 'default.jpg')) }}" 
                                    alt="{{ $song->title }}" 
                                    class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto"">
                                <p class="mt-2 font-semibold">{{ $song->title }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
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
