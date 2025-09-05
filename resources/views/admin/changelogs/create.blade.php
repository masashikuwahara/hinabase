@extends('layouts.app')

@section('title', '更新履歴の追加')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">更新履歴の追加</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.changelogs.store') }}" method="POST" class="space-y-4 bg-white p-6 shadow rounded">
        @csrf

        <div>
            <label class="block font-semibold">日付</label>
            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                   class="border p-2 rounded w-64">
        </div>

        <div>
            <label class="block font-semibold">バージョン</label>
            <input type="text" name="version" value="{{ old('version') }}"
                   placeholder="例: 1.17.0"
                   class="border p-2 rounded w-64">
        </div>

        <div>
            <label class="block font-semibold">タイトル</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="更新内容を入力"
                   class="border p-2 rounded w-full">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                保存
            </button>
            <a href="{{ route('admin.changelogs.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
               戻る
            </a>
        </div>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">← 管理メニューに戻る</a>
    </div>
</div>
@endsection
