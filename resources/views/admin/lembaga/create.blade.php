<x-app-layout>
  <form method="POST" action="{{ route('lembaga.store') }}" class="p-6">
    @csrf
    @include('admin.lembaga.form')
  </form>
</x-app-layout>