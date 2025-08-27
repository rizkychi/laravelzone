{{-- resources/views/components/sidebar.blade.php --}}
<aside class="w-64 border-r min-h-screen p-3">
  <nav>
    <ul class="space-y-1">
      @foreach($tree as $item)
        @include('components.sidebar-node', ['node' => $item])
      @endforeach
    </ul>
  </nav>
</aside>
