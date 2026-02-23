<nav class="text-sm text-gray-600 mt-4" aria-label="パンくず">
  <ol class="flex flex-wrap gap-x-2">
    @foreach($breadcrumbs as $i => $bc)
      <li>
        @if(!empty($bc['url']) && $i !== count($breadcrumbs)-1)
          <a href="{{ $bc['url'] }}" class="hover:underline">{{ $bc['label'] }}</a>
        @else
          <span aria-current="page">{{ $bc['label'] }}</span>
        @endif
      </li>
      @if($i !== count($breadcrumbs)-1)
        <li aria-hidden="true">›</li>
      @endif
    @endforeach
  </ol>
</nav>