<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Transkip')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Dashboard Data Transkip
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Manajemen data transkip dan kelulusan
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- NAVIGATION --}}
        {{-- =========================================================
    HEADER ACTION
========================================================= --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Transkip Nilai
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Pengelolaan data transkip nilai peserta didik kelas akhir.
                </p>
            </div>


            {{-- DATA LULUSAN --}}
            <a
                href="{{ url('/lulusan') }}"
                class="inline-flex items-center justify-center gap-2
               px-4 py-2.5
               bg-emerald-600 hover:bg-emerald-700
               text-white
               rounded-xl
               text-sm font-semibold
               shadow-sm
               transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />

                </svg>

                Data Lulusan

            </a>

        </div>


        {{-- =========================================================
    INFORMASI KETENTUAN
========================================================= --}}
        <div
            class="mt-5 overflow-hidden
           rounded-2xl
           border border-blue-200 dark:border-blue-800
           bg-blue-50/70 dark:bg-blue-900/10
           shadow-sm">

            <div class="p-5">

                <div class="flex items-start gap-4">

                    {{-- ICON --}}
                    <div
                        class="flex-shrink-0
                       flex items-center justify-center
                       w-11 h-11
                       rounded-xl
                       bg-blue-100 dark:bg-blue-900/40
                       text-blue-600 dark:text-blue-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 14l9-5-9-5-9 5 9 5Z" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 10v5.5C5 17.43 8.13 19 12 19s7-1.57 7-3.5V10" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 9v5" />

                        </svg>

                    </div>


                    {{-- CONTENT --}}
                    <div class="flex-1 min-w-0">

                        <h3
                            class="text-base font-semibold
                           text-slate-800 dark:text-white">

                            Ketentuan Input Transkip

                        </h3>

                        <p
                            class="mt-1 text-sm
                           text-slate-600 dark:text-slate-400">

                            Perhatikan ketentuan berikut sebelum melakukan
                            input data transkip nilai.

                        </p>


                        {{-- KETENTUAN --}}
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">

                            {{-- KETENTUAN 1 --}}
                            <div
                                class="flex items-start gap-3
                               p-3
                               rounded-xl
                               bg-white/70 dark:bg-slate-800/60
                               border border-blue-100
                               dark:border-slate-700">

                                <div
                                    class="flex items-center justify-center
                                   w-7 h-7 flex-shrink-0
                                   rounded-lg
                                   bg-blue-100 dark:bg-blue-900/40
                                   text-blue-600 dark:text-blue-400
                                   text-xs font-bold">

                                    1

                                </div>

                                <div>

                                    <p class="text-sm font-semibold
                                      text-slate-700 dark:text-slate-200">

                                        Kelas 3

                                    </p>

                                    <p class="mt-0.5 text-xs
                                      text-slate-500 dark:text-slate-400">

                                        Transkip hanya untuk peserta didik kelas 3.

                                    </p>

                                </div>

                            </div>


                            {{-- KETENTUAN 2 --}}
                            <div
                                class="flex items-start gap-3
                               p-3
                               rounded-xl
                               bg-white/70 dark:bg-slate-800/60
                               border border-blue-100
                               dark:border-slate-700">

                                <div
                                    class="flex items-center justify-center
                                   w-7 h-7 flex-shrink-0
                                   rounded-lg
                                   bg-blue-100 dark:bg-blue-900/40
                                   text-blue-600 dark:text-blue-400
                                   text-xs font-bold">

                                    2

                                </div>

                                <div>

                                    <p class="text-sm font-semibold
                                      text-slate-700 dark:text-slate-200">

                                        Semester Genap

                                    </p>

                                    <p class="mt-0.5 text-xs
                                      text-slate-500 dark:text-slate-400">

                                        Input dilakukan pada periode semester genap.

                                    </p>

                                </div>

                            </div>


                            {{-- KETENTUAN 3 --}}
                            <div
                                class="flex items-start gap-3
                               p-3
                               rounded-xl
                               bg-white/70 dark:bg-slate-800/60
                               border border-blue-100
                               dark:border-slate-700">

                                <div
                                    class="flex items-center justify-center
                                   w-7 h-7 flex-shrink-0
                                   rounded-lg
                                   bg-blue-100 dark:bg-blue-900/40
                                   text-blue-600 dark:text-blue-400
                                   text-xs font-bold">

                                    3

                                </div>

                                <div>

                                    <p class="text-sm font-semibold
                                      text-slate-700 dark:text-slate-200">

                                        Nilai Lengkap

                                    </p>

                                    <p class="mt-0.5 text-xs
                                      text-slate-500 dark:text-slate-400">

                                        Pastikan seluruh nilai siswa telah diinput.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
        STATUS PERIODE
    ====================================================== --}}
            <div
                class="px-5 py-3.5
               border-t
               {{ $isGenap
                    ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50/70 dark:bg-emerald-900/10'
                    : 'border-red-200 dark:border-red-800 bg-red-50/70 dark:bg-red-900/10'
               }}">

                <div class="flex items-center gap-3">

                    @if ($isGenap)

                    {{-- AKTIF --}}
                    <div
                        class="flex items-center justify-center
                           w-8 h-8
                           rounded-lg
                           bg-emerald-100 dark:bg-emerald-900/40
                           text-emerald-600 dark:text-emerald-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5 12 4 4L19 6" />

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-semibold
                              text-emerald-800 dark:text-emerald-300">

                            Input Transkip Aktif

                        </p>

                        <p class="text-xs text-emerald-700
                              dark:text-emerald-400">

                            Periode aktif saat ini adalah
                            <strong>
                                {{ $periodeAktif->periode ?? '-' }}
                                {{ $periodeAktif->ket_semester ?? '' }}
                            </strong>.
                            Data transkip dapat ditambahkan.

                        </p>

                    </div>

                    @else

                    {{-- NONAKTIF --}}
                    <div
                        class="flex items-center justify-center
                           w-8 h-8
                           rounded-lg
                           bg-red-100 dark:bg-red-900/40
                           text-red-600 dark:text-red-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-semibold
                              text-red-800 dark:text-red-300">

                            Input Transkip Dinonaktifkan

                        </p>

                        <p class="text-xs text-red-700
                              dark:text-red-400">

                            Periode aktif saat ini adalah
                            <strong>
                                {{ $periodeAktif->periode ?? '-' }}
                                {{ $periodeAktif->ket_semester ?? '' }}
                            </strong>.
                            Input transkip hanya dapat dilakukan pada
                            <strong>semester genap</strong>.

                        </p>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Form Input Data Transkip
                </h3>
            </div>

            <form action="{{ url('/daftar-transkip') }}" method="POST" class="p-6">

                @csrf

                {{-- =========================================================
        INFORMASI FORM
    ========================================================== --}}
                <div class="mb-6">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex items-center justify-center
                       w-10 h-10
                       rounded-xl
                       bg-blue-50 dark:bg-blue-900/30
                       text-blue-600 dark:text-blue-400">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2Z" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                Tambah Data Transkip
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Tentukan periode, kelas, mata pelajaran, dan jenis ujian
                                yang akan dimasukkan ke dalam transkip.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
        FORM INPUT
    ========================================================== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">


                    {{-- =====================================================
            PERIODE
        ====================================================== --}}
                    <div>

                        <label
                            for="periode_id"
                            class="flex items-center gap-2
                       mb-2
                       text-sm font-semibold
                       text-slate-700 dark:text-slate-300">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 9.75h18M5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25Z" />

                            </svg>

                            Periode Lulusan

                        </label>


                        <select
                            id="periode_id"
                            name="periode_id"
                            required
                            class="w-full px-4 py-3
                       rounded-xl
                       border border-slate-200 dark:border-slate-600
                       bg-white dark:bg-slate-900
                       text-sm
                       text-slate-700 dark:text-white
                       shadow-sm
                       focus:ring-2 focus:ring-blue-500/20
                       focus:border-blue-500
                       outline-none
                       transition">

                            <option value="">
                                Pilih periode
                            </option>

                            @foreach($dataPeriode as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('periode_id', $periodeAktif->id ?? '') == $item->id)>

                                {{ $item->periode }} — {{ $item->ket_semester }}

                            </option>

                            @endforeach

                        </select>

                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Periode yang digunakan sebagai periode kelulusan.
                        </p>

                    </div>


                    {{-- =====================================================
            KELAS
        ====================================================== --}}
                    <div>

                        <label
                            for="kelasmi_id"
                            class="flex items-center gap-2
                       mb-2
                       text-sm font-semibold
                       text-slate-700 dark:text-slate-300">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25Z" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7.5 8.25h9m-9 3.75h9m-9 3.75h5.25" />

                            </svg>

                            Kelas

                        </label>


                        <select
                            id="kelasmi_id"
                            name="kelasmi_id"
                            required
                            class="w-full px-4 py-3
                       rounded-xl
                       border border-slate-200 dark:border-slate-600
                       bg-white dark:bg-slate-900
                       text-sm
                       text-slate-700 dark:text-white
                       shadow-sm
                       focus:ring-2 focus:ring-blue-500/20
                       focus:border-blue-500
                       outline-none
                       transition">

                            <option value="">
                                Pilih kelas
                            </option>

                            @foreach($kelasMi as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('kelasmi_id')==$item->id)>

                                {{ $item->nama_kelas }}

                            </option>

                            @endforeach

                        </select>

                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Pilih kelas 3 yang akan dibuatkan transkip.
                        </p>

                    </div>


                    {{-- =====================================================
            MAPEL
        ====================================================== --}}
                    <div>

                        <label
                            for="mapel_id"
                            class="flex items-center gap-2
                       mb-2
                       text-sm font-semibold
                       text-slate-700 dark:text-slate-300">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 6.75c-1.88-1.5-4.5-2.25-7.5-2.25v13.5c3 0 5.62.75 7.5 2.25m0-13.5c1.88-1.5 4.5-2.25 7.5-2.25v13.5c-3 0-5.62.75-7.5 2.25m0-13.5v13.5" />

                            </svg>

                            Mata Pelajaran

                        </label>


                        <select
                            id="mapel_id"
                            name="mapel_id"
                            required
                            class="w-full px-4 py-3
                       rounded-xl
                       border border-slate-200 dark:border-slate-600
                       bg-white dark:bg-slate-900
                       text-sm
                       text-slate-700 dark:text-white
                       shadow-sm
                       focus:ring-2 focus:ring-blue-500/20
                       focus:border-blue-500
                       outline-none
                       transition">

                            <option value="">
                                Pilih mata pelajaran
                            </option>

                            @foreach($dataMapel as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('mapel_id')==$item->id)>

                                {{ $item->mapel }}

                            </option>

                            @endforeach

                        </select>

                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Pilih mata pelajaran yang akan dimasukkan ke transkip.
                        </p>

                    </div>


                    {{-- =====================================================
            JENIS UJIAN
        ====================================================== --}}
                    <div>

                        <label
                            for="jenis_ujian_id"
                            class="flex items-center gap-2
                       mb-2
                       text-sm font-semibold
                       text-slate-700 dark:text-slate-300">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />

                            </svg>

                            Jenis Ujian

                        </label>


                        <select
                            id="jenis_ujian_id"
                            name="jenis_ujian_id"
                            required
                            class="w-full px-4 py-3
                       rounded-xl
                       border border-slate-200 dark:border-slate-600
                       bg-white dark:bg-slate-900
                       text-sm
                       text-slate-700 dark:text-white
                       shadow-sm
                       focus:ring-2 focus:ring-blue-500/20
                       focus:border-blue-500
                       outline-none
                       transition">

                            <option value="">
                                Pilih jenis ujian
                            </option>

                            @foreach($dataJenisUjian as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('jenis_ujian_id')==$item->id)>

                                {{ $item->nama_ujian }}

                            </option>

                            @endforeach

                        </select>

                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Tentukan jenis ujian untuk mata pelajaran tersebut.
                        </p>

                    </div>

                </div>


                {{-- =========================================================
        STATUS / FOOTER
    ========================================================== --}}
                <div
                    class="mt-6 pt-5
               border-t border-slate-200 dark:border-slate-700">

                    <div
                        class="flex flex-col lg:flex-row
                   lg:items-center
                   lg:justify-between
                   gap-4">


                        {{-- INFO --}}
                        <div class="flex items-start gap-3">

                            @if($isGenap)

                            <div
                                class="flex-shrink-0
                               w-9 h-9
                               flex items-center justify-center
                               rounded-lg
                               bg-emerald-50 dark:bg-emerald-900/30
                               text-emerald-600 dark:text-emerald-400">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m5 12 4 4L19 6" />

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold
                                  text-emerald-700 dark:text-emerald-300">

                                    Form siap digunakan

                                </p>

                                <p class="mt-0.5 text-xs
                                  text-slate-500 dark:text-slate-400">

                                    Periode aktif:
                                    <strong>
                                        {{ $periodeAktif->periode ?? '-' }}
                                        {{ $periodeAktif->ket_semester ?? '' }}
                                    </strong>

                                </p>

                            </div>

                            @else

                            <div
                                class="flex-shrink-0
                               w-9 h-9
                               flex items-center justify-center
                               rounded-lg
                               bg-red-50 dark:bg-red-900/30
                               text-red-600 dark:text-red-400">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold
                                  text-red-700 dark:text-red-300">

                                    Input tidak tersedia

                                </p>

                                <p class="mt-0.5 text-xs
                                  text-slate-500 dark:text-slate-400">

                                    Transkip hanya dapat dibuat pada
                                    <strong>semester genap</strong>.

                                </p>

                            </div>

                            @endif

                        </div>


                        {{-- BUTTON --}}
                        <button
                            type="submit"
                            @disabled(!$isGenap)
                            class="inline-flex items-center justify-center gap-2
                       min-w-[160px]
                       px-5 py-3
                       rounded-xl
                       text-sm font-semibold
                       text-white
                       transition
                       {{ $isGenap
                            ? 'bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow'
                            : 'bg-slate-300 dark:bg-slate-700 cursor-not-allowed text-slate-500 dark:text-slate-400'
                       }}">

                            @if($isGenap)

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4v16m8-8H4" />

                            </svg>

                            Simpan Data Transkip

                            @else

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.5 10.5V8a4.5 4.5 0 0 0-9 0v2.5m-1.5 0h12A1.5 1.5 0 0 1 19.5 12v7A1.5 1.5 0 0 1 18 20.5H6A1.5 1.5 0 0 1 4.5 19v-7A1.5 1.5 0 0 1 6 10.5Z" />

                            </svg>

                            Semester Ganjil

                            @endif

                        </button>

                    </div>

                </div>

            </form>
        </div>
        {{-- TABLE --}}
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">


            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">

                {{-- =========================================================
        HEADER
    ========================================================== --}}
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                        {{-- TITLE --}}
                        <div class="flex items-center gap-3">

                            <div
                                class="flex items-center justify-center w-11 h-11 rounded-xl
                           bg-blue-50 dark:bg-blue-900/30
                           text-blue-600 dark:text-blue-400">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                    Data Transkip
                                </h2>

                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Kelola data transkip nilai siswa
                                </p>

                            </div>

                        </div>


                        {{-- TOTAL --}}
                        <div class="flex items-center gap-2">

                            <span class="text-sm text-slate-500 dark:text-slate-400">
                                Total data
                            </span>

                            <span
                                class="inline-flex items-center px-3 py-1.5
                           rounded-lg
                           bg-slate-100 dark:bg-slate-700
                           text-slate-700 dark:text-slate-200
                           text-sm font-semibold">

                                {{ $dataTranskip->total() }}

                            </span>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
        FILTER
    ========================================================== --}}
                <form
                    method="GET"
                    action="{{ url()->current() }}"
                    class="px-6 py-4 bg-slate-50/70 dark:bg-slate-900/30
           border-b border-slate-200 dark:border-slate-700">

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">

                        {{-- SEARCH --}}
                        <div class="relative">

                            <div class="absolute inset-y-0 left-0 flex items-center pl-3
                        pointer-events-none">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-slate-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />

                                </svg>

                            </div>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Cari mapel, kelas..."
                                class="w-full pl-9 pr-4 py-2.5
                       text-sm
                       bg-white dark:bg-slate-800
                       border border-slate-200 dark:border-slate-600
                       rounded-xl
                       text-slate-700 dark:text-slate-200
                       placeholder:text-slate-400
                       focus:ring-2 focus:ring-blue-500/20
                       focus:border-blue-500
                       outline-none">

                        </div>


                        {{-- KELAS --}}
                        <select
                            name="kelasmi_id"
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5
                   text-sm
                   bg-white dark:bg-slate-800
                   border border-slate-200 dark:border-slate-600
                   rounded-xl
                   text-slate-700 dark:text-slate-200
                   focus:ring-2 focus:ring-blue-500/20
                   focus:border-blue-500
                   outline-none">

                            <option value="">
                                Semua Kelas
                            </option>

                            @foreach ($kelasMi as $kelas)

                            <option
                                value="{{ $kelas->id }}"
                                @selected($kelasmiId==$kelas->id)>

                                {{ $kelas->nama_kelas }}

                            </option>

                            @endforeach

                        </select>


                        {{-- JENIS UJIAN --}}
                        <select
                            name="jenis_ujian_id"
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5
                   text-sm
                   bg-white dark:bg-slate-800
                   border border-slate-200 dark:border-slate-600
                   rounded-xl
                   text-slate-700 dark:text-slate-200
                   focus:ring-2 focus:ring-blue-500/20
                   focus:border-blue-500
                   outline-none">

                            <option value="">
                                Semua Jenis Ujian
                            </option>

                            @foreach ($dataJenisUjian as $ujian)

                            <option
                                value="{{ $ujian->id }}"
                                @selected($jenisUjianId==$ujian->id)>

                                {{ $ujian->nama_ujian }}

                            </option>

                            @endforeach

                        </select>


                        {{-- MAPEL --}}
                        <select
                            name="mapel_id"
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5
                   text-sm
                   bg-white dark:bg-slate-800
                   border border-slate-200 dark:border-slate-600
                   rounded-xl
                   text-slate-700 dark:text-slate-200
                   focus:ring-2 focus:ring-blue-500/20
                   focus:border-blue-500
                   outline-none">

                            <option value="">
                                Semua Mapel
                            </option>

                            @foreach ($dataMapel as $mapel)

                            <option
                                value="{{ $mapel->id }}"
                                @selected($mapelId==$mapel->id)>

                                {{ $mapel->mapel }}

                            </option>

                            @endforeach

                        </select>


                        {{-- BUTTON --}}
                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="flex-1 px-4 py-2.5
                       bg-blue-600 hover:bg-blue-700
                       text-white
                       rounded-xl
                       text-sm font-medium
                       transition">

                                Cari

                            </button>


                            @if ($search || $kelasmiId || $jenisUjianId || $mapelId)

                            <a
                                href="{{ url()->current() }}"
                                class="inline-flex items-center justify-center
                           px-4 py-2.5
                           bg-white dark:bg-slate-800
                           border border-slate-200 dark:border-slate-600
                           hover:bg-slate-100 dark:hover:bg-slate-700
                           text-slate-600 dark:text-slate-300
                           rounded-xl
                           text-sm font-medium
                           transition">

                                Reset

                            </a>

                            @endif

                        </div>

                    </div>

                </form>

                {{-- =========================================================
        TABLE
    ========================================================== --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        {{-- TABLE HEADER --}}
                        <thead
                            class="bg-slate-50 dark:bg-slate-900/50
                       border-b border-slate-200 dark:border-slate-700">

                            <tr>

                                <th class="px-5 py-3.5 text-center
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    No
                                </th>

                                <th class="px-5 py-3.5 text-left
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Periode
                                </th>

                                <th class="px-5 py-3.5 text-center
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Kelas
                                </th>

                                <th class="px-5 py-3.5 text-center
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Jenis Ujian
                                </th>

                                <th class="px-5 py-3.5 text-left
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Mata Pelajaran
                                </th>

                                <th class="px-5 py-3.5 text-center
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Peserta
                                </th>

                                <th class="px-5 py-3.5 text-center
                               text-xs font-semibold uppercase
                               tracking-wide
                               text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        {{-- TABLE BODY --}}
                        <tbody
                            class="divide-y divide-slate-100 dark:divide-slate-700">

                            @forelse ($dataTranskip as $item)

                            <tr
                                class="group
                               hover:bg-slate-50/80
                               dark:hover:bg-slate-700/30
                               transition-colors duration-150">

                                {{-- NO --}}
                                <td class="px-5 py-4 text-center">

                                    <span class="text-slate-500 dark:text-slate-400">
                                        {{ $dataTranskip->firstItem() + $loop->index }}
                                    </span>

                                </td>


                                {{-- PERIODE --}}
                                <td class="px-5 py-4">

                                    <a
                                        href="{{ url('/nilai_transkip/' . $item->id) }}"
                                        class="group/link inline-flex flex-col">

                                        <span
                                            class="font-medium text-blue-600
                                           dark:text-blue-400
                                           hover:text-blue-700
                                           dark:hover:text-blue-300">

                                            {{ $item->periode }}

                                        </span>

                                        <span
                                            class="text-xs text-slate-400
                                           dark:text-slate-500 mt-0.5">

                                            {{ $item->ket_semester }}

                                        </span>

                                    </a>

                                </td>


                                {{-- KELAS --}}
                                <td class="px-5 py-4 text-center">

                                    <span
                                        class="inline-flex items-center
                                       px-2.5 py-1
                                       rounded-lg
                                       bg-slate-100 dark:bg-slate-700
                                       text-slate-700 dark:text-slate-200
                                       font-medium">

                                        {{ $item->nama_kelas ?? '-' }}

                                    </span>

                                </td>


                                {{-- JENIS UJIAN --}}
                                <td class="px-5 py-4 text-center">

                                    @php
                                    $ujianClass = match (strtolower($item->nama_ujian)) {
                                    'praktek' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-300',
                                    'tulis' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300',
                                    default => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                                    };
                                    @endphp

                                    <span
                                        class="inline-flex items-center
                                       px-2.5 py-1 rounded-lg
                                       text-xs font-semibold
                                       {{ $ujianClass }}">

                                        {{ $item->nama_ujian }}

                                    </span>

                                </td>


                                {{-- MAPEL --}}
                                <td class="px-5 py-4">

                                    <div class="font-medium text-slate-700 dark:text-slate-200">
                                        {{ $item->mapel }}
                                    </div>

                                </td>


                                {{-- PESERTA --}}
                                <td class="px-5 py-4 text-center">

                                    <span
                                        class="inline-flex items-center gap-1.5
                                       px-3 py-1.5
                                       rounded-full
                                       bg-blue-50 dark:bg-blue-900/20
                                       text-blue-700 dark:text-blue-300
                                       font-semibold text-xs">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-3.5 h-3.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 20h5v-2a4 4 0 0 0-4-4h-1M9 20H4v-2a4 4 0 0 1 4-4h1m4-9a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm5 3a3 3 0 1 0 0-6" />

                                        </svg>

                                        {{ $item->nilai_transkip_count }} siswa

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- LIHAT --}}
                                        <a
                                            href="{{ url('/nilai_transkip/' . $item->id) }}"
                                            title="Lihat data"
                                            class="inline-flex items-center justify-center
                                           w-9 h-9
                                           rounded-lg
                                           bg-blue-50 hover:bg-blue-100
                                           dark:bg-blue-900/20
                                           dark:hover:bg-blue-900/40
                                           text-blue-600 dark:text-blue-400
                                           transition">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />

                                                <circle cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    stroke-width="2" />

                                            </svg>

                                        </a>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ url('/daftar-transkip/' . $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data transkip ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus data"
                                                class="inline-flex items-center justify-center
                                               w-9 h-9
                                               rounded-lg
                                               bg-red-50 hover:bg-red-100
                                               dark:bg-red-900/20
                                               dark:hover:bg-red-900/40
                                               text-red-600 dark:text-red-400
                                               transition">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.917 21H8.084a2.25 2.25 0 0 1-2.244-1.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.104 0c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.604 0a48.11 48.11 0 0 0-7.604 0" />

                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="w-14 h-14 flex items-center justify-center
                                           rounded-2xl
                                           bg-slate-100 dark:bg-slate-700
                                           text-slate-400">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-7 h-7"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                            </svg>

                                        </div>

                                        <h3
                                            class="mt-4 font-medium
                                           text-slate-700 dark:text-slate-200">

                                            Belum ada data transkip

                                        </h3>

                                        <p
                                            class="mt-1 text-sm
                                           text-slate-400 dark:text-slate-500">

                                            Data transkip belum tersedia untuk periode ini.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =========================================================
        FOOTER / PAGINATION
    ========================================================== --}}
                <div
                    class="px-6 py-4
               border-t border-slate-200 dark:border-slate-700">

                    <div class="flex flex-col md:flex-row
                    md:items-center md:justify-between gap-4">

                        {{-- INFO --}}
                        <div class="text-sm text-slate-500 dark:text-slate-400">

                            @if ($dataTranskip->total() > 0)

                            Menampilkan
                            <span class="font-semibold text-slate-700 dark:text-slate-200">
                                {{ $dataTranskip->firstItem() }}
                            </span>

                            -
                            <span class="font-semibold text-slate-700 dark:text-slate-200">
                                {{ $dataTranskip->lastItem() }}
                            </span>

                            dari
                            <span class="font-semibold text-slate-700 dark:text-slate-200">
                                {{ $dataTranskip->total() }}
                            </span>

                            data

                            @else

                            Tidak ada data

                            @endif

                        </div>


                        {{-- PAGINATION --}}
                        <div>
                            {{ $dataTranskip->onEachSide(1)->links() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>