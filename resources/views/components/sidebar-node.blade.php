{{-- resources/views/components/sidebar-node.blade.php --}}
@php
  $href = $node['route_name'] ? route($node['route_name']) : ($node['url'] ?? '#');
  $isActive = $node['route_name']
    ? request()->routeIs($node['route_name'].'*')
    : (url()->current() === ($node['url'] ?? ''));
  $hasChildren = !empty($node['children']);
@endphp

<li>
  <div class="px-2 py-1 rounded {{ $isActive ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
    <a href="{{ $href }}" class="flex items-center justify-between">
      <span class="flex items-center gap-2">
        @if($node['icon'])
          <x-dynamic-component :component="$node['icon']" class="w-4 h-4" />
        @endif
        <span>{{ $node['title'] }}</span>
      </span>
      @if($hasChildren)<span class="text-xs">▾</span>@endif
    </a>
  </div>

  @if($hasChildren && $isActive)
    <ul class="ml-4 mt-1 space-y-1">
      @foreach($node['children'] as $child)
        @include('components.sidebar-node', ['node' => $child])
      @endforeach
    </ul>
  @endif
</li>
