<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Detail Mapel')

    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800">
        📘 Detail Mata Pelajaran
      </h2>

      <a href="/mapel"
        class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm shadow">
        ← Kembali
      </a>
    </div>
  </x-slot>

  <div class=" p-4">
    <div class="bg-white shadow-xl rounded-2xl p-6 max-w-5xl mx-auto space-y-8">

      {{-- ================= HEADER ================= --}}
      <div class="text-center border-b pb-4">
        <h3 class="text-2xl font-bold text-blue-700">
          {{ $mapel->mapel }}
        </h3>
        <p class="text-gray-400 text-sm">
          Informasi lengkap mata pelajaran
        </p>
      </div>

      {{-- ================= INFO MAPEL ================= --}}
      <div>
        <h4 class="text-sm font-semibold text-gray-600 mb-3">📋 Informasi Mapel</h4>

        <table class="w-full text-sm border rounded-xl overflow-hidden">
          <tbody class="divide-y">
            <tr>
              <td class="w-1/3 px-4 py-3 bg-gray-50 font-medium">Nama Mapel</td>
              <td class="px-4 py-3">{{ $mapel->mapel }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 bg-gray-50 font-medium">Nama Kitab</td>
              <td class="px-4 py-3">{{ $mapel->nama_kitab ?? '-' }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 bg-gray-50 font-medium">Kelas</td>
              <td class="px-4 py-3">{{ $mapel->kelas->kelas ?? '-' }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 bg-gray-50 font-medium">Periode</td>
              <td class="px-4 py-3">
                {{ $mapel->periode->periode ?? '-' }}
                ({{ $mapel->periode->semester->ket_semester ?? '-' }})
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- ================= GURU ================= --}}
      @php
      $guruList = $mapel->daftar_jadwal
      ->pluck('guru.nama_guru')
      ->filter()
      ->unique()
      ->values();
      @endphp

      <div>
        <h4 class="text-sm font-semibold text-gray-600 mb-3">👨‍🏫 Guru Pengajar</h4>

        <table class="w-full text-sm border rounded-xl overflow-hidden">
          <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
            <tr>
              <th class="px-4 py-2 text-left w-12">No</th>
              <th class="px-4 py-2 text-left">Nama Guru</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($guruList as $g)
            <tr>
              <td class="px-4 py-2">{{ $loop->iteration }}</td>
              <td class="px-4 py-2 font-medium text-gray-700">{{ $g }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="2" class="px-4 py-3 text-gray-400 italic text-center">
                Belum ada guru
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- ================= JADWAL ================= --}}
      @php $unique = []; @endphp

      <div>
        <h4 class="text-sm font-semibold text-gray-600 mb-3">🗓️ Detail Jadwal</h4>

        <table class="w-full text-sm border rounded-xl overflow-hidden">
          <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
            <tr>
              <th class="px-4 py-2 text-left w-12">No</th>
              <th class="px-4 py-2 text-left">Guru</th>
              <th class="px-4 py-2 text-left">Hari</th>
              <th class="px-4 py-2 text-left">Kelas</th>
            </tr>
          </thead>

          <tbody class="divide-y">
            @forelse($mapel->daftar_jadwal as $dj)
            @php
            $key = ($dj->guru_id ?? '') . '-' . ($dj->jadwal->kelasmi_id ?? '') . '-' . ($dj->jadwal->hari ?? '');
            @endphp

            @if(!in_array($key, $unique))
            @php $unique[] = $key; @endphp
            <tr>
              <td class="px-4 py-2">{{ count($unique) }}</td>
              <td class="px-4 py-2 font-medium">{{ $dj->guru->nama_guru ?? '-' }}</td>
              <td class="px-4 py-2">{{ $dj->jadwal->hari ?? '-' }}</td>
              <td class="px-4 py-2">{{ $dj->jadwal->kelasmi->nama_kelas ?? '-' }}</td>
            </tr>
            @endif
            @empty
            <tr>
              <td colspan="4" class="px-4 py-3 text-gray-400 italic text-center">
                Belum ada jadwal
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- ================= ACTION ================= --}}
      <div class="flex justify-end gap-3 border-t pt-4">
        <a href="/mapel/{{ $mapel->id }}/edit"
          class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-sm shadow">
          ✏️ Edit
        </a>

        <form action="/mapel/{{ $mapel->id }}" method="POST"
          onsubmit="return confirm('Yakin hapus data ini?')">
          @csrf
          @method('DELETE')

          <button
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
            🗑️ Hapus
          </button>
        </form>
      </div>

    </div>
  </div>
</x-app-layout>