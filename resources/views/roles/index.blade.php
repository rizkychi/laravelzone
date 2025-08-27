{{-- resources/views/roles/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Roles</h2>
  </x-slot>

  <div class="py-4">
    <ul class="list-disc pl-6">
      @foreach($roles as $role)
        <li class="mb-2">
          <a class="underline" href="{{ route('roles.edit', $role) }}">{{ $role->name }}</a>
        </li>
      @endforeach
    </ul>
  </div>
</x-app-layout>
