<x-app-layout>
  <x-slot name="header">
    <div>
      <h2 class="text-xl font-bold">
        Monitor Absensi - {{ $sesi->kelasmi->nama_kelas ?? '-' }}
      </h2>
      <p class="text-sm text-gray-500">
        {{ \Carbon\Carbon::parse($sesi->tgl)->format('d M Y') }}
      </p>
    </div>
  </x-slot>

  @php
  $total = $data->count();
  $hadir = $data->where('status','hadir')->count();
  $belum = $data->where('status','belum')->count();
  @endphp

  <div class="p-4 md:p-6 space-y-4">

    {{-- BUTTON BACK --}}
    <div>
      <a href="{{ url('/sesikelas') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
        ← Kembali
      </a>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-3 gap-3">
      <div class="bg-white p-4 rounded shadow text-center">
        <div class="text-gray-500 text-sm">Total</div>
        <div class="text-2xl font-bold">{{ $total }}</div>
      </div>

      <div class="bg-white p-4 rounded shadow text-center">
        <div class="text-gray-500 text-sm">Hadir</div>
        <div class="text-2xl font-bold text-green-600">{{ $hadir }}</div>
      </div>

      <div class="bg-white p-4 rounded shadow text-center">
        <div class="text-gray-500 text-sm">Belum</div>
        <div class="text-2xl font-bold text-red-600">{{ $belum }}</div>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">

          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="p-3 w-12">No</th>
              <th class="p-3 text-left">Nama</th>
              <th class="p-3 w-32">NIS</th>
              <th class="p-3 w-32">Status</th>
              <th class="p-3 w-48">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($data as $row)
            <tr class="border-t hover:bg-gray-50 text-center">

              <td class="p-3">{{ $loop->iteration }}</td>

              <td class="p-3 text-left font-medium text-gray-800  w-[300px]">
                {{ $row['nama'] }}
              </td>

              <td class="p-3 text-gray-600">
                {{ $row['nis'] }}
              </td>

              <td class="p-3">
                @if($row['status'] == 'hadir')
                <span class="text-green-600 font-semibold">Hadir</span>
                @elseif($row['status'] == 'belum')
                <span class="text-red-600 font-semibold">Belum</span>
                @else
                <span class="text-gray-600 capitalize">{{ $row['status'] }}</span>
                @endif
              </td>

              <td class="p-3">
                <form action="{{ route('absen.manual') }}" method="POST" class="flex gap-1 justify-center flex-wrap">
                  @csrf

                  <input type="hidden" name="pesertakelas_id" value="{{ $row['peserta_id'] }}">
                  <input type="hidden" name="sesikelas_id" value="{{ $sesi->id }}">

                  <button name="status" value="hadir"
                    class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                    Hadir
                  </button>

                  <button name="status" value="izin"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                    Izin
                  </button>

                  <button name="status" value="sakit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                    Sakit
                  </button>

                  <button name="status" value="alfa"
                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                    Alfa
                  </button>

                </form>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="5" class="p-6 text-center text-gray-500">
                Tidak ada data peserta
              </td>
            </tr>
            @endforelse
          </tbody>

        </table>
      </div>
    </div>

  </div>
</x-app-layout>