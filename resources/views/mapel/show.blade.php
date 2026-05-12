<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Detail Mapel')

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
      <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
        📘 Detail Mata Pelajaran
      </h2>

      <a href="/mapel"
        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl text-sm shadow">
        ← Kembali
      </a>
    </div>
  </x-slot>

  <div class="p-4 md:p-6 space-y-6 max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-white dark:bg-gray-900 border rounded-2xl shadow p-6 text-center">
      <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400">
        {{ $mapel->mapel }}
      </h3>
      <p class="text-sm text-gray-500 mt-1">
        Detail kurikulum & pengampu
      </p>
    </div>

    {{-- GRID --}}
    <div class="grid md:grid-cols-2 gap-6">

      {{-- ================= PENGAMPU ================= --}}
      <div x-data="{ open: false }"
        class="bg-white dark:bg-gray-900 border rounded-2xl shadow p-5">

        <div class="flex justify-between items-center mb-4">
          <h4 class="font-semibold text-gray-700 dark:text-gray-200">
            👨‍🏫 Guru Pengampu
          </h4>

          <div class="flex gap-2">

            <form action="{{ route('mapel.pengampu.generate', $mapel->id) }}" method="POST">
              @csrf
              <button class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg">
                ⚡ Generate
              </button>
            </form>

            <button @click="open = true"
              class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg">
              + Tambah
            </button>

          </div>
        </div>

        {{-- LIST GURU --}}
        <div class="space-y-2">
          @forelse ($mapel->gurus as $guru)
          <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-lg">

            <span class="text-sm text-gray-700 dark:text-gray-200">
              {{ $guru->nama_guru }}
            </span>

            <form action="{{ route('mapel.pengampu.destroy', [$mapel->id, $guru->id]) }}"
              method="POST"
              onsubmit="return confirm('Hapus pengampu?')">
              @csrf
              @method('DELETE')

              <button class="text-red-500 hover:text-red-700 text-sm">
                🗑
              </button>
            </form>

          </div>
          @empty
          <p class="text-gray-400 text-sm italic">Belum ada pengampu</p>
          @endforelse
        </div>

        {{-- MODAL TAILWIND --}}
        <div x-show="open"
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
          x-transition>

          <div @click.away="open = false"
            class="bg-white w-full max-w-md rounded-2xl shadow-xl p-5">

            <h3 class="text-lg font-semibold mb-4">
              Tambah Pengampu
            </h3>

            <form action="{{ route('mapel.pengampu.store', $mapel->id) }}" method="POST">
              @csrf

              <select name="guru_id"
                class="w-full border rounded-xl p-2 mb-4 focus:ring focus:ring-blue-200"
                required>
                <option value="">Pilih Guru</option>
                @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}">
                  {{ $guru->nama_guru }}
                </option>
                @endforeach
              </select>

              <div class="flex justify-end gap-2">

                <button type="button"
                  @click="open = false"
                  class="px-3 py-2 bg-gray-400 text-white rounded-lg">
                  Batal
                </button>

                <button type="submit"
                  class="px-3 py-2 bg-blue-600 text-white rounded-lg">
                  Simpan
                </button>

              </div>

            </form>

          </div>
        </div>

      </div>

      {{-- ================= INFO MAPEL ================= --}}
      <div class="bg-white dark:bg-gray-900 border rounded-2xl shadow p-5">

        <h4 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">
          📋 Informasi Mapel
        </h4>

        <div class="space-y-3 text-sm">

          <div class="flex justify-between">
            <span class="text-gray-500">Mapel</span>
            <span class="font-semibold">{{ $mapel->mapel }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-500">Kitab</span>
            <span>{{ $mapel->nama_kitab ?? '-' }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-500">Kelas</span>
            <span>{{ $mapel->kelas->kelas ?? '-' }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-500">Periode</span>
            <span>
              {{ $mapel->periode->periode ?? '-' }}
              ({{ $mapel->periode->semester->ket_semester ?? '-' }})
            </span>
          </div>

        </div>

      </div>

    </div>

    {{-- ================= ACTION ================= --}}
    <div class="flex justify-end gap-3">

      <a href="/mapel/{{ $mapel->id }}/edit"
        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-sm">
        ✏️ Edit
      </a>

      <form action="/mapel/{{ $mapel->id }}" method="POST"
        onsubmit="return confirm('Hapus mapel ini?')">
        @csrf
        @method('DELETE')

        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm">
          🗑 Hapus
        </button>

      </form>

    </div>

  </div>
</x-app-layout>