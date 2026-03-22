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
    class="fixed inset-0 bg-white text-black flex flex-col items-center justify-center space-y-6 z-50"
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
      <li><a href="{{ route('home') }}" class="hover:text-blue-600">TOPに戻る</a></li>
      <li><a href="{{ route('members.index') }}" class="hover:text-blue-600">メンバー一覧</a></li>
      <li><a href="{{ route('songs.index') }}" class="hover:text-blue-600">楽曲一覧</a></li>
      <li><a href="{{ route('data.index') }}" class="hover:text-blue-600">日向坂46 データ・ランキングまとめ</a></li>
      <li><a href="{{ route('timeline.index') }}" class="hover:text-blue-600">日向坂46ヒストリー</a></li>
      <li><a href="{{ route('graphs.index') }}" class="hover:text-blue-600">相関図</a></li>
      <li><a href="{{ route('others.index') }}" class="hover:text-blue-600">その他</a></li>
    </ul>
  </nav>
</div>

  <!-- 通常メニュー（PC用） -->
  <nav class="hidden md:block">
    <ul class="flex space-x-6 text-lg">
      <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
      <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
      <li><a href="{{ route('data.index') }}" class="hover:underline">日向坂46 データ・ランキングまとめ</a></li>
      <li><a href="{{ route('timeline.index') }}" class="hover:underline">日向坂46ヒストリー</a></li>
      <li><a href="{{ route('graphs.index') }}" class="hover:underline">相関図</a></li>
      <li><a href="{{ route('others.index') }}" class="hover:underline">その他</a></li>
    </ul>
  </nav>
</header>
{{-- <div class="bg-[#a78bfa] text-white py-2 w-full text-center text-sm md:text-base">
  <a href="{{ route('youtube.ranking') }}" class="hover:text-yellow-200 font-semibold transition-colors duration-200">
    日向坂ちゃんねる 人気動画ランキング（再生数・高評価数を毎日更新中）
  </a>
</div> --}}

<div class="bg-[linear-gradient(90deg,#f19db5_0%,#f7c6a3_25%,#f9e27d_50%,#9dd9f3_75%,#c8b6ff_100%)] text-gray-900 py-2 w-full text-center text-sm md:text-base">
  <a href="{{ route('hinatansai.index') }}" class="hover:text-pink-700 font-semibold transition-colors duration-200">
    7回目のひな誕祭みどころ
  </a>
</div>

{{-- <div class="bg-[#4ade80] text-white py-2 w-full text-center text-sm md:text-base">
  <a href="https://kasumizaka46.com/graphs/hinata-relationship-5th" class="hover:text-yellow-200 font-semibold transition-colors duration-200">
    五期生相関図公開しました
  </a>
</div> --}}