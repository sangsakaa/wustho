<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Generate QR Siswa
    </h2>
  </x-slot>

  <div class="py-6 px-4">
    <div class="max-w-7xl mx-auto">

      @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
        {{ session('error') }}
      </div>
      @endif

      {{-- HEADER --}}
      <div class="bg-white shadow rounded-xl p-5 mb-6">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-xl font-bold text-gray-800">
              QR Code Siswa
            </h1>
            <p class="text-sm text-gray-500">
              Generate QR siswa periode aktif
            </p>
          </div>

          <form action="{{ route('qr.generate.all') }}" method="POST">
            @csrf
            <button
              class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
              Generate Semua
            </button>
          </form>
        </div>
      </div>

      {{-- GRID --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

        @foreach ($siswas as $siswa)
        @php
        $nis = $siswa->NisTerakhir->nis ?? null;
        $qrPath = public_path('qrcodes/' . $nis . '.png');
        $exists = $nis && file_exists($qrPath);
        @endphp

        <div class="bg-white rounded-xl shadow border p-4">
          <div class="text-center mb-4">
            <h3 class="font-semibold text-gray-800">
              {{ $siswa->nama_siswa }}
            </h3>

            <p class="text-sm text-gray-500">
              {{ $nis ?? '-' }}
            </p>
          </div>

          <div class="flex justify-center mb-4">
            @if($exists)
            <img src="{{ asset('qrcodes/' . $nis . '.png') }}"
              class="w-44 h-44 rounded-lg border">
            @else
            <div class="w-44 h-44 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-gray-400 text-sm">
              Belum Generate
            </div>
            @endif
          </div>

          <form action="{{ route('qr.siswa', $siswa->id) }}" method="POST">
            @csrf
            <button
              class="w-full px-3 py-2 {{ $exists ? 'bg-gray-500' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-lg text-sm">
              {{ $exists ? 'Generate Ulang' : 'Generate QR' }}
            </button>
          </form>
        </div>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $siswas->links() }}
      </div>
    </div>
  </div>
</x-app-layout>