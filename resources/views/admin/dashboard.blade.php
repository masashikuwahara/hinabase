@extends('layouts.app')

@section('title', 'メンバー管理トップ')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">メンバー管理</h1>
    <ul class="space-y-4">
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.members') }}" class="text-blue-600 hover:underline">メンバー管理</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.songs') }}" style="pointer-events: none;">楽曲管理 工事中</a></li>
        <li class="flex justify-between items-center border-b pb-2"><a href="{{ route('admin.skills') }}" class="text-blue-600 hover:underline">スキル管理</a></li>
</div>
@endsection