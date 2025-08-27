{{-- resources/views/menus/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl">Menu</h2>
      <div class="flex gap-2">
        <a href="{{ route('setting.menus.create') }}" class="underline">Buat Menu</a>
        <form method="POST" action="{{ route('setting.menus.sync') }}">
          @csrf
          <x-primary-button>Sync dari Resource</x-primary-button>
        </form>
      </div>
    </div>
  </x-slot>

  @if (session('success'))
    <div class="p-3 bg-green-50 border rounded mb-3">{{ session('success') }}</div>
  @endif

  <div class="space-y-2">
    @foreach ($menus as $m)
      @include('menus._row', ['menu' => $m, 'level' => 0])
    @endforeach
  </div>
</x-app-layout>
{{-- End of resources/views/menus/index.blade.php --}}