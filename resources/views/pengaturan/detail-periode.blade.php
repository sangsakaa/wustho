<x-app-layout>

  <x-slot name="header">

    @section('title', ' | Detail Periode')

    <div class="flex flex-col gap-1">

      <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
        Detail Periode
      </h2>

      <p class="text-sm text-slate-500 dark:text-slate-400">
        Informasi lengkap periode akademik
      </p>

    </div>

  </x-slot>

  <div class="p-4 space-y-5">

    {{-- TOP ACTION --}}
    <div class="flex items-center justify-between flex-wrap gap-3">

      <a href="{{ route('periode') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-700 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition">

        ← Kembali

      </a>

      @if(!$periode->is_active)

      <form
        action="{{ url('/periode/aktifkan/'.$periode->id) }}"
        method="POST">

        @csrf

        <button
          class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm transition">

          Aktifkan Periode

        </button>

      </form>

      @endif

    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-sm overflow-hidden">

      {{-- HEADER --}}
      <div class="p-6 border-b border-slate-200 dark:border-slate-700">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

          {{-- LEFT --}}
          <div class="space-y-3">

            <div class="flex items-center gap-3 flex-wrap">

              <h3 class="text-3xl font-bold text-slate-800 dark:text-white">
                {{ $periode->periode }}
              </h3>

              @php
              $semester = strtolower($periode->semester->ket_semester ?? '');

              $badge = match($semester) {
              'ganjil' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
              'genap' => 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300',
              'pendek' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
              default => 'bg-slate-100 text-slate-700',
              };
              @endphp

              <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badge }}">
                {{ $periode->semester->ket_semester }}
              </span>

              @if($periode->is_active)

              <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300 text-sm font-semibold">

                <span class="w-2 h-2 rounded-full bg-green-500"></span>

                Aktif

              </span>

              @else

              <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300 text-sm font-semibold">

                <span class="w-2 h-2 rounded-full bg-red-500"></span>

                Nonaktif

              </span>

              @endif

            </div>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Detail data periode dan relasi sistem akademik.
            </p>

          </div>

        </div>

      </div>

      {{-- CONTENT --}}
      <div class="p-6">

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">

          {{-- TANGGAL --}}
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/40 p-5">

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Tanggal Mulai
            </p>

            <h4 class="mt-2 text-lg font-bold text-slate-800 dark:text-white">
              {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->translatedFormat('d F Y') }}
            </h4>

          </div>

          {{-- SEMESTER --}}
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/40 p-5">

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Semester
            </p>

            <h4 class="mt-2 text-lg font-bold text-slate-800 dark:text-white">
              {{ $periode->semester->semester }}
            </h4>

          </div>

          {{-- HIJRIYAH --}}
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/40 p-5">

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Tahun Hijriyah
            </p>

            <h4 class="mt-2 text-lg font-bold text-slate-800 dark:text-white">
              {{ $periode->tahun_hijriyah }}
            </h4>

          </div>

          {{-- STATUS --}}
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/40 p-5">

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Status Sistem
            </p>

            <h4 class="mt-2 text-lg font-bold">

              @if($periode->is_active)

              <span class="text-green-600 dark:text-green-400">
                Aktif
              </span>

              @else

              <span class="text-red-600 dark:text-red-400">
                Nonaktif
              </span>

              @endif

            </h4>

          </div>

        </div>

      </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">

      {{-- KELAS --}}
      <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">

        <div class="flex items-center justify-between">

          <div>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Kelas
            </p>

            <h3 class="mt-2 text-3xl font-bold text-blue-600">
              {{ $periode->kelasmi->count() }}
            </h3>

          </div>

          <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 text-xl">
            📚
          </div>

        </div>

      </div>

      {{-- ASRAMA --}}
      <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">

        <div class="flex items-center justify-between">

          <div>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Asrama
            </p>

            <h3 class="mt-2 text-3xl font-bold text-green-600">
              {{ $periode->asramasiswa->count() }}
            </h3>

          </div>

          <div class="w-12 h-12 rounded-2xl bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 text-xl">
            🏠
          </div>

        </div>

      </div>

      {{-- LULUSAN --}}
      <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">

        <div class="flex items-center justify-between">

          <div>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Lulusan
            </p>

            <h3 class="mt-2 text-3xl font-bold text-purple-600">
              {{ $periode->lulusan->count() }}
            </h3>

          </div>

          <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center text-purple-600 text-xl">
            🎓
          </div>

        </div>

      </div>

      {{-- NOMINASI --}}
      <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">

        <div class="flex items-center justify-between">

          <div>

            <p class="text-sm text-slate-500 dark:text-slate-400">
              Nominasi
            </p>

            <h3 class="mt-2 text-3xl font-bold text-orange-600">
              {{ $periode->nominasi->count() }}
            </h3>

          </div>

          <div class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-500/20 flex items-center justify-center text-orange-600 text-xl">
            🏆
          </div>

        </div>

      </div>

    </div>

  </div>

</x-app-layout>