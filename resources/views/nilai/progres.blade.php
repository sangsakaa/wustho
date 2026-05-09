<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Progress')
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Progress Nilai
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-100 dark:bg-slate-900 p-4 sm:p-6 space-y-6">

        {{-- HEADER CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border p-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                Monitoring Progress Penilaian
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                Pantau progress input nilai harian dan ujian setiap kelas
            </p>
        </div>

        {{-- ACTION --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border p-4">
            <div class="flex flex-col sm:flex-row gap-4 sm:justify-between sm:items-center">

                <div class="flex flex-wrap gap-2">
                    <a href="/nilaimapel"
                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                        Nilai Mapel
                    </a>

                    <a href="/juara-pararel"
                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">
                        Kelas 3
                    </a>
                </div>

                <form action="/progress-nilai" method="get" class="flex gap-2">
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari kelas..."
                        class="rounded-xl border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button type="submit"
                        class="px-4 py-2 rounded-xl bg-slate-800 dark:bg-slate-700 text-white hover:opacity-90 transition">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

            @foreach ($data->groupBy('kelas') as $kelas => $kelasData)
            @php
            $totalPesertaKelas = $kelasData->sum('jumlah_peserta_kelas');
            $totalNilaiHarian = $kelasData->sum('jumlah_nilai_harian');
            $totalNilaiUjian = $kelasData->sum('jumlah_nilai_ujian');

            $presentaseNilaiHarian = $totalPesertaKelas > 0
            ? ($totalNilaiHarian / $totalPesertaKelas) * 100
            : 0;

            $presentaseNilaiUjian = $totalPesertaKelas > 0
            ? ($totalNilaiUjian / $totalPesertaKelas) * 100
            : 0;
            @endphp

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border p-5">

                {{-- TITLE --}}
                <div class="mb-4">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                        {{ $kelas }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Total Peserta: {{ $totalPesertaKelas }}
                    </p>
                </div>

                {{-- NILAI HARIAN --}}
                <div class="space-y-2 mb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Nilai Harian</span>
                        <span class="font-semibold text-blue-600">
                            {{ number_format($presentaseNilaiHarian, 0) }}%
                        </span>
                    </div>

                    <div class="w-full h-3 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-3 bg-blue-500 rounded-full"
                            style="width: {{ $presentaseNilaiHarian }}%">
                        </div>
                    </div>
                </div>

                {{-- NILAI UJIAN --}}
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Nilai Ujian</span>
                        <span class="font-semibold text-emerald-600">
                            {{ number_format($presentaseNilaiUjian, 0) }}%
                        </span>
                    </div>

                    <div class="w-full h-3 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-3 bg-emerald-500 rounded-full"
                            style="width: {{ $presentaseNilaiUjian }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>