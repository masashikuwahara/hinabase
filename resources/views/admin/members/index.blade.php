@extends('layouts.app')

@section('content')
    <h1>メンバー管理</h1>
    <ul>
        @foreach ($members as $member)
            <li>{{ $member->name }}</li>
        @endforeach
    </ul>
@endsection
