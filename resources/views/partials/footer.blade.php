<footer class="bg-[#7cc7e8] text-white text-center py-4 mt-8">
  <p class="text-xs sm:text-sm">&copy; {{ date('Y') }} HINABASE. All rights reserved.</p>

  <div class="flex flex-wrap justify-center items-center mt-3 text-xs sm:text-sm">
    <a href="{{ route('members.index') }}" class="mx-2 hover:underline">メンバー一覧</a>
    <span class="text-white/70">|</span>
    <a href="{{ route('songs.index') }}" class="mx-2 hover:underline">楽曲一覧</a>
    <span class="text-white/70">|</span>
    <a href="{{ route('popular.index') }}" class="mx-2 hover:underline">人気ページTOP20</a>
    <span class="text-white/70">|</span>
    <a href="{{ route('others.index') }}" class="mx-2 hover:underline">その他</a>
    <span class="text-white/70">|</span>
    <a href="https://x.com/sakamichiiwlu4e" target="_blank" rel="noopener noreferrer" class="mx-2 hover:underline">X</a>
    <span class="text-white/70">|</span>
    <a href="https://x.gd/I7a73" target="_blank" rel="noopener noreferrer" class="mx-2 hover:underline">Instagram</a>
  </div>
</footer>
