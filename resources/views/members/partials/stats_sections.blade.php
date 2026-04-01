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
          <a href="{{ route('members.show', $m->slug) }}" class="font-semibold hover:underline">
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
    members: @js($data['heightRankForJs']),active: null
  })"
  class="space-y-3"
>
  <div class="flex items-center justify-between">
    <h2 class="text-lg font-bold">図で比較</h2>
    <div class="flex gap-2">
      <button type="button" class="px-3 py-1 rounded border text-sm" @click="scrollBy(-320)">◀</button>
      <button type="button" class="px-3 py-1 rounded border text-sm" @click="scrollBy(320)">▶</button>
    </div>
  </div>
  
  <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-600">
    <span class="font-semibold text-gray-700">凡例：</span>

    <span class="inline-flex items-center gap-1">
      <span class="inline-block h-2.5 w-2.5 rounded-sm" :class="genColorClass(1)"></span>
      <span>1期</span>
    </span>

    <span class="inline-flex items-center gap-1">
      <span class="inline-block h-2.5 w-2.5 rounded-sm" :class="genColorClass(2)"></span>
      <span>2期</span>
    </span>

    <span class="inline-flex items-center gap-1">
      <span class="inline-block h-2.5 w-2.5 rounded-sm" :class="genColorClass(3)"></span>
      <span>3期</span>
    </span>

    <span class="inline-flex items-center gap-1">
      <span class="inline-block h-2.5 w-2.5 rounded-sm" :class="genColorClass(4)"></span>
      <span>4期</span>
    </span>

    <span class="inline-flex items-center gap-1">
      <span class="inline-block h-2.5 w-2.5 rounded-sm" :class="genColorClass(5)"></span>
      <span>5期</span>
    </span>
  </div>

  <div class="relative" @click="active = null">
    <div class="absolute left-0 right-0 bottom-[72px] h-px bg-gray-300"></div>

    <div x-ref="rail" class="flex gap-3 overflow-x-auto pb-3 snap-x snap-mandatory scroll-smooth" @click.stop>
      <template x-for="m in sorted" :key="m.id">
        {{-- <div class="snap-start shrink-0 w-28 sm:w-32 relative"> --}}
        <div class="snap-start shrink-0 w-28 relative cursor-pointer"
            @click.stop="active = (active?.id === m.id ? null : m)"
            {{-- @click.outside="active = null" --}}
            role="button"
            tabindex="0"
            @keydown.enter="active = (active?.id === m.id ? null : m)"
            @keydown.space.prevent="active = (active?.id === m.id ? null : m)"
        >
          <span class="absolute top-1 right-1
                      text-[10px] px-2 py-0.5 rounded-full border bg-white/90"
                :class="genBadgeClass(m.grade)"
                x-text="m.grade ? (m.grade + '期') : ''">
          </span>
          <div
            x-show="active?.id === m.id"
            x-transition
            class="absolute left-1/2 -translate-x-1/2 top-8 z-20
                  w-38 rounded-lg border bg-white shadow-lg p-2 text-xs"
          >
            <div class="font-semibold text-gray-900" x-text="m.name"></div>
            <div class="mt-1 text-gray-700">
              <span class="text-gray-500">身長</span>：
              <span class="font-num" x-text="m.height + 'cm'"></span>
            </div>
            <div class="mt-0.5 text-gray-700">
              <span class="text-gray-500">期</span>：
              <span x-text="m.grade ? (m.grade + '期') : '不明'"></span>
            </div>

            <div class="mt-2 flex justify-end">
              <a :href="`/members/${m.slug}`"
                class="text-blue-600 hover:underline"
                @click.stop
              >詳細へ</a>
            </div>
          </div>
          <div class="h-[300px] flex flex-col justify-end">
          <img
            :src="`/storage/images/avatars/members/${m.id}.png`"
            :style="`height:${m.renderPx}px; width:100%; object-fit:contain; object-position:bottom center;`"
            class="mx-auto block select-none"
            alt=""
            loading="lazy"
            decoding="async"
            onerror="this.onerror=null; this.src='{{ asset('storage/images/avatars/base.png') }}';"
          />
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
          <a href="{{ route('members.show', $m->slug) }}" class="font-semibold hover:underline">
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

{{-- 誕生月別 --}}
<section class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <button
        type="button"
        class="w-full flex items-center justify-between px-4 py-4 text-left hover:bg-gray-50 transition"
        @click="{{ $openKey }} = {{ $openKey }} === 'birthday-month' ? '' : 'birthday-month'">
        <span class="text-lg font-bold text-gray-900">誕生月別</span>
        <span class="text-sm text-gray-500" x-text="{{ $openKey }} === 'birthday-month' ? '閉じる' : '開く'"></span>
    </button>

    <div x-show="{{ $openKey }} === 'birthday-month'" x-collapse class="border-t bg-gray-50 px-4 py-4">
        <div class="space-y-6">
            @foreach ($data['birthdayMonthGroups'] as $month => $members)
                <div>
                    <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800">{{ $month }}月</h3>
                        <span class="text-sm text-gray-500">{{ $members->count() }}名</span>
                    </div>

                    @if ($members->isNotEmpty())
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($members as $member)
                                <a href="{{ route('members.show', $member->slug) }}"
                                   class="rounded-xl border border-gray-200 bg-white px-3 py-2 hover:bg-sky-50 hover:border-sky-200 transition">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="font-medium text-gray-900">{{ $member->name }}</span>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($member->birthday)->format('n/j') }}
                                            @if(!is_null($member->age_2026))
                                                （{{ $member->age_2026 }}歳）
                                            @endif
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500">該当メンバーはいません。</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 血液型順 --}}
<section class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <button
        type="button"
        class="w-full flex items-center justify-between px-4 py-4 text-left hover:bg-gray-50 transition"
        @click="{{ $openKey }} = {{ $openKey }} === 'bloodtype' ? '' : 'bloodtype'">
        <span class="text-lg font-bold text-gray-900">血液型別</span>
        <span class="text-sm text-gray-500" x-text="{{ $openKey }} === 'bloodtype' ? '閉じる' : '開く'"></span>
    </button>

    <div x-show="{{ $openKey }} === 'bloodtype'" x-collapse class="border-t bg-gray-50 px-4 py-4">
        <div class="space-y-6">
            @foreach ($data['bloodtypeGroups'] as $type => $members)
                <div>
                    <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800">{{ $type }}</h3>
                        <span class="text-sm text-gray-500">{{ $members->count() }}名</span>
                    </div>

                    @if ($members->isNotEmpty())
                        <div class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($members as $member)
                                <a href="{{ route('members.show', $member->slug) }}"
                                   class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 hover:bg-sky-50 hover:border-sky-200 hover:text-sky-700 transition">
                                    {{ $member->name }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500">該当メンバーはいません。</p>
                    @endif
                </div>
            @endforeach
        </div>
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
          <a href="{{ route('members.show', $m->slug) }}" class="font-semibold hover:underline">
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
          <a href="{{ route('members.show', $row->slug) }}" class="font-semibold hover:underline">
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
          <a href="{{ route('members.show', $row->slug) }}" class="font-semibold hover:underline">
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
          <a href="{{ route('members.show', $row->slug) }}" class="font-semibold hover:underline">
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
          active: null,
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