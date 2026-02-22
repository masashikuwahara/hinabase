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

{{-- 身長順可視化用 --}}
<div
  x-data="heightLineup({
    maxPx: 260,
    members: @js($data['heightRankForJs']),
  })"
  class="space-y-3"
>
  <div class="flex items-center justify-between">
    <h2 class="text-lg font-bold">身長順</h2>
    <div class="flex gap-2">
      <button type="button" class="px-3 py-1 rounded border text-sm" @click="scrollBy(-320)">◀</button>
      <button type="button" class="px-3 py-1 rounded border text-sm" @click="scrollBy(320)">▶</button>
    </div>
  </div>

  <div class="relative border-b">
    <div class="absolute left-0 right-0 -bottom-[1px] h-px bg-gray-300"></div>

    <div x-ref="rail" class="flex gap-3 overflow-x-auto pb-3 snap-x snap-mandatory scroll-smooth">
      <template x-for="m in sorted" :key="m.id">
        <div class="snap-start shrink-0 w-28 relative">
          <span class="absolute top-0 right-0 translate-x-1 -translate-y-1
                      text-[10px] px-2 py-0.5 rounded-full border bg-white/90"
                :class="genBadgeClass(m.grade)"
                x-text="m.grade ? (m.grade + '期') : ''">
          </span>

          <div class="h-[300px] flex flex-col justify-end">
            <div class="mx-auto w-2 rounded bg-gray-200" :style="`height:${m.renderPx}px;`" aria-hidden="true"></div>

            <svg class="mx-auto -mt-2 fill-gray-800" :style="`height:${m.renderPx}px; width:auto;`" viewBox="0 0 80 160" aria-hidden="true">
              <circle cx="40" cy="22" r="14" />
              <rect x="28" y="36" width="24" height="54" rx="10" />
              <rect x="30" y="90" width="8" height="60" rx="4" />
              <rect x="42" y="90" width="8" height="60" rx="4" />
            </svg>
          </div>

          <div class="mt-2 text-center leading-tight">
            <div class="text-xs font-semibold" x-text="m.name"></div>

            <div class="mt-1 mx-auto h-[3px] w-14 rounded"
                :class="genColorClass(m.grade)">
            </div>

            <div class="text-xs text-gray-600 mt-1" x-text="m.height + 'cm'"></div>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>

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

{{-- 血液型順 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
    @click="open = (open === 'blood_type' ? null : 'blood_type')" :aria-expanded="open === 'blood_type'">
    <h2 class="text-lg font-semibold font-mont">血液型順</h2>
    <span class="text-sm text-gray-500" x-text="open === 'blood_type' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'blood_type'" x-collapse class="border-t p-4">
    <ol class="space-y-2">
      @foreach($data['bloodtypeRank'] as $m)
        <li class="flex items-center justify-between">
          <a href="{{ route('members.show', $m->id) }}" class="font-semibold hover:underline">
            {{ $m->name }}
          </a>
          <span class="font-num text-gray-700">{{ $m->blood_type }}</span>
        </li>
      @endforeach
    </ol>
  </div>
</section>

{{-- 出身地順 --}}
<section class="bg-white rounded-xl shadow">
  <button type="button" class="w-full flex items-center justify-between p-4"
   @click="open = (open === 'birthplace' ? null : 'birthplace')">
    <h2 class="text-lg font-semibold font-mont">出身地（都道府県）順</h2>
    <span class="text-sm text-gray-500" x-text="open === 'birthplace' ? '閉じる' : '開く'"></span>
  </button>

  <div x-show="open === 'birthplace'" x-collapse>
    <ul class="divide-y">
      @foreach($data['birthplaceRank'] as $m)
        <li class="flex items-center gap-3 px-4 py-3">
          {{-- 画像・名前・リンクは既存に合わせる --}}
          <a href="{{ route('members.show', $m->id) }}" class="font-semibold hover:underline">
            {{ $m->name }}
          </a>
          <span class="ml-auto text-sm text-slate-600">
            {{ $m->birthplace ?: '不明' }}
          </span>
        </li>
      @endforeach
    </ul>
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

@once
  @push('scripts')
    <script>
      window.heightLineup ??= function heightLineup({ members, maxPx }) {
        const list = (members ?? []).filter(m => typeof m.height === 'number');
        if (!list.length) {
          return {
            sorted: [],
            scrollBy(){},
            genColorClass(){ return 'bg-gray-300'; },
            genBadgeClass(){ return 'border-gray-200 text-gray-600'; },
          };
        }

        const heights = list.map(m => m.height);
        const maxCm = Math.max(...heights);
        const minCm = Math.min(...heights);

        const base = Math.max(160, Math.round(maxPx * 0.65));
        const span = Math.max(60, maxPx - base);

        const withRender = list.map(m => {
          const norm = (m.height - minCm) / Math.max(1, (maxCm - minCm));
          const renderPx = Math.round(base + norm * span);
          return { ...m, renderPx };
        });

        return {
          sorted: withRender.sort((a, b) => b.height - a.height),

          scrollBy(px) {
            this.$refs.rail?.scrollBy({ left: px, behavior: 'smooth' });
          },

          genColorClass(gen) {
            switch (gen) {
              case 1: return 'bg-rose-400';
              case 2: return 'bg-sky-400';
              case 3: return 'bg-emerald-400';
              case 4: return 'bg-amber-400';
              case 5: return 'bg-violet-400';
              default: return 'bg-gray-300';
            }
          },

          genBadgeClass(gen) {
            switch (gen) {
              case 1: return 'border-rose-300 text-rose-700';
              case 2: return 'border-sky-300 text-sky-700';
              case 3: return 'border-emerald-300 text-emerald-700';
              case 4: return 'border-amber-300 text-amber-700';
              case 5: return 'border-violet-300 text-violet-700';
              default: return 'border-gray-200 text-gray-600';
            }
          }
        };
      };
    </script>
  @endpush
@endonce