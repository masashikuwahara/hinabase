@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<main class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">メンバー編集: {{ $member->name }}</h2>

    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold mb-1">名前</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">ニックネーム</label>
            <input type="text" name="nickname" value="{{ old('nickname', $member->nickname) }}" class="w-full border rounded p-2">
        </div>

        <!-- 他の項目も同様に追加 -->
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新</button>
    </form>
</main>
@endsection