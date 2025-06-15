@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">メンバー管理</h1>

    @if (session('success'))
        <p class="text-green-600 text-center mb-4">{{ session('success') }}</p>
    @endif

    <ul class="space-y-4">
        @foreach ($songs as $song)
            <li class="flex justify-between items-center border-b pb-2">
                <span class="text-lg">{{ $song->title }}</span>
                {{-- <a href="{{ route('admin.songs.edit', $song->id)}}" class="text-blue-600 hover:underline">編集</a> --}}
            </li>
        @endforeach
    </ul>
    <div class="inline-block scale-90 origin-top-left">
        {{ $songs->links() }}
    </div>
    <div class="mt-6 text-center">
        <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">← 管理メニューに戻る</a>
    </div>
</div>
@endsection
