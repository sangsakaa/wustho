<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">
          Validasi Kelulusan
        </h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
          Monitoring masa studi dan validasi data kelulusan siswa
        </p>
      </div>
    </div>
  </x-slot>

  @php
  $dataTable = match ($tab) {
  'warning' => $validasiKelulusan->where('status', 'warning'),
  'valid' => $validasiKelulusan->where('status', 'valid'),
  'proses' => $validasiKelulusan->where('status', 'proses'),
  default => $validasiKelulusan,
  };
  @endphp

  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

      {{-- FILTER TOOLBAR --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
        <form method="GET" action="{{ route('validasi.kelulusan') }}">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="flex items-center gap-3">
              <select
                name="tahun"
                onchange="this.form.submit()"
                class="rounded-2xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white text-sm shadow-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Tahun Masuk</option>
                @foreach ($listTahun as $item)
                <option value="{{ $item }}" {{ $tahun == $item ? 'selected' : '' }}>
                  {{ $item }}
                </option>
                @endforeach
              </select>

              <input type="hidden" name="tab" value="{{ $tab }}">

              @if ($tahun)
              <a href="{{ route('validasi.kelulusan', ['tab' => $tab]) }}"
                class="px-4 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-sm font-medium transition">
                Reset
              </a>
              @endif
            </div>
          </div>
        </form>
      </div>

      {{-- SUMMARY --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-500">Warning</p>
              <h3 class="text-3xl font-bold text-red-600 mt-2">
                {{ $validasiKelulusan->where('status', 'warning')->count() }}
              </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-xl">
              ⚠
            </div>
          </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-500">Valid</p>
              <h3 class="text-3xl font-bold text-green-600 mt-2">
                {{ $validasiKelulusan->where('status', 'valid')->count() }}
              </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
              ✓
            </div>
          </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-500">Masih Aktif</p>
              <h3 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $validasiKelulusan->where('status', 'proses')->count() }}
              </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-xl">
              ⏳
            </div>
          </div>
        </div>
      </div>

      {{-- TABLE CARD --}}
      <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">

        {{-- TABS --}}
        <div class="border-b border-slate-200 dark:border-slate-700 px-6">
          <nav class="flex gap-8 overflow-x-auto">
            @php
            $tabs = [
            'all' => 'Semua',
            'warning' => 'Warning',
            'valid' => 'Valid',
            'proses' => 'Masih Aktif',
            ];
            @endphp

            @foreach ($tabs as $key => $label)
            <a href="{{ route('validasi.kelulusan', ['tab' => $key, 'tahun' => $tahun]) }}"
              class="py-4 text-sm font-medium border-b-2 whitespace-nowrap transition
                                {{ $tab == $key
                                    ? match ($key) {
                                        'warning' => 'border-red-500 text-red-600',
                                        'valid' => 'border-green-500 text-green-600',
                                        'proses' => 'border-yellow-500 text-yellow-600',
                                        default => 'border-indigo-500 text-indigo-600',
                                    }
                                    : 'border-transparent text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
              {{ $label }}
            </a>
            @endforeach
          </nav>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-slate-50 dark:bg-slate-900/40">
              <tr class="text-xs uppercase tracking-wider text-slate-500">
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Siswa</th>
                <th class="px-6 py-4 text-center">NIS</th>
                <th class="px-6 py-4 text-center">Masuk</th>
                <th class="px-6 py-4 text-center">Lulus</th>
                <th class="px-6 py-4 text-center">Studi</th>
                <th class="px-6 py-4 text-center">Aktif</th>
                <th class="px-6 py-4 text-center">Status</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
              @forelse($dataTable as $item)
              <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition duration-150">

                <td class="px-6 py-5 text-sm text-slate-500">
                  {{ $loop->iteration }}
                </td>

                <td class="px-6 py-5">
                  <div>
                    <p class="font-semibold text-slate-800 dark:text-white">
                      {{ $item->nama_siswa }}
                    </p>

                    <div class="flex items-center gap-2 mt-2">
                      <span class="text-xs text-slate-500">
                        {{ $item->nis }}
                      </span>

                      <span class="px-2.5 py-1 rounded-xl text-xs font-medium
                                                    bg-indigo-100 text-indigo-700
                                                    dark:bg-indigo-900/20 dark:text-indigo-300">
                        {{ $item->madrasah_diniyah }}
                      </span>
                    </div>
                  </div>
                </td>

                <td class="px-6 py-5 text-center">
                  @if ($item->tahun_nis == $item->tahun_masuk)
                  <span class="inline-flex w-9 h-9 rounded-2xl items-center justify-center bg-green-100 text-green-700 font-bold">
                    ✓
                  </span>
                  @else
                  <span class="inline-flex w-9 h-9 rounded-2xl items-center justify-center bg-red-100 text-red-700 font-bold">
                    ✗
                  </span>
                  @endif
                </td>

                <td class="px-6 py-5 text-center text-sm">
                  {{ $item->tahun_masuk }}
                </td>

                <td class="px-6 py-5 text-center text-sm">
                  {{ $item->tahun_lulus ?? '-' }}
                </td>

                <td class="px-6 py-5 text-center text-sm">
                  <div>
                    <p class="font-medium">{{ $item->minimal_studi }} th</p>
                    <p class="text-xs text-slate-400">
                      {{ $item->lama_studi ? $item->lama_studi . ' th' : '-' }}
                    </p>
                  </div>
                </td>

                <td class="px-6 py-5 text-center text-sm">
                  {{ $item->masa_berjalan }} th
                </td>

                {{-- STATUS --}}
                <td class="px-6 py-5 text-center">
                  <div class="relative inline-block group">

                    @php
                    $statusConfig = match ($item->status) {
                    'warning' => ['icon' => '⚠', 'class' => 'bg-red-100 text-red-700'],
                    'proses' => ['icon' => '⏳', 'class' => 'bg-yellow-100 text-yellow-700'],
                    default => ['icon' => '✓', 'class' => 'bg-green-100 text-green-700'],
                    };
                    @endphp

                    <span class="inline-flex w-9 h-9 rounded-2xl items-center justify-center cursor-pointer font-semibold {{ $statusConfig['class'] }}">
                      {{ $statusConfig['icon'] }}
                    </span>

                    <div class="absolute left-1/2 top-full z-50 mt-3 w-56 -translate-x-1/2
                                                rounded-2xl bg-slate-900 text-white text-xs px-4 py-3 shadow-2xl
                                                opacity-0 invisible transition-all duration-200
                                                group-hover:opacity-100 group-hover:visible">

                      <div class="absolute -top-2 left-1/2 -translate-x-1/2
                                                    border-x-8 border-x-transparent border-b-8 border-b-slate-900"></div>

                      <p class="leading-relaxed text-center">
                        {{ $item->keterangan }}
                      </p>
                    </div>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                  Tidak ada data validasi kelulusan
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
