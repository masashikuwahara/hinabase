{{-- 身長順 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button"
    class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'height' ? null : 'height')"
    :aria-expanded="open === 'height'">
    <h2 class="text-lg font-semibold font-mont">身長順</h2>
    <span class="text-sm text-gray-500" x-text="open === 'height' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'height'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['heightRank'] as $m)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $m->id) }}" class="font-semibold hover:underline">
            {{ $m->name }}
          </a>
          <span class="font-num text-gray-700">{{ $m->height }}cm</span>
        </li>
      @endforeach
    </ol>
  </div>
</section>

{{-- 誕生日順 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'birthday' ? null : 'birthday')" :aria-expanded="open === 'birthday'">
    <h2 class="text-lg font-semibold font-mont">誕生日順</h2>
    <span class="text-sm text-gray-500" x-text="open === 'birthday' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'birthday'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['birthdayRank'] as $m)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $m->id) }}" class="font-semibold hover:underline">
            {{ $m->name }}
          </a>
          <span class="font-num text-gray-700">
            {{ optional($m->birthday)->format('Y/m/d') }}
            ({{ $m->age_2026 !== null ? $m->age_2026.'歳' : '年齢不明' }})
          </span>
        </li>
      @endforeach
    </ol>
  </div>
</section>

{{-- 参加曲数 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'songs' ? null : 'songs')" :aria-expanded="open === 'songs'">
    <h2 class="text-lg font-semibold font-mont">参加曲数</h2>
    <span class="text-sm text-gray-500" x-text="open === 'songs' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'songs'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['songCountRank'] as $row)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $row->id) }}" class="font-semibold hover:underline">
            {{ $row->name }}
          </a>
          <span class="font-num text-gray-700">{{ (int)$row->song_count }}</span>
        </li>
      @endforeach
    </ol>
  </div>
</section>

{{-- センター回数 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'center' ? null : 'center')" :aria-expanded="open === 'center'">
    <h2 class="text-lg font-semibold font-mont">センター回数</h2>
    <span class="text-sm text-gray-500" x-text="open === 'center' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'center'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['centerCountRank'] as $row)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $row->id) }}" class="font-semibold hover:underline">
            {{ $row->name }}
          </a>
          <span class="font-num text-gray-700">{{ (int)$row->center_count }}</span>
        </li>
      @endforeach
    </ol>
  </div>
</section>

{{-- 選抜回数 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'title' ? null : 'title')" :aria-expanded="open === 'title'">
    <h2 class="text-lg font-semibold font-mont">選抜回数</h2>
    <span class="text-sm text-gray-500" x-text="open === 'title' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'title'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['titleSongCountRank'] as $row)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $row->id) }}" class="font-semibold hover:underline">
            {{ $row->name }}
          </a>
          <span class="font-num text-gray-700">{{ (int)$row->titlesong_count }}</span>
        </li>
      @endforeach
    </ol>
  </div>
</section>
