@extends('layouts.main')

@section('title', '楽曲一覧')

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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
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
@endsection
