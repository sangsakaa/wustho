<x-app-layout>
  <div class="max-w-md mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-xl p-6 text-center">

      <h1 class="text-xl font-bold mb-2">QR Code Siswa</h1>
      
      </td>
      <p class="font-semibold text-gray-700">
        {{ $siswa->nama_siswa }}
      </p>

      <p class="text-sm text-gray-500 mb-4">
        NIS: {{ $siswa->nis->nis }}
      </p>

      <div class="flex justify-center">
        {!! $qr !!}
      </div>

      <button onclick="window.print()"
        class="mt-5 bg-blue-600 text-white px-4 py-2 rounded-lg">
        Print QR
      </button>
    </div>
  </div>
</x-app-layout>