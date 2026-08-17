<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Nilai Transkip')
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Dashboard Nilai Transkip
            </h2>
            <p class="text-sm text-gray-500">
                Input dan pengelolaan nilai akhir peserta lulusan
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        {{-- =========================================================
        HEADER
    ========================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>

                <div class="flex items-center gap-2 text-sm text-slate-400 mb-2">

                    <a href="/daftar-transkip"
                        class="hover:text-blue-600 transition">
                        Daftar Transkip
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="m9 18 6-6-6-6" />

                    </svg>

                    <span class="text-slate-500 dark:text-slate-400">
                        Input Nilai
                    </span>

                </div>

                <h1 class="text-2xl font-bold tracking-tight
                       text-slate-800 dark:text-white">

                    Input Nilai Transkip

                </h1>

                <p class="mt-1 text-sm
                      text-slate-500 dark:text-slate-400">

                    Kelola nilai peserta didik berdasarkan mata pelajaran
                    dan jenis ujian.

                </p>

            </div>


            {{-- BACK BUTTON --}}
            <a
                href="/daftar-transkip"
                class="inline-flex items-center justify-center gap-2
                   px-4 py-2.5
                   rounded-xl
                   border border-slate-200 dark:border-slate-700
                   bg-white dark:bg-slate-800
                   text-sm font-medium
                   text-slate-600 dark:text-slate-300
                   hover:bg-slate-50 dark:hover:bg-slate-700
                   transition
                   shadow-sm">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.5 19.5 3 12l7.5-7.5M3 12h18" />

                </svg>

                Kembali

            </a>

        </div>


        {{-- =========================================================
        NAVIGATION
    ========================================================== --}}
        <div
            class="flex flex-wrap items-center gap-2
               p-2
               bg-white dark:bg-slate-800
               border border-slate-200 dark:border-slate-700
               rounded-2xl
               shadow-sm">

            {{-- PERIODE --}}
            <a
                href="/periode"
                class="inline-flex items-center gap-2
                   px-4 py-2.5
                   rounded-xl
                   text-sm font-medium
                   text-slate-600 dark:text-slate-300
                   hover:bg-slate-100 dark:hover:bg-slate-700
                   transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 9.75h18" />

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25Z" />

                </svg>

                Periode

            </a>


            {{-- PENGATURAN --}}
            <a
                href="/pengaturan"
                class="inline-flex items-center gap-2
                   px-4 py-2.5
                   rounded-xl
                   text-sm font-medium
                   text-slate-600 dark:text-slate-300
                   hover:bg-slate-100 dark:hover:bg-slate-700
                   transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.481.826 2.68 2.43a1.724 1.724 0 0 0 .0 3.03c.801 1.604-1.137 3.37-2.68 2.43a1.724 1.724 0 0 0-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.481-.826-2.68-2.43a1.724 1.724 0 0 0 0-3.03c-.801-1.604 1.137-3.37 2.68-2.43a1.724 1.724 0 0 0 2.573-1.066Z" />

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                </svg>

                Pengaturan

            </a>


            {{-- DAFTAR TRANSKIP --}}
            <a
                href="/daftar-transkip"
                class="inline-flex items-center gap-2
                   px-4 py-2.5
                   rounded-xl
                   bg-emerald-600
                   hover:bg-emerald-700
                   text-white
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />

                </svg>

                Daftar Transkip

            </a>

        </div>


        {{-- =========================================================
        RINGKASAN DATA TRANSKIP
    ========================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- MAPEL --}}
            <div
                class="relative overflow-hidden
                   bg-white dark:bg-slate-800
                   border border-slate-200 dark:border-slate-700
                   rounded-2xl
                   shadow-sm">

                <div class="p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase
                                  tracking-wider
                                  text-slate-400 dark:text-slate-500">

                                Mata Pelajaran

                            </p>

                            <h3 class="mt-2 text-xl font-bold
                                   text-slate-800 dark:text-white">

                                {{ $dataTranskip->mapel }}

                            </h3>

                        </div>

                        <div
                            class="flex items-center justify-center
                               w-11 h-11
                               rounded-xl
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
                                    d="M12 6.75c-1.88-1.5-4.5-2.25-7.5-2.25v13.5c3 0 5.62.75 7.5 2.25m0-13.5c1.88-1.5 4.5-2.25 7.5-2.25v13.5c-3 0-5.62.75-7.5 2.25m0-13.5v13.5" />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- JENIS UJIAN --}}
            <div
                class="relative overflow-hidden
                   bg-white dark:bg-slate-800
                   border border-slate-200 dark:border-slate-700
                   rounded-2xl
                   shadow-sm">

                <div class="p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase
                                  tracking-wider
                                  text-slate-400 dark:text-slate-500">

                                Jenis Ujian

                            </p>

                            <h3 class="mt-2 text-xl font-bold
                                   text-slate-800 dark:text-white">

                                {{ $dataTranskip->nama_ujian }}

                            </h3>

                        </div>

                        <div
                            class="flex items-center justify-center
                               w-11 h-11
                               rounded-xl
                               bg-violet-50 dark:bg-violet-900/30
                               text-violet-600 dark:text-violet-400">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
        KETENTUAN INPUT
    ========================================================== --}}
        <div
            class="overflow-hidden
               rounded-2xl
               border border-amber-200 dark:border-amber-800
               bg-amber-50/70 dark:bg-amber-900/10
               shadow-sm">

            <div class="p-5">

                <div class="flex items-start gap-4">

                    <div
                        class="flex-shrink-0
                           flex items-center justify-center
                           w-10 h-10
                           rounded-xl
                           bg-amber-100 dark:bg-amber-900/40
                           text-amber-600 dark:text-amber-400">

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

                        <h4 class="text-sm font-semibold
                               text-amber-800 dark:text-amber-300">

                            Ketentuan Input Nilai

                        </h4>

                        <p class="mt-1 text-sm
                              text-amber-700 dark:text-amber-400">

                            Nilai yang dimasukkan harus berada pada rentang

                            <span class="font-bold">
                                50 – 100
                            </span>.

                            Nilai di luar rentang tersebut tidak dapat
                            disimpan oleh sistem.

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
        @if(session('success'))

        <div
            class="flex items-start gap-3
                   p-4
                   rounded-xl
                   border border-emerald-200 dark:border-emerald-800
                   bg-emerald-50 dark:bg-emerald-900/20
                   text-emerald-700 dark:text-emerald-300">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 mt-0.5 flex-shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m5 12 4 4L19 6" />

            </svg>

            <div>

                <p class="text-sm font-semibold">
                    Berhasil
                </p>

                <p class="mt-0.5 text-sm">
                    {{ session('success') }}
                </p>

            </div>

        </div>

        @endif


        {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}
        @if($errors->any())

        <div
            class="overflow-hidden
                   rounded-xl
                   border border-red-200 dark:border-red-800
                   bg-red-50 dark:bg-red-900/20">

            <div class="p-4">

                <div class="flex items-start gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 mt-0.5 flex-shrink-0
                                text-red-600 dark:text-red-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />

                    </svg>


                    <div class="flex-1">

                        <h4 class="text-sm font-semibold
                                   text-red-800 dark:text-red-300">

                            Terdapat kesalahan

                        </h4>

                        <ul
                            class="mt-2
                                   list-disc
                                   list-inside
                                   space-y-1
                                   text-sm
                                   text-red-700 dark:text-red-400">

                            @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        @endif

        {{-- FORM --}}
        <form action="/nilai_transkip/{{ $transkip->id }}" method="POST">
            @csrf
            <input type="hidden" name="transkip_id" value="{{ $transkip->id }}">

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">
                        Input Nilai Peserta
                    </h3>

                    <div class="flex gap-2">
                        <a href="/daftar-transkip"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">
                            Kembali
                        </a>

                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium shadow-sm">
                            Simpan Nilai
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-1 text-center">No</th>
                                <th class="px-4 py-1 text-left">Nama Peserta</th>
                                <th class="px-4 py-1 text-center">Kelas</th>
                                <th class="px-4 py-1 text-center">Nilai Akhir</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($dataLulusan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-1 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-1">
                                    <input type="hidden" name="daftar_lulusan_id[]" value="{{ $item->id }}">
                                    <input type="hidden"
                                        name="nilai_transkip_id[{{ $item->id }}]"
                                        value="{{ $item->nilai_transkip_id }}">

                                    <span class="capitalize font-medium text-gray-700">
                                        {{ strtolower($item->nama_siswa) }}
                                    </span>
                                </td>

                                <td class="px-4 py-1 text-center">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="px-4 py-1">
                                    <input
                                        type="number"
                                        name="nilai_akhir[{{ $item->id }}]"
                                        value="{{ old('nilai_akhir.' . $item->id, $item->nilai_akhir) }}"
                                        min="50"
                                        max="100"
                                        placeholder="50 - 100"
                                        class="w-28 mx-auto block rounded-xl border-gray-300 text-center
                                        focus:border-blue-500 focus:ring-blue-500
                                        @error('nilai_akhir.' . $item->id) border-red-500 @enderror">

                                    @error('nilai_akhir.' . $item->id)
                                    <p class="text-xs text-red-500 text-center mt-1">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">
                                    Belum ada data peserta lulusan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>