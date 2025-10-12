@extends('layouts.main')

@section('title', '櫻坂46データベース | SAKURAAC - メンバー・楽曲のプロフィールとデータ')

@section('content')
    <section class="text-center mt-8">
        <h1 class="text-2xl font-bold mb-2">櫻坂46データベース SAKURAAC</h1>
        <p class="text-base leading-relaxed">
            櫻坂46データベース「SAKURAAC」では、メンバーのプロフィールやあだ名、生年月日、血液型、身長などの詳細情報に加え、<br>
            楽曲データ（シングル・アルバム・参加メンバー・センター回数・作詞作曲者）をわかりやすく整理しています。<br>
            最新のシングル情報や卒業メンバーのデータも日々更新中です。
        </p>
    </section>

    <!-- 検索フォーム -->
    <div class="mt-6 text-center">
        @if ($errors->has('query'))
            <div class="text-red-600 font-semibold mb-2">{{ $errors->first('query') }}</div>
        @endif

        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 shadow-md">
            {{-- キーワード --}}
            <input
                type="text"
                name="query"
                value="{{ old('query', request('query')) }}"
                placeholder="森田ひかる ほのす BAN"
                class="border p-2 focus:outline-none focus:ring focus:ring-[#f19db5] w-72 md:w-96 lg:w-[500px]"
            >

            <div class="mt-2 flex justify-center" style="--acc:#e91e63;">
            @php $cat = old('category', request('category', 'members')); @endphp

            <fieldset class="inline-flex bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden" role="radiogroup" aria-label="検索カテゴリ">

                {{-- メンバー --}}
                <label class="relative border-l border-gray-200">
                <input
                    type="radio" name="category" value="members"
                    class="peer sr-only"
                    {{ $cat === 'members' ? 'checked' : '' }}
                >
                <span
                    class="block px-4 py-2 text-sm cursor-pointer select-none
                        text-gray-700 transition
                        hover:bg-gray-50
                        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                        peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                >
                    メンバー
                </span>
                </label>

                {{-- 楽曲 --}}
                <label class="relative border-l border-gray-2 00">
                <input
                    type="radio" name="category" value="songs"
                    class="peer sr-only"
                    {{ $cat === 'songs' ? 'checked' : '' }}
                >
                <span
                    class="block px-4 py-2 text-sm cursor-pointer select-none
                        text-gray-700 transition
                        hover:bg-gray-50
                        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--acc)]
                        peer-checked:bg-[var(--acc)] peer-checked:text-white peer-checked:shadow-inner"
                >
                    楽曲
                </span>
                </label>
            </fieldset>
            </div>

            <button type="submit" class="mt-3 bg-[#f19db5] text-white px-4 py-2 hover:bg-[#e488a6]">
                検索
            </button>
        </form>
    </div>
    
    <!-- メンバー一覧 -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">メンバー</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
            @foreach ($members as $member)
                <div class="bg-white shadow-md  p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('members.show', $member->id) }}">
                        <img src="{{ asset('storage/images/' . $member->image) }}" 
                        alt="{{ $member->name }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto"
                        loading="lazy" width="128" height="128">
                        <span class="mt-2 font-semibold">{{ $member->name }}
                            @if ($member->is_recently_updated)
                            <span class="text-red-600 font-bold">NEW!</span>
                            @endif
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    <div class="flex items-center justify-center mt-5">
        <a href="{{ route('members.index') }}" 
            class="bg-[#f19db5] text-white text-lg font-semibold py-3 px-6  hover:bg-[#e488a6] transition-transform hover:scale-105">
            メンバー一覧をすべて見る
        </a>
    </div>
    
    
    <!-- 楽曲一覧（グリッド表示） -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">楽曲</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
            @foreach ($songs as $song)
                <div class="bg-white shadow-md  p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('songs.show', $song->id) }}">
                        <img src="{{ asset('storage/photos/' . $song->photo) }}" 
                        alt="{{ $song->title }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover  mx-auto"
                        loading="lazy" width="128" height="128">
                        <p class="mt-2 font-semibold">{{ $song->title }}</p>
                        <span class="mt-2 font-semibold">
                            @if ($song->is_recently_updated)
                            <span class="text-red-600 font-bold">NEW!</span>
                            @endif
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    <div class="flex items-center justify-center mt-5">
        <a href="{{ route('songs.index') }}" 
            class="bg-[#f19db5] text-white text-lg font-semibold py-3 px-6  hover:bg-[#e488a6] transition-transform hover:scale-105">
            楽曲一覧をすべて見る
        </a>
    </div>

    <!-- 閲覧履歴 -->
    <section class="mt-10 px-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">最近見たページ</h2>
            <button id="clearRecent"
            class="bg-[#f19db5] text-white text-xs font-semibold py-2 px-4 hover:bg-[#e488a6] transition-transform"">履歴をクリア</button>
        </div>
        <div id="recently-viewed" class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2"></div>
    </section>

    <div class="text-center mt-8">
        <p class="text-sm">--更新履歴--</p>
    </div>

    <!-- 更新履歴 -->
    <div class="mx-auto w-1/2 max-h-60 overflow-y-scroll bg-white p-4 shadow-md">
        <div class="text-left inline-block w-full">
            @forelse ($logs as $log)
            <p class="text-sm leading-6">
                <span class="tabular-nums">{{ $log->date->format('Y.m.d') }}</span>
                @if($log->version)
                &nbsp;<span class="font-mono">v.{{ ltrim($log->version, 'v.') }}</span>
                @endif
                &nbsp;{!! $log->is_new ? '<span class="text-red-600 font-bold">NEW!</span>&nbsp;' : '' !!}
                @if($log->link)
                <a href="{{ $log->link }}" target="_blank" rel="noopener" class="hover:underline">{{ $log->title }}</a>
                @else
                {{ $log->title }}
                @endif
            </p>
            @empty
            <p class="text-sm text-gray-500">まだ更新履歴はありません。</p>
            @endforelse
        </div>
    </div>

    
    <!-- 閲覧履歴の処理  -->
    <script>
        (() => {
        const KEY = 'recentlyViewed';
        const container = document.getElementById('recently-viewed');
        if (!container) return;

        const toImageUrl = (item) => {
            let src = item?.image || '';
            if (!src) return '';

            src = src.replace(/\\/g, '/');

            if (/^https?:\/\//i.test(src)) {
            const u = new URL(src);
            if (/^\/storage\/[^/]+\.(png|jpe?g|webp|gif|avif)$/i.test(u.pathname)) {
                const folder = item?.type === 'member' ? 'images' : 'photos';
                u.pathname = `/storage/${folder}/${u.pathname.split('/').pop()}`;
                return u.toString();
            }
            return src;
            }

            if (/^\/storage\/[^/]+\.(png|jpe?g|webp|gif|avif)$/i.test(src)) {
            const folder = item?.type === 'member' ? 'images' : 'photos';
            const fname = src.split('/').pop();
            return `/storage/${folder}/${fname}`;
            }

            if (/^\/storage\/(images|photos)\//i.test(src)) return src;

            if (/^storage\/(images|photos)\//i.test(src)) return '/' + src;

            const folder = item?.type === 'member' ? 'images' : 'photos';
            return `/storage/${folder}/${src.replace(/^\/+/, '')}`;
        };

        const raw = localStorage.getItem(KEY);
        const list = raw ? JSON.parse(raw) : [];

        if (!list.length) {
            container.innerHTML = '<p class="text-gray-600">まだ履歴はありません。</p>';
            return;
        }

        const normalized = list.map(it => ({ ...it, image: toImageUrl(it) }));
        localStorage.setItem(KEY, JSON.stringify(normalized));

        container.innerHTML = normalized.map(item => {
            const img = item.image;
            return `
            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
                <a href="${item.url}">
                ${img ? `<img src="${img}" alt="${item.title}" width="128" height="128" loading="lazy"
                    class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto">` : ''}
                <p class="mt-2 font-semibold">${item.title}</p>
                <p class="text-xs text-gray-500">${item.type === 'member' ? 'メンバー' : '楽曲'}</p>
                </a>
            </div>
            `;
        }).join('');

        const clearBtn = document.getElementById('clearRecent');
        clearBtn?.addEventListener('click', () => {
            localStorage.removeItem(KEY);
            container.innerHTML = '<p class="text-gray-600">履歴をクリアしました。</p>';
        });
        })();
    </script>
<<<<<<< HEAD
@endsection