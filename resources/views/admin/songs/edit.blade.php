@extends('layouts.app')

@section('title', '楽曲編集')

@section('content')
<main class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">楽曲編集: {{ $song->title }}</h2>

    <form action="{{ route('admin.songs.update', $song->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold mb-1">タイトル</label>
            <input type="text" name="title" value="{{ old('name', $song->title) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">リリース日</label>
            <input type="date" name="release" value="{{ old('name', $song->release) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">作詞者</label>
            <input type="text" name="lyricist" value="{{ old('name', $song->lyricist) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">作曲者</label>
            <input type="text" name="composer" value="{{ old('name', $song->composer) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">編曲者</label>
            <input type="text" name="arranger" value="{{ old('name', $song->arranger) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">収録</label>
            <input type="text" name="is_recorded" value="{{ old('name', $song->is_recorded) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">歌詞</label>
            <input type="text" name="lyric" value="{{ old('name', $song->lyric) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">タイトル曲</label>
            <input type="text" name="titlesong" value="{{ old('name', $song->titlesong) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">MV</label>
            <input type="text" name="youtube" value="{{ old('name', $song->youtube) }}" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新</button>
    </form>
</main>
@endsection