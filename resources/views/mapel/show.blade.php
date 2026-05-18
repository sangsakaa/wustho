<x-app-layout>
  @section('title', ' | Detail Mapel')

  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
      <div>
        <h2 class="text-2xl font-bold text-slate-800">
          📘 Detail Mata Pelajaran
        </h2>
        <p class="text-sm text-slate-500">
          Informasi mapel, pengampu, dan periode aktif
        </p>
      </div>

      <a href="/mapel"
        class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-xl text-sm shadow">
        ← Kembali
      </a>
    </div>
  </x-slot>

  <div class="max-w-6xl mx-auto p-4 md:p-6 space-y-6">

    {{-- ALERT --}}
    @if(session('success'))
    <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
      ✅ {{ session('success') }}
    </div>
    @endif

    {{-- HEADER CARD --}}
    <div class="bg-white border rounded-3xl shadow-sm p-6 text-center">
      <h3 class="text-3xl font-black text-blue-700">
        {{ $mapel->mapel }}
      </h3>

      <p class="text-sm text-slate-500 mt-2">
        {{ $mapel->nama_kitab ?: 'Tanpa Kitab' }}
      </p>

      <div class="mt-4 flex justify-center gap-3 flex-wrap">
        <span class="px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold">
          Kelas {{ $mapel->kelas->kelas ?? '-' }}
        </span>

        <span class="px-3 py-1 rounded-xl bg-blue-100 text-blue-700 text-sm font-semibold">
          {{ $mapel->periode->periode ?? '-' }}
          ({{ $mapel->periode->semester->ket_semester ?? '-' }})
        </span>

        @if($mapel->gurus->count() > 0)
        <span class="px-3 py-1 rounded-xl bg-green-100 text-green-700 text-sm font-bold">
          ✅ {{ $mapel->gurus->count() }} Pengampu
        </span>
        @else
        <span class="px-3 py-1 rounded-xl bg-red-100 text-red-700 text-sm font-bold">
          ❌ Belum Ada Pengampu
        </span>
        @endif
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">

      {{-- PENGAMPU --}}
      <div x-data="{ open:false }" class="bg-white border rounded-3xl shadow-sm p-5">

        <div class="flex justify-between items-center mb-5">
          <div>
            <h4 class="font-bold text-slate-800">
              👨‍🏫 Guru Pengampu
            </h4>
            <p class="text-xs text-slate-500">
              Total: {{ $mapel->gurus->count() }} guru
            </p>
          </div>

          <div class="flex gap-2">
            <form action="{{ route('mapel.pengampu.generate', $mapel->id) }}" method="POST">
              @csrf
              <button
                class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs rounded-xl">
                ⚡ Generate
              </button>
            </form>

            <button @click="open=true"
              class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-xl">
              + Tambah
            </button>
          </div>
        </div>

        <div class="space-y-3">
          @forelse($mapel->gurus as $guru)
          <div
            class="flex justify-between items-center rounded-xl border border-slate-200 px-4 py-3 hover:bg-slate-50">
            <div>
              <p class="font-medium text-slate-700">
                {{ $guru->nama_guru }}
              </p>
            </div>

            <form
              action="{{ route('mapel.pengampu.destroy', [$mapel->id, $guru->id]) }}"
              method="POST"
              onsubmit="return confirm('Hapus pengampu ini?')">
              @csrf
              @method('DELETE')

              <button class="text-red-500 hover:text-red-700">
                🗑
              </button>
            </form>
          </div>
          @empty
          <div class="text-center py-8 text-slate-400 italic">
            Belum ada pengampu
          </div>
          @endforelse
        </div>

        {{-- MODAL --}}
        <div x-show="open"
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
          x-transition>

          <div @click.away="open=false"
            class="bg-white rounded-3xl shadow-xl w-full max-w-md p-6">

            <h3 class="text-lg font-bold mb-4">
              Tambah Pengampu
            </h3>

            <form action="{{ route('mapel.pengampu.store', $mapel->id) }}" method="POST">
              @csrf

              <select name="guru_id"
                class="w-full border rounded-xl p-3 mb-4 focus:ring focus:ring-blue-200"
                required>
                <option value="">Pilih Guru</option>
                @foreach($gurus as $guru)
                <option value="{{ $guru->id }}">
                  {{ $guru->nama_guru }}
                </option>
                @endforeach
              </select>

              <div class="flex justify-end gap-2">
                <button type="button"
                  @click="open=false"
                  class="px-4 py-2 bg-slate-400 text-white rounded-xl">
                  Batal
                </button>

                <button type="submit"
                  class="px-4 py-2 bg-blue-600 text-white rounded-xl">
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      {{-- INFO MAPEL --}}
      <div class="bg-white border rounded-3xl shadow-sm p-5">
        <h4 class="font-bold text-slate-800 mb-4">
          📋 Informasi Mapel
        </h4>

        <div class="space-y-4 text-sm">

          <div class="flex justify-between border-b pb-2">
            <span class="text-slate-500">Nama Mapel</span>
            <span class="font-semibold">{{ $mapel->mapel }}</span>
          </div>

          <div class="flex justify-between border-b pb-2">
            <span class="text-slate-500">Kitab</span>
            <span>{{ $mapel->nama_kitab ?: '-' }}</span>
          </div>

          <div class="flex justify-between border-b pb-2">
            <span class="text-slate-500">Kelas</span>
            <span>{{ $mapel->kelas->kelas ?? '-' }}</span>
          </div>

          <div class="flex justify-between border-b pb-2">
            <span class="text-slate-500">Periode</span>
            <span>
              {{ $mapel->periode->periode ?? '-' }}
              ({{ $mapel->periode->semester->ket_semester ?? '-' }})
            </span>
          </div>

          <div class="flex justify-between">
            <span class="text-slate-500">Jumlah Pengampu</span>
            <span class="font-bold text-blue-700">
              {{ $mapel->gurus->count() }}
            </span>
          </div>
        </div>
      </div>
    </div>

    {{-- ACTION --}}
    <div class="flex justify-end gap-3">
      <a href="/edit-mapel/{{ $mapel->id }}"
        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm">
        ✏️ Edit
      </a>

      <form action="/mapel/{{ $mapel->id }}" method="POST"
        onsubmit="return confirm('Hapus mapel ini?')">
        @csrf
        @method('DELETE')

        <button
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm">
          🗑 Hapus
        </button>
      </form>
    </div>
  </div>
</x-app-layout>