@extends('layouts.admin')

@section('title', 'メンバー追加')

@section('content')
    <h1>メンバー登録</h1>
    
    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">名前:</label>
        <input type="text" name="name" id="name" required>
        
        <label for="birthday">誕生日:</label>
        <input type="date" name="birthday" id="birthday" required>

        <label for="constellation">星座:</label>
        <input type="text" name="constellation" id="constellation" >

        <label for="blood_type">血液型:</label>
        <input type="text" name="blood_type" id="blood_type" >

        <label for="birthplace">出身地:</label>
        <input type="text" name="birthplace" id="birthplace" >

        <label for="grade">学年:</label>
        <input type="text" name="grade" id="grade" >

        <label for="color1">カラー1:</label>
        <input type="text" name="color1" id="color1" >

        <label for="color2">カラー2:</label>
        <input type="text" name="color2" id="color2" >

        <label for="selection">選抜情報:</label>
        <input type="text" name="selection" id="selection" >

        <label for="image">顔写真:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <label for="graduation">卒業:</label>
        <select name="graduation" id="graduation">
            <option value="0" >在籍</option>
            <option value="1" >卒業</option>
        </select>
        <button type="submit">追加</button>
    </form>

    <a href="{{ route('admin.members') }}">戻る</a>
@endsection