@extends('layouts.admin')

@section('title', '楽曲登録')

@section('content')
    <h1>楽曲登録</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data">
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

        <label for="is_recorded">収録:</label>
        <input type="text" name="is_recorded" id="is_recorded">

        <label for="titlesong">表題曲？:</label>
        <select name="titlesong" id="titlesong">
            <option value="1" >表題曲</option>
            <option value="0" >その他</option>
        </select>

        <label for="youtube">YouTube:</label>
        <input type="text" name="youtube" id="youtube">

        <label for="photo">ジャケット写真:</label>
        <input type="file" name="photo" id="photo" accept="image/*">

        <button type="submit">登録</button>
    </form>

    <a href="{{ route('admin.songs') }}">戻る</a>
@endsection
