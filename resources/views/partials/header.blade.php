<header class="bg-[#7cc7e8] text-white py-4 px-6 flex justify-between items-center">
  <a href="{{ url('/') }}"><div class="text-2xl font-bold">HINABASE</div></a>
  
  <!-- ハンバーガーメニュー -->
  <div x-data="{ open: false }" class="relative">
    <!-- メニューボタン -->
    <button @click="open = !open" class="md:hidden focus:outline-none flex flex-col space-y-1">
      <span class="block w-1 h-1 bg-white rounded ml-6"></span>
      <span class="block w-3 h-1 bg-white rounded ml-4"></span>
      <span class="block w-5 h-1 bg-white rounded ml-2"></span>
      <span class="block w-7 h-1 bg-white rounded"></span>
    </button>

    <!-- メニュー（モバイル用） -->
    <nav 
      x-show="open" 
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-90"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-90"
      @click.away="open = false" 
      class="absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded-md md:hidden"
    >
      <ul class="flex flex-col space-y-2 p-4">
        <li><a href="{{ route('members.index') }}" class="block hover:bg-gray-200 p-2 rounded">メンバー一覧</a></li>
        <li><a href="{{ route('songs.index') }}" class="block hover:bg-gray-200 p-2 rounded">楽曲一覧</a></li>
        <li><a href="{{ route('others.index') }}" class="block hover:bg-gray-200 p-2 rounded">その他</a></li>
      </ul>
    </nav>
  </div>

  <!-- 通常メニュー（PC用） -->
  <nav class="hidden md:block">
    <ul class="flex space-x-6 text-lg">
      <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
      <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
      <li><a href="{{ route('others.index') }}" class="hover:underline">その他</a></li>
    </ul>
  </nav>
</header>
