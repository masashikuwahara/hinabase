@extends('layouts.main')

@section('title', '')

@section('content')
    <section class="text-center mt-8">
        <h1 class="text-2xl font-bold mb-2">日向坂46データベース HINABASE</h1>
        <p class="text-base leading-relaxed">
            日向坂46データベース「HINABASE」では、メンバーのプロフィールやあだ名、生年月日、血液型、身長などの詳細情報に加え、<br>
            楽曲データ（シングル・アルバム・参加メンバー・センター回数・作詞作曲者）をわかりやすく整理しています。<br>
            最新のシングル情報や卒業メンバーのデータも日々更新中です。
        </p>
    </section>

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
                        <span class="mt-2 font-semibold">
                            @if ($song->is_recently_updated)
                            <span class="text-red-600 font-bold">NEW!</span>
                            @endif
                        </span>
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
            @forelse ($logs as $log)
            <p class="text-sm leading-6">
                <span class="tabular-nums">{{ $log->date->format('Y.m.d') }}</span>
                @if($log->version)
                &nbsp;<span class="font-mono">v.{{ ltrim($log->version, 'v.') }}</span>
                @endif
                &nbsp;{!! $log->is_new ? '<span class="text-red-600 font-bold">NEW!</span>&nbsp;' : '' !!}
                @if($log->link)
                <a href="{{ $log->link }}" target="_blank" rel="noopener" class="hover:underline">{{ $log->title }}</a>
                @else
                {{ $log->title }}
                @endif
            </p>
            @empty
            <p class="text-sm text-gray-500">まだ更新履歴はありません。</p>
            @endforelse
        </div>
    </div>
{{-- v.1.22.0 --}}
@endsection