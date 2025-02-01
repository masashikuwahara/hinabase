@extends('layouts.admin')

@section('title', 'メンバー追加')

@section('content')
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        <label for="name">名前:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">追加</button>
    </form>
@endsection