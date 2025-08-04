@extends('layouts.main')

@section('title', $member->name)

@section('content')
    <!-- メンバー詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center">{{ $member->name }}</h2>
        <p class="text-xl text-center mt-2">{{ $member->furigana }}</p>
        
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
                    <li><strong>参加楽曲数:</strong> {{ $songCount }}</li>
                    <li><strong>選抜回数:</strong> {{ $titlesongCount }}</li>
                    <li><strong>センター曲数:</strong> {{ $centerCount }}</li>
                    <li><strong class="mr-2">ペンライトカラー:</strong>
                        <div class="inline-flex items-center space-x-4 mt-2 ">
                            <div class="rounded" style="background-color: {{ $member->color1 }}">{{ $member->colorname1 }}</div>
                            <div class="rounded" style="background-color: {{ $member->color2 }}">{{ $member->colorname2 }}</div>
                        </div>
                    </li>
                        @if ($member->sns)
                        <li class="flex items-center">
                            <strong>SNS:</strong>&nbsp;
                            <a href="{{($member->sns) }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('/storage/photos/insta.png') }}"
                                alt="insta" 
                                class="w-7 object-cover rounded-lg shadow-md">
                            </a>
                        </li>
                        @endif
                    <li><strong>キャラクター:</strong> {{ $member->introduction }}</li>
                </ul>
            </div>
            
            <!-- レーダーチャート -->
            <div class="md:ml-8 w-72 h-72">
                <canvas id="radarChart"></canvas>
                注：ぶりっ子は㋳も含む
            </div>
        </section>

        <!-- ここにブログ -->
        <section class="flex flex-col md:flex-row items-start mt-8 bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-xl font-bold mb-4 md:mb-0 md:mr-4 md:flex-none">公式ブログ</h2>
            <div class="mt-2 text-blue-700 font-semibold hover:text-indigo-600 md:mt-0 md:flex-1">
                {!! $blogHtml !!}
            </div>
        </section>
        
        <!-- 参加楽曲リスト -->
        <section class="mt-8">
            <h3 class="text-2xl font-semibold">参加楽曲</h3>
            @if ($member->songs->isEmpty())
                <p class="mt-2 text-gray-700">まだ参加楽曲はありません。</p>
            @else
            {{-- @php
                $songCount = count($member->songs);
            @endphp
            <p>参加曲数: {{ $songCount }}</p> --}}
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

    <!-- Chart.js のスクリプト -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('radarChart').getContext('2d');
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['歌唱力', 'ダンス', 'バラエティ', '学力', 'スポーツ', 'ぶりっ子'],
                    datasets: [{
                        label: '{{ $member->name }} のスキル',
                        data: [{{ $radar->skill->singing }}, {{ $radar->skill->dancing }}, 
                            {{ $radar->skill->variety }}, {{ $radar->skill->intelligence }}, 
                            {{ $radar->skill->sport }},{{ $radar->skill->burikko }},],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            suggestedMin: 0,
                            suggestedMax: 100
                            }
                        }
                    }
                });
            });
    </script>
    {{-- トップに戻る --}}
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
