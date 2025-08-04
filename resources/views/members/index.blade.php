@extends('layouts.main')

@section('title', 'メンバー一覧')

@section('content')
    <main class="container mx-auto mt-8 px-4">
        {{-- 現在の状態を表示 --}}
        <h2 class="text-2xl font-semibold">メンバー一覧</h2>
        @if ($sort === 'furigana')
            <p>現在のソート: {{ $sort = '50音順' }} </p>
        @elseif($sort === 'blood_type')
            <p>現在のソート: {{ $sort = '血液型順' }} </p>
        @elseif($sort === 'birthday')
            <p>現在のソート: {{ $sort = '誕生日順' }} </p>
        @elseif($sort === 'height')
            <p>現在のソート: {{ $sort = '身長順' }} </p>
        @elseif($sort === 'birthplace')
            <p>現在のソート: {{ $sort = '出身地順' }} </p>
        @endif
    
        {{-- 切り替えボタン --}}
        <div x-data="{ open: false }" class="relative md:static">
            {{-- モバイル表示時のプルダウンボタン --}}
            <button @click="open = !open" class="md:hidden px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
                並び替え
            </button>
        
            {{-- PC表示時のボタン（モバイルでは非表示） --}}
            <div class="hidden md:flex justify-center space-x-4 mt-4">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">
                    デフォルトに戻す
                </a>
                <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600">
                    50音順
                </a>
                <a href="{{ route('members.index', ['sort' => 'blood_type', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600">
                    血液型順
                </a>
                <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600">
                    誕生日順
                </a>
                <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600">
                    身長順
                </a>
                <a href="{{ route('members.index', ['sort' => 'birthplace', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                    class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow-md hover:bg-pink-600">
                    出身地順
                </a>
            </div>
        
            {{-- モバイル表示時のプルダウンメニュー（初期状態では非表示） --}}
            <div x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-y-95"
            x-transition:enter-end="opacity-100 transform scale-y-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-y-100"
            x-transition:leave-end="opacity-0 transform scale-y-95"
            class="absolute left-0 mt-2 w-full rounded-md shadow-lg bg-blue-100 z-10 md:hidden">
                <div class="py-1">
                    <a href="{{ route('members.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        デフォルトに戻す
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'furigana', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        50音順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'blood_type', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        血液型順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        誕生日順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        身長順
                    </a>
                    <a href="{{ route('members.index', ['sort' => 'birthplace', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        出身地順
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-6">
            <p class="text-sm">ボタンを繰り返し押すと昇順、降順を切り替えることができます</p>
        </div>
    
        @if ($sort === 'default')
            {{-- デフォルト: gradeごとに表示 --}}
            <!-- 在籍メンバー -->
            <section class="mt-6">
                <h3 class="text-xl font-bold text-gray-800">在籍メンバー</h3>
                @if (is_array($currentMembers) || is_object($currentMembers))
                    @if (empty((array)$currentMembers))
                        <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                    @else
                        @foreach ($currentMembers as $grade => $members)
                            <h4 class="text-lg font-semibold mt-4">{{ $grade }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full">
                                            <span class="mt-2 font-semibold">{{ $member->name }}
                                                @if ($member->is_recently_updated)
                                                <span class="text-red-600 font-bold">NEW!</span>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
    
            <div class="text-center text-blue-700 mt-8">
                <a href="https://hinatazaka5th.netlify.app/" target="_blank" rel="noopener noreferrer" class="hover:underline">五期生推しメンチェッカー</a>
            </div>
            <!-- 卒業メンバー -->
            <section class="mt-8">
                <h3 class="text-xl font-bold text-gray-800">卒業メンバー</h3>
                @if (is_array($graduatedMembers) || is_object($graduatedMembers))
                    @if (empty((array)$graduatedMembers))
                        <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                    @else
                        @foreach ($graduatedMembers as $grade => $members)
                            <h4 class="text-lg font-semibold mt-4">{{ $grade }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                                @foreach ($members as $member)
                                    <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                        <a href="{{ route('members.show', $member->id) }}" class="block">
                                            <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                                 alt="{{ $member->name }}"
                                                 class="w-32 h-32 object-cover mx-auto rounded-full">
                                            <span class="mt-2 font-semibold">{{ $member->name }}</span>
                                            @if ($member->is_recently_updated)
                                            <span class="text-red-600 font-bold">NEW!</span>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
        @else
            {{-- gradeを無視してソート --}}
            <section class="mt-6">
                <h3 class="text-xl font-bold text-gray-800">在籍メンバー</h3>
                @if ($currentMembers->isEmpty())
                    <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($currentMembers as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                @if ($member->is_recently_updated)
                                    <span class="text-red-600 font-bold">NEW!</span>
                                @endif
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                         alt="{{ $member->name }}"
                                         class="w-32 h-32 object-cover mx-auto rounded-full">
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                    <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            
            <section class="mt-8">
                <h3 class="text-xl font-bold text-gray-800">卒業メンバー</h3>
                @if ($graduatedMembers->isEmpty())
                    <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($graduatedMembers as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}"
                                        alt="{{ $member->name }}"
                                        class="w-32 h-32 object-cover mx-auto rounded-full">
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                    @if (isset($member->additional_info))
                                    <p class="text-sm text-gray-600">{{ $member->additional_info }}</p>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
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

