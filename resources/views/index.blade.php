@extends('layouts.main')

@section('title', 'HINABASE')

@section('content')
    <div class="text-center mt-8">
        <p class="text-base">日向坂46のメンバーと楽曲のシンプルなデータベースサイトです。</p>
        <p class="text-base text-red-600">
            <a href="https://x.gd/xqf5z" target="_blank" rel="noopener noreferrer" class="hover:underline">
                櫻坂46のデータベースサイトはこちらから
            </a>
        </p>
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
    <div class="text-center mt-3">
        <p class="text-sm">メンバー名、あだ名、楽曲名、作曲者名で検索できます。</p>
    </div>
    
    <div class="text-center text-blue-700 font-bold mt-8">
        <a href="https://hinaselect2.netlify.app/" target="_blank" rel="noopener noreferrer" class="hover:underline">日向坂46推しメンチェッカー</a>
    </div>
    <div class="text-center mt-2">
        <p class="text-base">
            五期生も加入しますます推しメン選びに迷っているアナタ！<br>
            試してみてください。
        </p>
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
                        <span class="mt-2 font-semibold">{{ $member->name }}
                            @if ($member->is_recently_updated)
                            <span class="text-red-600 font-bold">NEW!</span>
                            @endif
                        </span>
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
            <p class="text-sm">2025.08.04&nbsp;v.1.17.0&nbsp;メンバー参加楽曲の切り替えボタン実装</p>
            <p class="text-sm">2025.06.04&nbsp;v.1.13.1&nbsp;作曲者での検索に対応</p>
            <p class="text-sm">2025.04.26&nbsp;v.1.11.0&nbsp;ふりがな検索に対応、ソート機能改修</p>
            <p class="text-sm">2025.04.11&nbsp;五期生のプロフィールを更新しました</p>
            <p class="text-sm">2025.04.11&nbsp;佐々木久美、佐々木美玲を卒業メンバーに移動しました</p>
            <p class="text-sm">2025.04.08&nbsp;清水理央と渡辺莉奈のペンライトカラーを変更しました</p>
            <p class="text-sm">2025.04.08&nbsp;五期生のブログを追加しました</p>
            <p class="text-sm">2025.04.08&nbsp;五期生のプロフィールを更新しました</p>
            <p class="text-sm">2025.04.03&nbsp;v.1.9.0&nbsp;メンバー詳細に参加曲数、選抜回数、センター曲数を追加</p>
            <p class="text-sm">2025.04.02&nbsp;v.1.8.0&nbsp;ソート機能に50音順、出身地順を追加</p>
            <p class="text-sm">2025.04.01&nbsp;v.1.7.0&nbsp;メンバー詳細ページにふりがな追加</p>
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
{{-- v.1.17.2 --}}
@endsection