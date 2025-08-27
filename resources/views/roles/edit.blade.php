{{-- resources/views/roles/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Edit Role: {{ $role->name }}</h2>
  </x-slot>

  <form method="POST" action="{{ route('roles.update', $role) }}" class="py-4">
    @csrf @method('PUT')

    <div class="grid md:grid-cols-2 gap-4">
      @foreach($resources as $r)
        <label class="flex items-start gap-2 border p-2 rounded">
          <input type="checkbox" name="permissions[]" value="{{ $r->permission_name }}"
                 {{ in_array($r->permission_name, $rolePerms) ? 'checked' : '' }}>
          <div>
            <div class="font-medium">{{ $r->name }}</div>
            <div class="text-xs text-gray-600">{{ $r->route_name ?? $r->action }} — {{ $r->method }}</div>
          </div>
        </label>
      @endforeach
    </div>

    <div class="mt-4">
      <x-primary-button>Simpan</x-primary-button>
      <a class="ml-2 underline" href="{{ route('roles.index') }}">Kembali</a>
    </div>
  </form>
</x-app-layout>
