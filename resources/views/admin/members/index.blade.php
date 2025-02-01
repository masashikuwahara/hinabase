@extends('layouts.app')

@section('content')
    <h1>メンバー管理</h1>
    <a href="{{ route('admin.members.create') }}">メンバー登録</a>
    <ul>
        @foreach ($members as $member)
            <li>{{ $member->name }}</li>
        @endforeach
    </ul>
@endsection
