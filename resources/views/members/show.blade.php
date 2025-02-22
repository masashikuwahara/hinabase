@extends('layouts.main')

@section('title', $member->name)

@section('content')
    <!-- メンバー詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center">{{ $member->name }}</h2>
        
        <section class="flex flex-col md:flex-row items-center mt-8 bg-white p-6 shadow-md rounded-lg">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $member->image) }}" 
                     alt="{{ $member->name }}" 
                     class="w-56 h-72 object-cover rounded-lg shadow-md">
            </div>
            
            <!-- メンバー情報 -->
            <div class="md:ml-8 mt-4 md:mt-0">
                <h3 class="text-xl font-semibold">プロフィール</h3>
                <ul class="mt-2 text-gray-800">
                    <li><strong>ニックネーム:</strong> {{ $member->nickname }}</li>
                    <li><strong>生年月日:</strong> {{ \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日') }}</li>
                    <li><strong>星座:</strong> {{ $member->constellation }}</li>
                    <li><strong>身長:</strong> {{ $member->height }}cm</li>
                    <li><strong>血液型:</strong> {{ $member->blood_type }}</li>
                    <li><strong>出身地:</strong> {{ $member->birthplace }}</li>
                    <li><strong>加入:</strong> {{ $member->grade }}</li>
                    <li><strong>ペンライトカラー:</strong></li>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="w-26 h-6 rounded" style="background-color: {{ $member->color1 }};">{{ $member->colorname1 }}</div>
                        <div class="w-26 h-6 rounded" style="background-color: {{ $member->color2 }};">{{ $member->colorname2 }}</div>
                    </div>
                    <li><strong>キャラクター:</strong> {{ $member->introduction }}</li>
                </ul>
            </div>
        </section>
        
        <!-- 参加楽曲リスト -->
        <section class="mt-8">
            <h3 class="text-2xl font-semibold">参加楽曲</h3>
            @if ($member->songs->isEmpty())
                <p class="mt-2 text-gray-700">ただいま編集中です。</p>
            @else
                <ul class="mt-4 space-y-2">
                    @foreach ($member->songs as $song)
                        <li class="bg-white p-4 shadow-md rounded-lg">
                            <a href="{{ route('songs.show', $song->id) }}" class="block text-lg font-semibold hover:text-blue-600">
                                {{ $song->title }}
                            @if ($song->pivot->is_center)
                                <strong class="text-red-600">（センター）</strong>
                            @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
@endsection
