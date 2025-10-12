@extends('layouts.app')

@section('title', 'アカウント設定')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-6">アカウント設定</h1>

    {{-- フラッシュメッセージ --}}
    @if (session('status') === 'password-updated')
        <div class="mb-4 text-green-600 font-semibold">パスワードを更新しました。</div>
    @endif
    @if (session('status') === 'email-updated')
        <div class="mb-4 text-green-600 font-semibold">メールアドレスを更新しました。</div>
    @endif

    {{-- パスワード変更 --}}
    <section class="mb-8">
        <h2 class="text-lg font-semibold mb-3">パスワード変更</h2>
        <form method="POST" action="{{ route('admin.account.password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">現在のパスワード</label>
                <input type="password" name="current_password" class="w-full border rounded p-2">
                @error('current_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">新しいパスワード</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">新しいパスワード（確認）</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button class="bg-[#f19db5] hover:bg-[#e488a6] text-white px-4 py-2 rounded">更新</button>
        </form>
    </section>

    <hr class="my-6">

    {{-- メールアドレス変更 --}}
    <section>
        <h2 class="text-lg font-semibold mb-3">メールアドレス変更</h2>
        <form method="POST" action="{{ route('admin.account.email.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">新しいメールアドレス</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">現在のパスワード（確認）</label>
                <input type="password" name="current_password" class="w-full border rounded p-2">
                @error('current_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button class="bg-[#f19db5] hover:bg-[#e488a6] text-white px-4 py-2 rounded">更新</button>
        </form>
    </section>
</div>
@endsection
