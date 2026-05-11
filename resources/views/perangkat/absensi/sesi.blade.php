<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Sesi Perangkat '.\Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y'))

        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-lg sm:text-xl text-gray-800">
                Sesi Perangkat
            </h2>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y') }}
            </p>
        </div>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- TOAST --}}
            @foreach (['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $type => $color)
            @if(session($type))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 z-50 text-sm">
                <div class="flex items-center gap-2 bg-white border border-{{ $color }}-200 shadow-lg rounded-xl px-5 py-3.5">
                    <div class="w-2 h-2 rounded-full bg-{{ $color }}-500"></div>
                    <span class="text-gray-700 font-medium">{{ session($type) }}</span>
                </div>
            </div>
            @endif
            @endforeach

            {{-- FILTER + ACTION --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl p-5 transition hover:shadow-xl">

                <div class="flex w-full flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

                    {{-- LEFT SECTION --}}
                    <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto">

                        {{-- FILTER --}}
                        <form action="/sesi-perangkat" method="GET"
                            class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto shrink-0">

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <input
                                    type="date"
                                    name="tanggal"
                                    value="{{ $tanggal->toDateString() }}"
                                    class="pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition w-full sm:w-auto">
                            </div>

                            <button
                                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-600/30">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filter
                            </button>
                        </form>

                        {{-- BUAT SESI --}}
                        <form action="/sesi-perangkat" method="POST"
                            class="w-full lg:w-auto shrink-0">
                            @csrf
                            <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">

                            <button
                                class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-600/30">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Buat Sesi
                            </button>
                        </form>
                    </div>

                    {{-- RIGHT SECTION --}}
                    <div class="grid grid-cols-3 sm:flex gap-2 w-full lg:w-auto">
                        <a href="/laporan-harian-perangkat"
                            class="inline-flex items-center justify-center gap-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Harian
                        </a>

                        <a href="/laporan-Bulanan-perangkat"
                            class="inline-flex items-center justify-center gap-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Bulanan
                        </a>

                        <a href="/rekap-Bulanan"
                            class="inline-flex items-center justify-center gap-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                            Rekap
                        </a>
                    </div>

                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-xs uppercase text-slate-600 tracking-wider">
                            <tr>
                                <th class="px-4 py-3.5 text-center w-16">No</th>
                                <th class="px-4 py-3.5 text-center">Tanggal</th>
                                <th class="px-4 py-3.5 text-center">Periode</th>
                                <th class="px-4 py-3.5 text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($dataSesiPerangkat as $org)
                            <tr class="hover:bg-slate-50 transition-colors duration-150 even:bg-slate-50/50 text-center">

                                <td class="px-4 py-3.5 text-slate-500 text-xs">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3.5">
                                    <a href="/daftar-sesi-perangkat/{{ $org->id }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                        {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                                    </a>
                                </td>

                                <td class="px-4 py-3.5">
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ $org->periode }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $org->ket_semester }}
                                    </div>
                                </td>

                                <td class="px-4 py-3.5">
                                    @if($org->SesiP !== null)
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        Sudah Absen
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Belum Absen
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-slate-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Data sesi belum tersedia</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MOBILE CARD --}}
            <div class="md:hidden space-y-3">
                @forelse($dataSesiPerangkat as $org)
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-5 space-y-4 transition hover:shadow-md">

                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Tanggal</p>
                            <a href="/daftar-sesi-perangkat/{{ $org->id }}"
                                class="text-blue-600 font-semibold text-sm hover:underline">
                                {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat('DD MMMM Y') }}
                            </a>
                        </div>

                        <span class="text-xs bg-slate-100 dark:bg-gray-800 text-slate-500 px-2.5 py-1 rounded-lg font-medium">
                            #{{ $loop->iteration }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider">Periode</p>
                            <p class="font-medium text-slate-800 dark:text-white">{{ $org->periode }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider">Semester</p>
                            <p class="font-medium text-slate-800 dark:text-white">{{ $org->ket_semester }}</p>
                        </div>
                    </div>

                    <div>
                        @if($org->SesiP !== null)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-full text-xs font-medium">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Sudah Absen
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 px-3 py-1.5 rounded-full text-xs font-medium">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                            Belum Absen
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-10 text-center text-slate-400">
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Data sesi belum tersedia</span>
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>