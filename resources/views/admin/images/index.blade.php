@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">メンバー画像変更</h1>

    @if (session('success'))
        <p class="text-green-600 text-center mb-4">{{ session('success') }}</p>
    @endif

    <ul class="space-y-4">
        @foreach ($members as $member)
            <li class="flex justify-between items-center border-b pb-2">
                <span class="text-lg">{{ $member->name }}</span>
                <a href="{{ route('admin.images.edit', $member->id)}}" class="text-blue-600 hover:underline">編集</a>
            </li>
        @endforeach
    </ul>
    {{ $members->links() }}
    <div class="mt-6 text-center">
        <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">← 管理メニューに戻る</a>
    </div>
</div>
@endsection
