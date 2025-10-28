<footer class="bg-gradient-to-t from-[#7cc7e8] to-[#9cdcf2] text-white text-center py-10 mt-16">
  <!-- サイトコピー -->
  <p class="text-sm md:text-base font-semibold tracking-wide mb-6">
    &copy; {{ date('Y') }} HINABASE. All rights reserved.
  </p>

  <!-- メニュー -->
  <div class="flex flex-wrap justify-center items-center gap-x-6 gap-y-4 text-sm md:text-base leading-relaxed">
    <a href="{{ route('members.index') }}" class="hover:underline hover:text-white/90 transition-colors duration-200">メンバー一覧</a>
    <a href="{{ route('songs.index') }}" class="hover:underline hover:text-white/90 transition-colors duration-200">楽曲一覧</a>
    <a href="{{ route('popular.index') }}" class="hover:underline hover:text-white/90 transition-colors duration-200">人気ページTOP20</a>
    <a href="{{ route('timeline.index') }}" class="hover:underline hover:text-white/90 transition-colors duration-200">日向坂46ヒストリー</a>
    <a href="{{ route('others.index') }}" class="hover:underline hover:text-white/90 transition-colors duration-200">その他</a>
    <a href="https://x.com/sakamichiiwlu4e" target="_blank" rel="noopener noreferrer" class="hover:underline hover:text-white/90 transition-colors duration-200">X</a>
    <a href="https://x.gd/I7a73" target="_blank" rel="noopener noreferrer" class="hover:underline hover:text-white/90 transition-colors duration-200">Instagram</a>
  </div>

</footer>

