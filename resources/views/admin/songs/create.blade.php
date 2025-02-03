@extends('layouts.admin')

@section('title', '楽曲登録')

@section('content')
    <h1>楽曲登録</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.songs.store') }}" method="POST">
        @csrf
        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title" required>

        <label for="release">リリース日:</label>
        <input type="date" name="release" id="release" required>

        <label for="lyricist">作詞:</label>
        <input type="text" name="lyricist" id="lyricist">

        <label for="composer">作曲:</label>
        <input type="text" name="composer" id="composer">

        <label for="arranger">編曲:</label>
        <input type="text" name="arranger" id="arranger">

        <button type="submit">登録</button>
    </form>

    <a href="{{ route('admin.songs') }}">戻る</a>
@endsection
