@extends('layouts.app')

@section('content')
    <h1>楽曲管理</h1>
    <h1>楽曲登録←まだ未作成</h1>
    <ul>
        @foreach ($songs as $song)
            <li>{{ $song->title }}</li>
        @endforeach
    </ul>
    <a href="{{ route('admin.dashboard') }}">戻る</a>
@endsection
