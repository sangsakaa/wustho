<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Presensi')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Sesi Presensi Asrama
        </h2>
        <p class="text-sm text-gray-500">
          Kelola sesi presensi santri berdasarkan asrama & kegiatan
        </p>
      </div>
    </div>
  </x-slot>

  <div class="p-6 space-y-6">

    {{-- FORM --}}
    @can('show post')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
      <h3 class="font-semibold text-gray-700 mb-4">Tambah Sesi Baru</h3>

      <form action="/sesiasrama" method="POST" class="grid md:grid-cols-5 gap-3">
        @csrf

        <input type="date"
          name="tanggal"
          value="{{ $tanggal->toDateString() }}"
          class="rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500">

        <select name="periode_id"
          class="rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500">
          @foreach($periode as $peri)
          <option value="{{ $peri->id }}">
            {{ $peri->periode }} {{ $peri->ket_semester }}
          </option>
          @endforeach
        </select>

        <select name="asramasiswa_id"
          class="rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500">
          <option value="">Pilih Asrama</option>
          @foreach($asramasiswa as $asrama)
          <option value="{{ $asrama->id }}">
            {{ $asrama->nama_asrama }}
          </option>
          @endforeach
        </select>

        <select name="kegiatan_id"
          class="rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500">
          <option value="">Pilih Kegiatan</option>
          @foreach($kegiatan as $k)
          <option value="{{ $k->id }}">
            {{ $k->kegiatan }}
          </option>
          @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2 font-medium shadow-sm">
          + Tambah
        </button>
      </form>
    </div>
    @endcan

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col md:flex-row md:justify-between gap-4">

      <form method="GET" class="flex gap-3">
        <input type="date"
          name="tanggal"
          value="{{ $tanggal->toDateString() }}"
          class="rounded-xl border-gray-200">

        <button class="bg-slate-800 hover:bg-slate-900 text-white px-4 rounded-xl">
          Filter
        </button>
      </form>

      <div class="flex gap-2">
        <form action="{{ route('sesiasrama.generate') }}" method="POST" class="flex gap-2">
          @csrf

          <input type="date"
            name="tanggal"
            value="{{ $tanggal->toDateString() }}"
            class="rounded-xl border-gray-200">

          <button
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl">
            Generate Semua Sesi
          </button>
        </form>
        <a href="/asrama"
          class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700">
          ← Kembali
        </a>

        <a href="/kegiatan"
          class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white">
          Kegiatan
        </a>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

      <div class="px-5 py-4 border-b bg-gray-50">
        <h3 class="font-semibold text-gray-700">Daftar Sesi Presensi</h3>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">

          <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
            <tr>
              <th class="px-4 py-3">No</th>
              <th class="px-4 py-3">Asrama</th>
              <th class="px-4 py-3">Tanggal</th>
              <th class="px-4 py-3">Periode</th>
              <th class="px-4 py-3">Kegiatan</th>
              <th class="px-4 py-3">Rekap</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">
            @forelse ($Datasesiasrama as $item)
            <tr class="hover:bg-slate-50 transition">

              <td class="px-4 py-3 text-center">
                {{ $loop->iteration }}
              </td>

              <td class="px-4 py-3 text-center">
                <a href="/sesiasrama/{{$item->id}}">
                  <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                        {{ $item->type_asrama == 'Putri' ? 'bg-pink-500' : 'bg-blue-500' }}">
                    {{ $item->nama_asrama }}
                  </span>
                </a>
              </td>

              <td class="px-4 py-3 text-center">
                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM Y') }}
              </td>

              <td class="px-4 py-3 text-center text-xs">
                <div>{{ $item->periode }}</div>
                <span class="text-gray-400">{{ $item->ket_semester }}</span>
              </td>

              <td class="px-4 py-3 text-center font-medium">
                {{ $item->kegiatan }}
              </td>

              <td class="px-4 py-3">
                <div class="grid grid-cols-2 gap-1 text-xs">
                  <span>Total: <b>{{ $item->SesiAsrama->count() }}</b></span>
                  <span class="text-green-600">H: {{ $item->SesiAsrama->where('keterangan','hadir')->count() }}</span>
                  <span class="text-yellow-600">I: {{ $item->SesiAsrama->where('keterangan','izin')->count() }}</span>
                  <span class="text-blue-600">S: {{ $item->SesiAsrama->where('keterangan','sakit')->count() }}</span>
                  <span class="text-red-600">A: {{ $item->SesiAsrama->where('keterangan','alfa')->count() }}</span>
                </div>
              </td>

              <td class="px-4 py-3 text-center">
                @if($item->SesiAsrama->count() == 0)
                <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-semibold">
                  Belum
                </span>
                @else
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-semibold">
                  Selesai
                </span>
                @endif
              </td>

              <td class="px-4 py-3 text-center">
                <form action="/sesiasrama/{{$item->id}}" method="POST">
                  @csrf
                  @method('DELETE')

                  <button
                    onclick="return confirm('Hapus sesi ini?')"
                    class="px-3 py-1 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-8 text-gray-400">
                Belum ada sesi presensi
              </td>
            </tr>
            @endforelse
          </tbody>

        </table>
      </div>
    </div>

    {{-- INFO --}}
    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">
      <h4 class="font-semibold text-blue-800">Informasi</h4>
      <p class="text-sm text-blue-700 mt-1">
        Pelaporan kehadiran diisi oleh
        <span class="font-semibold">Ketua Asrama / Jampeng</span>
      </p>
    </div>

  </div>
</x-app-layout>