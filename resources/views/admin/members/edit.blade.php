@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<main class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">メンバー編集: {{ $member->name }}</h2>

    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold mb-1">名前</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ふりがな</label>
            <input type="text" name="furigana" value="{{ old('furigana', $member->furigana) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ニックネーム</label>
            <input type="text" name="nickname" value="{{ old('nickname', $member->nickname) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">誕生日</label>
            <input type="date" name="birthday" value="{{ old('birthday', $member->birthday) }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">星座</label>
            <input type="text" name="constellation" value="{{ old('constellation', $member->constellation) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">身長</label>
            <input type="text" name="height" value="{{ old('height', $member->height) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">血液型</label>
            <input type="text" name="blood_type" value="{{ old('blood_type', $member->blood_type) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">出身地</label>
            <input type="text" name="birthplace" value="{{ old('birthplace', $member->birthplace) }}" class="w-full border rounded p-2">
        </div>
        {{-- <div class="mb-4">
            <label class="block font-bold mb-1">何期生</label>
            <select name="grade" class="w-full border rounded p-2">
                <option value="けやき坂46" >けやき坂46</option>
                <option value="一期生" >一期生</option>
                <option value="二期生" >二期生</option>
                <option value="三期生" >三期生</option>
                <option value="四期生" >四期生</option>
                <option value="五期生" >五期生</option>
            </select>
        </div> --}}
        <div class="mb-4">
            <label class="block font-bold mb-1">ペンライトカラーコード1</label>
            <input type="text" name="color1" value="{{ old('color1', $member->color1) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ペンライトカラー</label>
            <input type="text" name="colorname1" value="{{ old('colorname1', $member->colorname1) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ペンライトカラーコード2</label>
            <input type="text" name="color2" value="{{ old('color2', $member->color2) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ペンライトカラー2</label>
            <input type="text" name="colorname2" value="{{ old('colorname2', $member->colorname2) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">個人PV</label>
            <textarea name="promotion_video" class="w-full border rounded p-2">{{ old('promotion_video', $member->promotion_video) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">SNS</label>
            <input type="text" name="sns" value="{{ old('sns', $member->sns) }}" class="w-full border rounded p-2">
        </div>
        {{-- <div class="mb-4">
            <label class="block font-bold mb-1">顔写真</label>
            <input type="file" name="image" id="image" accept="images/*">
        </div>
        @if ($member->image)
            <img src="{{ asset('storage/' . $member->image) }}" alt="顔写真" class="w-32 h-32 object-cover rounded">
        @endif --}}
        <div class="mb-4">
            <label class="block font-bold mb-1">在籍or卒業</label>
            <select name="graduation" class="w-full border rounded p-2">
                <option value="0" >在籍</option>
                <option value="1" >卒業</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">キャラクター</label>
            <textarea name="introduction" class="w-full border rounded p-2">{{ old('introduction', $member->introduction) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">ブログ</label>
            <input type="text" name="blog_url" value="{{ old('blog_url', $member->blog_url) }}" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新</button>
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
</main>
@endsection