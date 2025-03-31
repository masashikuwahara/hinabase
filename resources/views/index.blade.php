@extends('layouts.main')

@section('title', 'HINABASE')

@section('content')
    <div class="text-center mt-8">
        <p class="text-base">日向坂46のメンバーと楽曲のシンプルなデータベースサイトです。</p>
    </div>

    <!-- 検索フォーム -->
    <div class="mt-6 text-center">
        @if (session('error'))
            <div class="text-red-600 font-semibold mb-2">{{ session('error') }}</div>
        @endif
        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 rounded shadow-md">
            <input type="text" name="query" placeholder="小坂菜緒 天才 キュン" 
                class="border p-2 rounded-l-md focus:outline-none focus:ring focus:ring-[#7cc7e8]">
            <button type="submit" class="bg-[#7cc7e8] text-white p-2 rounded-r-md hover:bg-[#5aa6c4]">
                検索
            </button>
        </form>
    </div>
    <div class="text-center mt-8">
        <p class="text-sm">メンバー名、あだ名、楽曲名で検索できます。</p>
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
    </div>
    <div class="text-center w-100 max-h-40 overflow-y-scroll bg-white p-4 rounded-lg shadow-md">
        <div class="text-left inline-block">
            <p class="text-sm">2025.03.28&nbsp;v.1.7.0&nbsp;メンバー詳細ページにふりがな追加</p>
            <p class="text-sm">2025.03.31&nbsp;五期生メンバーを追加</p>
            <p class="text-sm">2025.03.28&nbsp;v.1.6.1&nbsp;メンバー詳細ページにスキル表追加</p>
            <p class="text-sm">2025.03.26&nbsp;v.1.5.0&nbsp;楽曲詳細ページに歌詞リンク追加</p>
            <p class="text-sm">2025.03.22&nbsp;v.1.4.0&nbsp;メンバー一覧ページにソート機能追加</p>
            <p class="text-sm">2025.03.15&nbsp;v.1.3.0&nbsp;メンバー詳細ページにブログ情報追加</p>
            <p class="text-sm">2025.03.14&nbsp;v.1.2.0&nbsp;検索システム改修、あだ名検索に対応</p>
            <p class="text-sm">2025.03.09&nbsp;v.1.1.0&nbsp;メンバー詳細ページにSNS情報追加</p>
            <p class="text-sm">2025.03.01&nbsp;v.1.0.0&nbsp;リリース</p>
        </div>
    </div>
{{-- v.1.7.0 --}}
@endsection