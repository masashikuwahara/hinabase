@extends('layouts.app')

@section('content')
    <h1>楽曲管理</h1>
    <a href="{{ route('admin.songs.create') }}">楽曲登録</a>
    <ul>
        @foreach ($songs as $song)
            <li>{{ $song->title }}</li>
        @endforeach
    </ul>
    <a href="{{ route('admin.dashboard') }}">戻る</a>
@endsection
