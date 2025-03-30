@extends('layouts.app')

@section('title', 'スキル登録')

@section('content')
<h2 class="text-xl font-bold mb-4">スキル登録</h2>
<form action="{{ route('admin.skills.store') }}" method="POST">
    @csrf
    <label class="block">メンバー:</label>
    <select name="member_id" class="border p-2 w-full">
        @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->name }}</option>
        @endforeach
    </select>

    <label class="block mt-4">歌唱力:</label>
    <input type="number" name="singing" class="border p-2 w-full" min="0" max="100">
    
    <label class="block mt-4">ダンス:</label>
    <input type="number" name="dancing" class="border p-2 w-full" min="0" max="100">

    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">登録</button>
</form>
@endsection
