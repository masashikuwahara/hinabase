@extends('layouts.main')

@section('title', 'メンバー一覧')

@section('content')
    <!-- メンバー一覧 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">メンバー一覧</h2>
    
        <p>現在のソート: {{ $sort }} ({{ $order }})</p>
    
        {{-- 切り替えボタン --}}
        <a href="{{ route('members.index') }}">デフォルトに戻す</a>
        <a href="{{ route('members.index', ['sort' => 'name', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">名前順</a>
        <a href="{{ route('members.index', ['sort' => 'grade', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">学年順</a>
        <a href="{{ route('members.index', ['sort' => 'graduation', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">卒業/在籍順</a>
        <a href="{{ route('members.index', ['sort' => 'height', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">身長順</a>
        <a href="{{ route('members.index', ['sort' => 'blood_type', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">血液型順</a>
        <a href="{{ route('members.index', ['sort' => 'birthday', 'order' => $order === 'asc' ? 'desc' : 'asc']) }}">生年月日順</a>
    
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
                                            <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                @endif
            </section>
    
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
                                            <p class="mt-2 font-semibold">{{ $member->name }}</p>
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
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </main>
@endsection

