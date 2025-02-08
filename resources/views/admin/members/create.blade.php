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

        <label for="height">身長:</label>
        <input type="text" name="height" id="height" >

        <label for="blood_type">血液型:</label>
        <select name="blood_type" id="blood_type">
            <option value="A型" >A型</option>
            <option value="B型" >B型</option>
            <option value="O型" >O型</option>
            <option value="AB型" >AB型</option>
            <option value="不明" >不明</option>
        </select>

        <label for="birthplace">出身地:</label>
        <input type="text" name="birthplace" id="birthplace" >

        <label for="grade">学年:</label>
        <select name="grade" id="grade">
            <option value="一期生" >一期生</option>
            <option value="二期" >二期生</option>
            <option value="三期生" >三期生</option>
            <option value="四期生" >四期生</option>
        </select>

        <label for="color1">カラー1:</label>
        <input type="text" name="color1" id="color1" >

        <label for="colorname1">カラー1名称:</label>
        <input type="text" name="colorname1" id="colorname1" >

        <label for="color2">カラー2:</label>
        <input type="text" name="color2" id="color2" >

        <label for="colorname2">カラー2名称:</label>
        <input type="text" name="colorname2" id="colorname2" >

        <label for="image">顔写真:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <label for="graduation">卒業:</label>
        <select name="graduation" id="graduation">
            <option value="0" >在籍</option>
            <option value="1" >卒業</option>
        </select>
        <button type="submit">追加</button>
    </form>

    カラー参考<br>
    パステルブルー	#49BDF0br<br>
    エメラルドグリーン	#00a968<br>
    グリーン	#00a960<br>
    パールグリーン	#98fb98<br>
    ライトグリーン	#90ee90<br>
    イエロー	#ffdc00<br>
    オレンジ	#ffa500<br>
    レッド	#ff0000<br>
    ホワイト	#ffffff<br>
    サクラピンク	#fceeeb<br>
    ピンク	#FFC0CB<br>
    パッションピンク	#fc0fc0<br>
    バイオレット	#5a4498<br>
    パープル	#9b72b0<br>
    ブルー	#0000ff<br>

    <a href="{{ route('admin.members') }}">戻る</a>
@endsection