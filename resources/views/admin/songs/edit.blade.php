@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<main class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">楽曲編集: {{ $song->title }}</h2>

    <form action="{{ route('admin.members.update', $song->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold mb-1">タイトル</label>
            <input type="text" name="name" value="{{ old('name', $song->title) }}" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新</button>
    </form>
</main>
@endsection