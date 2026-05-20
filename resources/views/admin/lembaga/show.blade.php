<x-app-layout>
  <div class="max-w-5xl mx-auto p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">
          Detail Lembaga
        </h1>
        <p class="text-sm text-gray-500 mt-1">
          Informasi lengkap data lembaga pendidikan
        </p>
      </div>

      <a href="{{ route('lembaga.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition">
        ← Kembali
      </a>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

      {{-- Top Section --}}
      <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white">
        <div class="flex flex-col md:flex-row items-center gap-6">

          {{-- Logo --}}
          <div class="shrink-0">
            @if($lembaga->logo)
            <img
              src="{{ asset('storage/' . $lembaga->logo) }}"
              alt="{{ $lembaga->nama }}"
              class="w-28 h-28 rounded-2xl object-cover shadow-lg border-4 border-white/30">
            @else
            <div class="w-28 h-28 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-bold shadow-lg">
              {{ strtoupper(substr($lembaga->nama ?? 'L', 0, 1)) }}
            </div>
            @endif
          </div>

          {{-- Info --}}
          <div class="text-center md:text-left">
            <h2 class="text-2xl font-bold">
              {{ $lembaga->nama }}
            </h2>

            <p class="text-blue-100 mt-1">
              Kode: {{ $lembaga->kode }}
            </p>

            <div class="mt-3">
              @if($lembaga->is_active)
              <span class="px-3 py-1 bg-green-500 rounded-full text-xs font-semibold shadow">
                Aktif
              </span>
              @else
              <span class="px-3 py-1 bg-red-500 rounded-full text-xs font-semibold shadow">
                Nonaktif
              </span>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Content --}}
      <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Deskripsi --}}
        <div>
          <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">
            Deskripsi
          </h3>
          <div class="bg-gray-50 rounded-2xl p-4 border">
            <p class="text-gray-700 leading-relaxed">
              {{ $lembaga->deskripsi ?: 'Belum ada deskripsi.' }}
            </p>
          </div>
        </div>

        {{-- Metadata --}}
        <div class="space-y-4">
          <div class="bg-gray-50 rounded-2xl p-4 border">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
              Dibuat
            </h3>
            <p class="text-gray-700 mt-1">
              {{ $lembaga->created_at?->format('d M Y H:i') ?? '-' }}
            </p>
          </div>

          <div class="bg-gray-50 rounded-2xl p-4 border">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
              Terakhir Update
            </h3>
            <p class="text-gray-700 mt-1">
              {{ $lembaga->updated_at?->format('d M Y H:i') ?? '-' }}
            </p>
          </div>
        </div>
      </div>

      {{-- Footer --}}
      <div class="px-8 pb-8 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('lembaga.edit', $lembaga) }}"
          class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition text-center shadow">
          Edit Data
        </a>

        <form action="{{ route('lembaga.destroy', $lembaga) }}"
          method="POST"
          onsubmit="return confirm('Yakin hapus lembaga ini?')">
          @csrf
          @method('DELETE')

          <button
            type="submit"
            class="w-full sm:w-auto px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition shadow">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>