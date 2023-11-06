<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Live' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Detail') }}
    </h2>
  </x-slot>
  <style>
    .page-break {
      page-break-after: always;
    }
  </style>
  <script>
    function printContent(el) {
      var fullbody = document.body.innerHTML;
      var printContent = document.getElementById(el).innerHTML;
      document.body.innerHTML = printContent;
      window.print();
      document.body.innerHTML = fullbody;
    }
  </script>
  <div class=" p-4 bg-white ">
    <livewire:kualifikasi-siswa></livewire:kualifikasi-siswa>
  </div>
</x-app-layout>