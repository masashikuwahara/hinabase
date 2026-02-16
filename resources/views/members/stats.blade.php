@extends('layouts.main')

@section('title', '日向坂46メンバー統計・ランキング | HINABASE')
@section('meta_description', '日向坂46メンバーの身長順、誕生日順、参加曲数、センター回数、選抜回数を一覧化。')

@section('content')
<main class="container mx-auto px-4 mt-6"
      x-data="{
        group: 'current',
        open: ''
      }">

  <h1 class="text-2xl font-bold font-mont">日向坂46メンバー 統計・ランキング</h1>
  <p class="text-sm text-gray-600 mt-1">身長・誕生日・参加曲数・センター回数・選抜回数をまとめてチェック。</p>
  <p class="text-sm text-gray-600 mt-1">※2026年2月現在の情報です。</p>

  {{-- 切替ボタン --}}
  <div class="mt-4 flex flex-wrap gap-2">
    <button type="button"
      @click="group='current'; open=''"
      class="px-4 py-1.5 rounded-full text-sm transition"
      :class="group==='current' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'">
      現役
    </button>

    <button type="button"
      @click="group='graduated'; open=''"
      class="px-4 py-1.5 rounded-full text-sm transition"
      :class="group==='graduated' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'">
      卒業
    </button>

    <button type="button"
      @click="group='all'; open=''"
      class="px-4 py-1.5 rounded-full text-sm transition"
      :class="group==='all' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'">
      全員
    </button>
  </div>

  {{-- 内容 --}}
  <div class="mt-6 space-y-3">
    <div x-show="group==='current'" class="mt-4 space-y-3">
      @include('members.partials.stats_sections', ['data' => $current, 'openKey' => 'open'])
    </div>

    <div x-show="group==='graduated'" class="mt-4 space-y-3">
      @include('members.partials.stats_sections', ['data' => $graduated, 'openKey' => 'open'])
    </div>

    <div x-show="group==='all'" class="mt-4 space-y-3">
      @include('members.partials.stats_sections', ['data' => $all, 'openKey' => 'open'])
    </div>
  </div>
</main>
@endsection
