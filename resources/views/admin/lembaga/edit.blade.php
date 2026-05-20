<x-app-layout>
  <form method="POST"
    action="{{ route('lembaga.update', $lembaga) }}"
    class="p-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.lembaga.form')
  </form>
</x-app-layout>