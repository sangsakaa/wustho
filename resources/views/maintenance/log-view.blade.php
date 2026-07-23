<x-app-layout>

  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-bold">
        {{ $filename }}
      </h2>

      <a href="{{ url()->previous() }}"
        class="bg-gray-600 text-white px-4 py-2 rounded">
        Kembali
      </a>
    </div>
  </x-slot>

  <div class="p-6">

    <div class="bg-black rounded-lg shadow">

      <pre class="text-green-400 text-sm p-4 overflow-auto"
        style="height:700px;">{{ $content }}</pre>

    </div>

  </div>

</x-app-layout>