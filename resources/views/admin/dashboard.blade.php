@extends('layouts.app')

@section('title', '管理パネルトップ')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">管理パネル</h1>
    <ul class="space-y-4">
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.members') }}" class="text-blue-600 hover:underline">メンバー管理</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.images') }}" class="text-blue-600 hover:underline">メンバー画像変更</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.songs') }}" class="text-blue-600 hover:underline">楽曲管理</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.changelogs.index') }}" class="text-blue-600 hover:underline">履歴管理</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.skills') }}" style="pointer-events: none;">スキル管理 工事中</a></li>
</div>
@endsection