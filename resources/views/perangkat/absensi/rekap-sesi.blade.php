<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Rekap Sesi')
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
      {{ __('Rekap Sesi') }}
    </h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
      Rekap presensi perangkat bulan {{ $bulan->isoFormat('MMMM YYYY') }}
    </p>
  </x-slot>

  <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-5">

    {{-- ACTION --}}
    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-4">
      <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <a href="/sesi-perangkat"
          class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Kembali
        </a>

        <form action="/rekap-Bulanan" method="get" class="flex gap-2 items-center">
          <input type="month" name="bulan"
            class="border border-gray-200 dark:border-gray-700 px-3 py-2.5 rounded-xl text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
            value="{{ $bulan->format('Y-m') }}">
          <button
            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20">
            Pilih Bulan
          </button>
        </form>
      </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
      <div class="overflow-x-auto p-1">
        <table class="table-fixed w-full text-sm border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 text-xs sm:text-sm">
              <th class="border border-emerald-200 dark:border-emerald-700 px-2 py-3 w-28 text-left font-semibold text-emerald-800 dark:text-emerald-300" rowspan="2">Perangkat</th>
              <th class="border border-emerald-200 dark:border-emerald-700 px-2 py-3 text-center font-semibold text-emerald-800 dark:text-emerald-300" colspan="{{ $periodeBulan->count() }}">
                {{$bulan->isoFormat('MMMM YYYY')}}
              </th>
            </tr>
            <tr class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 text-xs sm:text-sm">
              @foreach ($periodeBulan as $hari)
              <th class="border border-emerald-200 dark:border-emerald-700 px-1 py-2 text-center font-medium
                {{ $hari->isThursday() ? 'bg-emerald-100 dark:bg-emerald-800/40 text-emerald-800 dark:text-emerald-200' : 'text-slate-600 dark:text-slate-400' }}">
                <div class="flex flex-col items-center leading-tight">
                  <span class="text-[10px] uppercase">{{ $hari->isoFormat('dd') }}</span>
                  <span class="font-bold">{{ $hari->day }}</span>
                </div>
              </th>
              @endforeach
            </tr>
          </thead>
          <tbody class="text-xs sm:text-sm">
            @foreach ($dataRekapSesi as $rekapSesi)
            <tr class="even:bg-emerald-50/50 dark:even:bg-emerald-900/10 hover:bg-emerald-50/80 dark:hover:bg-emerald-900/20 transition-colors">
              <th class="border border-emerald-200 dark:border-emerald-700 px-2 py-2.5 text-left font-medium text-slate-800 dark:text-white truncate max-w-[120px]">
                <div class="flex items-center gap-1.5">
                  <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center text-white text-[9px] font-bold shrink-0">
                    {{ strtoupper(substr($rekapSesi['perangkat']->nama_perangkat, 0, 1)) }}
                  </div>
                  <span class="truncate">{{ $rekapSesi['perangkat']->nama_perangkat }}</span>
                </div>
              </th>
              @foreach ($rekapSesi['sesiPerBulan'] as $sesi)
              <td class="border border-emerald-200 dark:border-emerald-700 text-center p-0.5
                {{ $sesi['hari']->isThursday() ? 'bg-emerald-100/50 dark:bg-emerald-800/20' : '' }}">
                <div class="flex justify-center items-center min-h-[28px]">
                  @if (!$sesi['data'])
                    <span class="text-slate-300 dark:text-slate-600">-</span>
                  @elseif ($sesi['data']->keterangan)
                  <a target="_blank" href="/daftar-sesi-perangkat/{{ $sesi['data']->id }}" class="hover:scale-110 transition-transform">
                    @if($sesi['data']->keterangan === 'hadir')
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    @else
                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                  </a>
                  @else
                  <a target="_blank" href="/daftar-sesi-perangkat/{{ $sesi['data']->id }}" class="hover:scale-110 transition-transform">
                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                  </a>
                  @endif
                </div>
              </td>
              @endforeach
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- LEGEND --}}
    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-4">
      <div class="flex flex-wrap items-center gap-4 text-xs">
        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
          <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
          Hadir
        </span>
        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
          <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Izin/Sakit
        </span>
        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
          <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
          Alfa
        </span>
        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
          <span class="w-3 h-3 bg-slate-300 dark:bg-slate-600 rounded"></span>
          Tidak Ada Sesi
        </span>
        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
          <span class="w-3 h-3 bg-emerald-100/50 dark:bg-emerald-800/20 border border-emerald-200 dark:border-emerald-700 rounded"></span>
          Kamis
        </span>
      </div>
    </div>

  </div>

</x-app-layout>