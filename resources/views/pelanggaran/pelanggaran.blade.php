<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Tambah Pelanggaran' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Daftar Pelanggaran') }}
    </h2>
  </x-slot>
  <div class="px-4 mt-4 ">
    <div class=" grid grid-cols-1 sm:grid-cols-4 gap-2">
      <div class=" bg-green-800 hover:bg-purple-500  text-white overflow-hidden shadow-sm sm:rounded-lg">

      </div>
    </div>
  </div>
</x-app-layout>