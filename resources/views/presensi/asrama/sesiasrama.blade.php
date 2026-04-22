<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Presensi')
    <h2 class="font-semibold text-xl">
      Sesi Presensi Asrama
    </h2>
  </x-slot>

  <div class="p-4 space-y-4">

    {{-- FORM INPUT --}}
    @can('show post')
    <div class="bg-white rounded-xl shadow p-4">
      <form action="/sesiasrama" method="post" class="grid md:grid-cols-5 gap-3 text-sm">
        @csrf

        <input type="date" name="tanggal"
          class="border rounded px-2 py-1"
          value="{{ $tanggal->toDateString() }}">

        <select name="periode_id" class="border rounded px-2 py-1">
          @foreach($periode as $peri)
          <option value="{{$peri->id}}">
            {{$peri->periode}} {{$peri->ket_semester}}
          </option>
          @endforeach
        </select>

        <select name="asramasiswa_id" class="border rounded px-2 py-1">
          <option value="">Pilih Asrama</option>
          @foreach($asramasiswa as $asrama)
          <option value="{{$asrama->id}}">
            {{$asrama->nama_asrama}}
          </option>
          @endforeach
        </select>

        <select name="kegiatan_id" class="border rounded px-2 py-1">
          <option value="">Pilih Kegiatan</option>
          @foreach($kegiatan as $k)
          <option value="{{$k->id}}">
            {{$k->kegiatan}}
          </option>
          @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded px-3">
          + Sesi
        </button>
      </form>
    </div>
    @endcan

    {{-- FILTER + NAV --}}
    <div class="bg-white rounded-xl shadow p-4 flex flex-col md:flex-row md:justify-between gap-3">

      <form method="GET" class="flex gap-2">
        <input type="date" name="tanggal"
          value="{{ $tanggal->toDateString() }}"
          class="border rounded px-2 py-1">

        <button class="bg-blue-600 text-white px-3 rounded">
          Cari
        </button>
      </form>

      <div class="flex gap-2">
        <a href="/asrama" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
          Kembali
        </a>

        <a href="/kegiatan" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded">
          Kegiatan
        </a>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow p-4">

      <div class="overflow-x-auto">
        <table class="w-full text-sm border">

          <thead class="bg-gray-100 text-xs uppercase sticky top-0">
            <tr>
              <th class="border px-2 py-2">No</th>
              <th class="border px-2">Asrama</th>
              <th class="border px-2">Tanggal</th>
              <th class="border px-2">Periode</th>
              <th class="border px-2">Kegiatan</th>
              <th class="border px-2">Rekap</th>
              <th class="border px-2">Status</th>
              <th class="border px-2">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($Datasesiasrama as $item)
            <tr class="hover:bg-gray-50 even:bg-gray-50">

              <td class="border text-center">{{ $loop->iteration }}</td>

              {{-- ASRAMA --}}
              <td class="border text-center">
                <a href="/sesiasrama/{{$item->id}}">
                  <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                        {{ $item->type_asrama == 'Putri' ? 'bg-pink-500' : 'bg-blue-500' }}">
                    {{ $item->nama_asrama }}
                  </span>
                </a>
              </td>

              {{-- TANGGAL --}}
              <td class="border text-center">
                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM Y') }}
              </td>

              {{-- PERIODE --}}
              <td class="border text-center text-xs">
                {{ $item->periode }} <br>
                <span class="text-gray-500">{{ $item->ket_semester }}</span>
              </td>

              {{-- KEGIATAN --}}
              <td class="border text-center">
                {{ $item->kegiatan }}
              </td>

              {{-- REKAP --}}
              <td class="border text-xs px-2">
                <div class="space-y-1">
                  <div>Total: <b>{{ $item->SesiAsrama->count() }}</b></div>
                  <div class="text-green-600">H: {{ $item->SesiAsrama->where('keterangan','hadir')->count() }}</div>
                  <div class="text-yellow-600">I: {{ $item->SesiAsrama->where('keterangan','izin')->count() }}</div>
                  <div class="text-blue-600">S: {{ $item->SesiAsrama->where('keterangan','sakit')->count() }}</div>
                  <div class="text-red-600">A: {{ $item->SesiAsrama->where('keterangan','alfa')->count() }}</div>
                </div>
              </td>

              {{-- STATUS --}}
              <td class="border text-center">
                @if($item->SesiAsrama->count() == 0)
                <span class="text-red-500">✖</span>
                @else
                <span class="text-green-500">✔</span>
                @endif
              </td>

              {{-- AKSI --}}
              <td class="border text-center">
                <form action="/sesiasrama/{{$item->id}}" method="post">
                  @csrf
                  @method('delete')
                  <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                    Hapus
                  </button>
                </form>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-gray-400">
                Belum ada sesi
              </td>
            </tr>
            @endforelse
          </tbody>

        </table>
      </div>

    </div>

    {{-- INFO --}}
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
      <p class="font-semibold">Keterangan:</p>
      <p class="text-sm">
        Pelaporan kehadiran diisi oleh <b>Ketua Asrama / Jampeng</b>
      </p>
    </div>

  </div>
</x-app-layout>