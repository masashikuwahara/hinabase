@extends('layouts.main')

@section('title', 'HINABASE')

@section('content')
    <div class="text-center mt-8">
        <p class="text-sm">日向坂46のメンバーと楽曲のシンプルなデータベースサイトです。</p>
    </div>

    <!-- 検索フォーム -->
    <div class="mt-6 text-center">
        @if (session('error'))
            <div class="text-red-600 font-semibold mb-2">{{ session('error') }}</div>
        @endif
        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 rounded shadow-md">
            <input type="text" name="query" placeholder="メンバー名、楽曲名で検索" 
                class="border p-2 rounded-l-md focus:outline-none focus:ring focus:ring-[#7cc7e8]">
            <button type="submit" class="bg-[#7cc7e8] text-white p-2 rounded-r-md hover:bg-[#5aa6c4]">
                検索
            </button>
        </form>
    </div>

    <!-- メンバー一覧 -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">メンバー</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
            @foreach ($members as $member)
                <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('members.show', $member->id) }}">
                        <img src="{{ asset('storage/' . $member->image) }}" 
                        alt="{{ $member->name }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-full mx-auto">
                        <p class="mt-2 font-semibold">{{ $member->name }}</p>
                    </a>
                </div>
            @endforeach
            <div class="flex items-center justify-center">
                <a href="{{ route('members.index') }}" 
                    class="bg-[#7cc7e8] text-white text-lg font-semibold py-3 px-6 rounded-lg hover:bg-[#5aa6c4] transition-transform hover:scale-105">
                    and more...
                </a>
            </div>
        </div>
    </section>
    
    <!-- 楽曲一覧（グリッド表示） -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">楽曲</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
            @foreach ($songs as $song)
                <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('songs.show', $song->id) }}">
                        <img src="{{ asset('storage/' . $song->photo) }}" 
                        alt="{{ $song->title }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto">
                        <p class="mt-2 font-semibold">{{ $song->title }}</p>
                    </a>
                </div>
            @endforeach
            <div class="flex items-center justify-center">
                <a href="{{ route('songs.index') }}" 
                    class="bg-[#7cc7e8] text-white text-lg font-semibold py-3 px-6 rounded-lg hover:bg-[#5aa6c4] transition-transform hover:scale-105">
                    and more...
                </a>
            </div>
        </div>
    </section>
    <div class="text-center mt-8">
        <p class="text-sm">--更新履歴--</p>
        <p class="text-sm">2025.03.09&nbsp;メンバー詳細ページレイアウト修正</p>
    </div>
@endsection