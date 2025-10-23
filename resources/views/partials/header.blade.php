<header class="bg-[#7cc7e8] text-white py-4 px-6 flex justify-between items-center">
  <a href="{{ url('/') }}"><div class="text-2xl font-bold">HINABASE</div></a>
  <!-- ハンバーガーメニュー -->
<div x-data="{ open: false }" class="relative">
  <!-- メニューボタン -->
  <button @click="open = true" class="md:hidden focus:outline-none flex flex-col space-y-1 z-50 relative">
      <span class="block w-1 h-1 bg-white rounded ml-6"></span>
      <span class="block w-3 h-1 bg-white rounded ml-4"></span>
      <span class="block w-5 h-1 bg-white rounded ml-2"></span>
      <span class="block w-7 h-1 bg-white rounded"></span>
  </button>

  <!-- メニュー（モバイル用 全画面） -->
  <nav 
    x-show="open" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 bg-white text-black flex flex-col items-center justify-center space-y-6 z-40"
  >
    <!-- ✕ボタン -->
    <button
      @click="open = false"
      class="absolute top-4 right-4 p-2 rounded hover:bg-gray-100 focus:outline-none"
      aria-label="Close menu"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8">
        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <!-- メニュー項目 -->
    <ul class="flex flex-col space-y-6 text-xl">
      <li><a href="{{ route('members.index') }}" class="hover:text-blue-600">メンバー一覧</a></li>
      <li><a href="{{ route('songs.index') }}" class="hover:text-blue-600">楽曲一覧</a></li>
      <li><a href="{{ route('popular.index') }}" class="hover:text-blue-600">人気ページTOP20</a></li>
      <li><a href="{{ route('others.index') }}" class="hover:text-blue-600">その他</a></li>
    </ul>
  </nav>
</div>

  <!-- 通常メニュー（PC用） -->
  <nav class="hidden md:block">
    <ul class="flex space-x-6 text-lg">
      <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
      <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
      <li><a href="{{ route('popular.index') }}" class="hover:underline">人気ページTOP20</a></li>
      <li><a href="{{ route('others.index') }}" class="hover:underline">その他</a></li>
    </ul>
  </nav>
</header>
<div class="bg-[#a78bfa] text-white py-0 w-full text-center">
  <a href="{{ route('youtube.ranking') }}" class="hover:text-blue-800 font-semibold">
    日向坂ちゃんねる 人気動画ランキング（再生数・高評価数を毎日更新中）
  </a>
</div>
<div class="bg-[#de994a] text-white py-0 w-full text-center">
  <a href="{{ route('timeline.index') }}" class="hover:text-blue-800 font-semibold">
    日向坂46ヒストリーを公開しました
  </a>
</div>
{{-- <div class="bg-[#4ade80] text-white py-0 w-full text-center">
  <a href="{{ route('popular.index') }}" class="hover:text-blue-800 font-semibold">
    人気ページTOP20試験運用開始しました
  </a>
</div> --}}