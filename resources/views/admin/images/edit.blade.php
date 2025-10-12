@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<main class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">メンバー画像編集: {{ $member->name }}</h2>

    <form action="{{ route('admin.images.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <input type="file" name="image" id="image" accept="images/*">
        </div>
        現在登録されている画像
        @if ($member->image)
            <img src="{{ asset('storage/images/' . $member->image) }}" alt="顔写真" class="w-32 h-32 object-cover rounded">
        @endif
        <button type="submit" class="bg-blue-600 text-white mt-2 px-4 py-2 rounded hover:bg-blue-700">更新</button>
    </form>
</main>
@endsection