@extends('layouts.app')

@section('title', '更新履歴一覧')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">更新履歴一覧</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.changelogs.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           ＋ 新規追加
        </a>
    </div>

    <table class="w-full border border-gray-300 bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">日付</th>
                <th class="p-2 border">バージョン</th>
                <th class="p-2 border">タイトル</th>
                <th class="p-2 border text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td class="p-2 border">{{ $log->date->format('Y.m.d') }}</td>
                    <td class="p-2 border">{{ $log->version }}</td>
                    <td class="p-2 border">{{ $log->title }}</td>
                    <td class="p-2 border text-center">
                        <form action="{{ route('admin.changelogs.destroy', $log) }}" method="POST" onsubmit="return confirm('削除しますか？');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">まだ更新履歴はありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }} {{-- ページネーション --}}
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">← 管理メニューに戻る</a>
    </div>
</div>
@endsection
