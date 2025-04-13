@extends('layouts.app')

@section('content')
    <h1>メンバー管理</h1>

    <ul>
        @foreach ($members as $member)
            <li>
                {{ $member->name }}
                <a href="{{ route('admin.members.edit', $member->id)}}" class="text-blue-600 hover:underline ml-2">編集</a>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('admin.index') }}">戻る</a>
@endsection
