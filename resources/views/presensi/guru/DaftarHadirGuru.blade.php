<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Guru
        </h2>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-5">

            {{-- NOTIFIKASI --}}
            @php
            $colors = [
            'hadir' => 'peer-checked:bg-green-500 peer-checked:border-green-500',
            'izin' => 'peer-checked:bg-blue-500 peer-checked:border-blue-500',
            'sakit' => 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500',
            'alfa' => 'peer-checked:bg-red-500 peer-checked:border-red-500',
            ];
            @endphp
            @if (session('status'))
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            {{-- HEADER INFO --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Presensi Guru</h3>
                            <p class="text-emerald-100 text-sm">{{ \Carbon\Carbon::parse($title->tanggal)->translatedFormat('l, j F Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-3 flex flex-wrap gap-x-8 gap-y-1 text-sm">
                    <div>
                        <span class="text-slate-500 dark:text-slate-400">Kelas</span>
                        <span class="ml-2 font-medium text-slate-800 dark:text-white">{{ $title->nama_kelas }}</span>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form action="/sesi-presensi-guru/{{$sesi_Kelas_Guru->id}}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="sesi_kelas_guru_id" value="{{ $sesi_Kelas_Guru->id }}">

                {{-- ACTION --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-6 py-3 sm:py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-600/30">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Presensi
                    </button>

                    <a href="/sesi-presensi-guru"
                        class="inline-flex items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-5 py-3 sm:py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-emerald-500/5 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto max-h-[550px]">
                        <table class="w-full text-sm">
                            <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-xs uppercase sticky top-0 z-10 text-slate-600 tracking-wider">
                                <tr>
                                    <th class="px-4 py-3.5 text-center w-16">No</th>
                                    <th class="px-4 py-3.5 text-left">Nama Guru</th>
                                    <th class="px-4 py-3.5 text-center">Keterangan</th>
                                    <th class="px-4 py-3.5 text-left">Alasan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @foreach ($dataGuru as $item)
                                <tr class="hover:bg-slate-50 transition-colors duration-150 even:bg-slate-50/50">

                                    <td class="text-center py-3.5 text-slate-500 text-xs">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3.5 capitalize font-medium text-slate-800 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                                {{ strtoupper(substr($item->nama_guru, 0, 1)) }}
                                            </div>
                                            {{ strtolower($item->nama_guru) }}
                                        </div>
                                        <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                                    </td>

                                    {{-- RADIO --}}
                                    <td class="text-center py-3.5">
                                        <div class="flex justify-center gap-2">
                                            @foreach ([
                                            'hadir' => ['H', 'bg-green-600'],
                                            'izin' => ['I', 'bg-blue-600'],
                                            'sakit' => ['S', 'bg-yellow-500'],
                                            'alfa' => ['A', 'bg-red-600']
                                            ] as $val => [$label, $color])

                                            <label class="cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $val }}"
                                                    class="peer hidden"
                                                    {{ $item->keterangan === $val ? 'checked' : '' }}>

                                                <span
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg border-2
                       text-xs font-bold transition-all duration-200
                       border-slate-300 text-slate-600 bg-white
                       peer-checked:text-white
                       peer-checked:border-transparent
                       {{ $val == 'hadir' ? 'peer-checked:bg-green-600' : '' }}
                       {{ $val == 'izin' ? 'peer-checked:bg-blue-600' : '' }}
                       {{ $val == 'sakit' ? 'peer-checked:bg-yellow-500' : '' }}
                       {{ $val == 'alfa' ? 'peer-checked:bg-red-600' : '' }}">
                                                    {{ $label }}
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- ALASAN --}}
                                    <td class="px-4 py-3.5">
                                        <input
                                            value="{{ $item->alasan }}"
                                            name="alasan[{{ $item->id }}]"
                                            placeholder="Isi alasan..."
                                            class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE CARD --}}
                <div class="md:hidden space-y-4">
                    @foreach ($dataGuru as $item)
                    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-5 space-y-5">

                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($item->nama_guru, 0, 1)) }}
                                </div>
                                <h3 class="font-semibold text-slate-800 dark:text-white capitalize">
                                    {{ strtolower($item->nama_guru) }}
                                </h3>
                            </div>
                            <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                        </div>

                        {{-- RADIO MOBILE --}}
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wider font-medium">Keterangan</p>

                            <div class="grid grid-cols-4 gap-2">
                                @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alfa'] as $val => $label)
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="keterangan[{{ $item->id }}]"
                                        value="{{ $val }}"
                                        class="hidden peer"
                                        {{ $item->keterangan === $val ? 'checked' : '' }}>

                                    <div class="border-2 rounded-xl px-2 py-3 text-center text-xs font-medium transition-all
                                                peer-checked:bg-emerald-600
                                                peer-checked:text-white
                                                peer-checked:border-emerald-600
                                                hover:bg-slate-50
                                                border-gray-200 text-gray-600">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- ALASAN --}}
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider font-medium">Alasan</p>
                            <input
                                value="{{ $item->alasan }}"
                                name="alasan[{{ $item->id }}]"
                                placeholder="Isi alasan..."
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                        </div>
                    </div>
                    @endforeach
                </div>

            </form>
        </div>
    </div>
</x-app-layout>