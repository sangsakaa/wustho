<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Nilai Guru')

        <div
            class="rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 text-white shadow-lg">
            <h2 class="text-2xl font-bold">
                Dashboard Detail Nilai Guru
            </h2>
            <p class="text-blue-100 mt-1">
                Monitoring aktivitas dan capaian nilai guru
            </p>
        </div>
    </x-slot>

    <div class="py-6 px-4 space-y-6">

        {{-- PROFIL GURU --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">

                <div class="flex flex-col md:flex-row items-center gap-5">

                    <div
                        class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-10 h-10 text-blue-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $title->nama_guru }}
                        </h3>

                        <p class="text-gray-500">
                            Nomor Induk Guru
                        </p>

                        <span
                            class="inline-block mt-2 px-4 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">
                            {{ $title->nig }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Mapel</p>
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ $dataguru->count() }}
                </h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Total Siswa</p>
                <h3 class="text-3xl font-bold text-green-600">
                    {{ $dataguru->sum('jumlah_peserta_kelas') }}
                </h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Nilai Harian</p>
                <h3 class="text-3xl font-bold text-amber-600">
                    {{ $dataguru->sum('jumlah_nilai_harian') }}
                </h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Nilai Ujian</p>
                <h3 class="text-3xl font-bold text-purple-600">
                    {{ $dataguru->sum('jumlah_nilai_ujian') }}
                </h3>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">

            <div class="px-6 py-4 border-b">
                <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                    Detail Nilai Mata Pelajaran
                </h3>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>
                        <tr class="bg-slate-100 dark:bg-slate-700">
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Mapel</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Peserta</th>
                            <th class="px-4 py-3">NH</th>
                            <th class="px-4 py-3">HU</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($dataguru as $guru)

                        <tr
                            class="border-b hover:bg-blue-50 dark:hover:bg-slate-700 transition">

                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">
                                    {{ $guru->periode }}
                                    {{ $guru->ket_semester }}
                                </span>
                            </td>

                            <td class="px-4 py-3">

                                <a href="/nilai/{{ $guru->id }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800">

                                    {{ $guru->mapel }}

                                </a>

                            </td>

                            <td class="px-4 py-3">

                                <span
                                    class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium">

                                    {{ $guru->nama_kelas }}

                                </span>

                            </td>

                            <td class="px-4 py-3 text-center font-bold">
                                {{ $guru->jumlah_peserta_kelas }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $guru->jumlah_nilai_harian }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $guru->jumlah_nilai_ujian }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7"
                                class="py-10 text-center text-gray-500">
                                Tidak ada data nilai guru
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</x-app-layout>