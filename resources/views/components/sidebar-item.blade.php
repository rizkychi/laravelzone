{{-- resources/views/components/sidebar-item.blade.php --}}
@php
  $canSee = true;
  if ($menu->permission_name) {
    $canSee = auth()->user()?->can($menu->permission_name);
  }
@endphp

@if($menu->is_active && $canSee)
  <li>
    @php
      $hasChildren = $menu->children->where('is_active', true)->count() > 0;
      $href = $menu->route_name ? route($menu->route_name) : ($menu->url ?: '#');
    @endphp

    <div class="px-2 py-1 rounded hover:bg-gray-100">
      <a href="{{ $href }}" class="flex items-center justify-between">
        <span class="flex items-center gap-2">
          @if($menu->icon)
            <x-dynamic-component :component="$menu->icon" class="w-4 h-4" /> {{-- opsional pakai icon lib --}}
          @endif
          <span>{{ $menu->title }}</span>
        </span>
        @if($hasChildren)
          <span class="text-xs">▾</span>
        @endif
      </a>
    </div>

    @if($hasChildren)
      <ul class="ml-4 mt-1 space-y-1">
        @foreach($menu->children as $child)
          @include('components.sidebar-item', ['menu' => $child])
        @endforeach
      </ul>
    @endif
  </li>
@endif
