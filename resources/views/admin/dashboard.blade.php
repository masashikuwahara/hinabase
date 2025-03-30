@extends('layouts.app')

@section('content')
    <h1>管理ページ</h1>
    <ul>
        <li><a href="{{ route('admin.members') }}">メンバー管理</a></li>
        <li><a href="{{ route('admin.songs') }}">楽曲管理</a></li>
        <li><a href="{{ route('admin.skills') }}">スキル管理</a></li>
    </ul>
@endsection