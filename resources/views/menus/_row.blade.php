{{-- resources/views/menus/_row.blade.php --}}
<div class="border rounded p-2" style="margin-left: {{ $level * 16 }}px;">
  <div class="flex items-center justify-between">
    <div>
      <div class="font-medium">{{ $menu->title }} {!! $menu->is_system ? '<span class="text-xs text-gray-500">(system)</span>' : '' !!}</div>
      <div class="text-xs text-gray-600">
        Route: {{ $menu->route_name ?? '-' }},
        URL: {{ $menu->url ?? '-' }},
        Permission: {{ $menu->permission_name ?? '-' }},
        Order: {{ $menu->order }},
        Active: {{ $menu->is_active ? 'Ya' : 'Tidak' }}
      </div>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('setting.menus.edit', $menu) }}" class="underline text-sm">Edit</a>
      <form method="POST" action="{{ route('setting.menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu?')">
        @csrf @method('DELETE')
        <button class="underline text-sm text-red-600">Hapus</button>
      </form>
    </div>
  </div>

  @foreach($menu->children as $c)
    @include('menus._row', ['menu' => $c, 'level' => $level+1])
  @endforeach
</div>
