<header class="bg-[#7cc7e8] text-white py-4 px-6 flex justify-between items-center">
  <a href="{{ url('/') }}"><h1 class="text-2xl font-bold">HINABASE</h1></a>
  <nav>
      <ul class="flex space-x-6 text-lg">
          <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
          <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
      </ul>
  </nav>
</header>