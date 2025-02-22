@extends('layouts.main')

@section('title', 'メンバー一覧')

@section('content')
    <!-- メンバー一覧 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">メンバー一覧</h2>

        <!-- 在籍メンバー -->
        <section class="mt-6">
            <h3 class="text-xl font-bold text-gray-800">在籍メンバー</h3>
            @if ($currentMembers->isEmpty())
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
        </section>

        <!-- 卒業メンバー -->
        <section class="mt-8">
            <h3 class="text-xl font-bold text-gray-800">卒業メンバー</h3>
            @if ($graduatedMembers->isEmpty())
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
        </section>
    </main>
@endsection

