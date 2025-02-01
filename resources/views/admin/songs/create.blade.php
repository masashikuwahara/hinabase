@extends('layouts.admin')

@section('title', '楽曲追加')

@section('content')
    <form action="{{ route('admin.songs.store') }}" method="POST">
        @csrf
        <label for="title">楽曲名:</label>
        <input type="text" name="title" id="title" required>
        <button type="submit">追加</button>
    </form>
@endsection
