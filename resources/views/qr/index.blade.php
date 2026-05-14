<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Generate QR Siswa')

    <div>
      <h2 class="text-xl font-bold text-gray-800">
        Generate QR Siswa
      </h2>
      <p class="text-sm text-gray-500">
        List kelas periode aktif
      </p>
    </div>
  </x-slot>

  <div class="py-6 px-4">
    <div class="max-w-6xl mx-auto">

      {{-- ALERT --}}
      @foreach (['success' => 'green', 'error' => 'red'] as $msg => $color)
      @if(session($msg))
      <div class="mb-4 p-4 rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 text-{{ $color }}-700">
        {{ session($msg) }}
      </div>
      @endif
      @endforeach

      {{-- ACTION --}}
      <div class="bg-white rounded-2xl shadow-sm border p-5 mb-6 flex justify-between items-center">
        <div>
          <h3 class="font-semibold text-lg text-gray-800">
            QR Code Siswa
          </h3>
          <p class="text-sm text-gray-500">
            Generate massal QR siswa berdasarkan kelas
          </p>
        </div>

        <form action="{{ route('qr.generate.all') }}" method="POST">
          @csrf
          <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
            Generate Semua QR
          </button>
        </form>
      </div>

      {{-- TABLE --}}
      <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-gray-700">
              <tr>
                <th class="px-4 py-3 text-center w-16">No</th>
                <th class="px-4 py-3 text-left">Nama Kelas</th>
                <th class="px-4 py-3 text-center">Total Siswa</th>
                <th class="px-4 py-3 text-center w-52">Aksi</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
              @forelse($kelasList as $kelas)
              <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-center">
                  {{ $loop->iteration }}
                </td>

                <td class="px-4 py-3 font-medium text-gray-800">
                  {{ $kelas->nama_kelas }}
                </td>

                <td class="px-4 py-3 text-center text-gray-600">
                  {{ $kelas->total_siswa }} siswa
                </td>

                <td class="px-4 py-3">
                  <div class="flex justify-center gap-2">

                    <a href="{{ route('kartu.login.kelas', ['kelas' => $kelas->nama_kelas]) }}"
                      target="_blank"
                      class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs">
                      Download PDF
                    </a>

                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                  Tidak ada kelas pada periode aktif
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>