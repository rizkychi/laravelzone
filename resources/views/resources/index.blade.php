{{-- resources/views/resources/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl">Resources</h2>
      <form method="POST" action="{{ route('setting.resources.sync') }}">
        @csrf
        <x-primary-button>Sync Daftar Resource</x-primary-button>
      </form>
    </div>
  </x-slot>

  <div class="py-4">
    <form class="mb-3">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
             class="border rounded px-3 py-2">
    </form>

    <table class="w-full text-sm">
      <thead>
        <tr>
          <th class="text-left p-2">Name</th>
          <th class="text-left p-2">Route</th>
          <th class="text-left p-2">Method</th>
          <th class="text-left p-2">URI</th>
          <th class="text-left p-2">Active</th>
          <th class="text-left p-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($resources as $r)
          <tr class="border-t">
            <td class="p-2">{{ $r->name }}</td>
            <td class="p-2">{{ $r->route_name ?? $r->action }}</td>
            <td class="p-2">{{ $r->method }}</td>
            <td class="p-2">{{ $r->uri }}</td>
            <td class="p-2">
              <form method="POST" action="{{ route('setting.resources.update', $r) }}">
                @csrf @method('PUT')
                <input type="hidden" name="is_active" value="{{ $r->is_active ? 0 : 1 }}">
                <x-secondary-button>{{ $r->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</x-secondary-button>
              </form>
            </td>
            <td class="p-2 text-xs">{{ $r->permission_name }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-3">{{ $resources->links() }}</div>
  </div>
</x-app-layout>
