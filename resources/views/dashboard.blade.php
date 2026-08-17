<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Dashboard Akademik
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Monitoring data akademik & kelulusan siswa
                </p>
            </div>


        </div>
    </x-slot>

    @php
    $kelasLabels = $dataSiswaPerKelas->pluck('kelas');
    $kelasData = $dataSiswaPerKelas->pluck('total');

    $jkLabels = $jenisKelamin->pluck('kelas');
    $jkLaki = $jenisKelamin->pluck('laki');
    $jkPerempuan = $jenisKelamin->pluck('perempuan');

    $tahunLabels = $tahunMasuk->pluck('tahun');
    $tahunData = $tahunMasuk->pluck('total');

    $masukLulusLabels = $grafikMasukLulus->pluck('tahun');
    $masukChart = $grafikMasukLulus->pluck('masuk');
    $lulusChart = $grafikMasukLulus->pluck('lulus');
    $belumLulusChart = $grafikMasukLulus->pluck('belum_lulus');
    @endphp

    <div class="min-h-screen dark:bg-slate-900 p-4 md:p-6 space-y-6">

        {{-- INFO MADRASAH --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">
                Madrasah Diniyah Takmiliyah {{ $TitleMadrasak->jenjang ?? '-' }}
            </h3>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                {{ $TitleMadrasak->periode ?? '-' }} • {{ $TitleMadrasak->ket_semester ?? '-' }}
            </p>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white dark:bg-slate-800 rounded-3xl border shadow-sm p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-slate-500">Total Siswa</p>
                        <h2 class="text-3xl font-bold mt-2 text-slate-800 dark:text-white">
                            {{ $siswaStats->total ?? 0 }}
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-xl">
                        👥
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-3xl border shadow-sm p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-blue-700 dark:text-blue-300">Laki-laki</p>
                        <h2 class="text-3xl font-bold mt-2 text-blue-700 dark:text-white">
                            {{ $siswaStats->laki ?? 0 }}
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-xl">
                        👦
                    </div>
                </div>
            </div>

            <div class="bg-pink-50 dark:bg-pink-900/20 rounded-3xl border shadow-sm p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-pink-700 dark:text-pink-300">Perempuan</p>
                        <h2 class="text-3xl font-bold mt-2 text-pink-700 dark:text-white">
                            {{ $siswaStats->perempuan ?? 0 }}
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-xl">
                        👧
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-3xl border shadow-sm p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-amber-700 dark:text-amber-300">Semester Aktif</p>
                        <h2 class="text-lg font-bold mt-2 text-amber-700 dark:text-white">
                            {{ $TitleMadrasak->ket_semester ?? '-' }}
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-xl">
                        📅
                    </div>
                </div>
            </div>
        </div>

        {{-- TIMELINE --}}
        {{-- TIMELINE AKADEMIK --}}
        <div class="bg-white dark:bg-slate-800
            rounded-3xl
            border border-slate-200 dark:border-slate-700
            shadow-sm p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-6">

                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                        Progress Akademik Siswa
                    </h3>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Monitoring perkembangan peserta didik pada periode aktif
                    </p>
                </div>

                <span
                    class="inline-flex items-center px-3 py-1.5
                   rounded-lg
                   bg-slate-100 dark:bg-slate-700
                   text-xs font-medium
                   text-slate-600 dark:text-slate-300">

                    Periode Aktif

                </span>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                @foreach($timeline as $item)

                <div
                    class="group relative overflow-hidden
                       bg-slate-50 dark:bg-slate-700/30
                       border border-slate-100 dark:border-slate-700
                       rounded-2xl p-5
                       transition-all duration-200
                       hover:shadow-md
                       hover:-translate-y-0.5">

                    {{-- TOP --}}
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium
                                  text-slate-500 dark:text-slate-400">

                                {{ $item['title'] }}

                            </p>
                        </div>

                        <span
                            class="text-sm font-bold
                               text-slate-700 dark:text-slate-200">

                            {{ $item['progress'] }}%

                        </span>

                    </div>


                    {{-- TOTAL --}}
                    <div class="mt-4">

                        <span
                            class="text-3xl font-bold
                               text-slate-800 dark:text-white">

                            {{ number_format($item['count']) }}

                        </span>

                        <span class="ml-1 text-sm text-slate-400">
                            siswa
                        </span>

                    </div>


                    {{-- PROGRESS BAR --}}
                    <div class="mt-5">

                        <div
                            class="h-2 w-full
                               rounded-full
                               bg-slate-200 dark:bg-slate-600
                               overflow-hidden">

                            @if($item['color'] === 'blue')

                            <div
                                class="h-full bg-blue-500 rounded-full transition-all duration-500"
                                style="width: {{ min($item['progress'], 100) }}%">
                            </div>

                            @elseif($item['color'] === 'violet')

                            <div
                                class="h-full bg-violet-500 rounded-full transition-all duration-500"
                                style="width: {{ min($item['progress'], 100) }}%">
                            </div>

                            @elseif($item['color'] === 'emerald')

                            <div
                                class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                                style="width: {{ min($item['progress'], 100) }}%">
                            </div>

                            @else

                            <div
                                class="h-full bg-slate-500 rounded-full transition-all duration-500"
                                style="width: {{ min($item['progress'], 100) }}%">
                            </div>

                            @endif

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>
        {{-- CHART SECTION --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @foreach ([
            ['chartKelas', 'Siswa per Kelas'],
            ['chartJK', 'Jenis Kelamin per Kelas'],
            ['chartTahun', 'Statistik Tahun Masuk'],
            ['chartMasukLulus', 'Masuk vs Lulus vs Belum Lulus'],
            ] as $chart)
            <div class="bg-white dark:bg-slate-800 rounded-3xl border shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 dark:text-white mb-4">
                    {{ $chart[1] }}
                </h3>

                <div class="h-80">
                    <canvas id="{{ $chart[0] }}"></canvas>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#64748b'
                    }
                }
            }
        };

        new Chart(document.getElementById('chartKelas'), {
            type: 'bar',
            data: {
                labels: @json($kelasLabels),
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: @json($kelasData),
                    backgroundColor: '#3b82f6',
                    borderRadius: 10
                }]
            },
            options
        });

        new Chart(document.getElementById('chartJK'), {
            type: 'bar',
            data: {
                labels: @json($jkLabels),
                datasets: [{
                        label: 'Laki-laki',
                        data: @json($jkLaki),
                        backgroundColor: '#3b82f6'
                    },
                    {
                        label: 'Perempuan',
                        data: @json($jkPerempuan),
                        backgroundColor: '#ec4899'
                    }
                ]
            },
            options
        });

        new Chart(document.getElementById('chartTahun'), {
            type: 'line',
            data: {
                labels: @json($tahunLabels),
                datasets: [{
                    label: 'Siswa Masuk',
                    data: @json($tahunData),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.15)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options
        });

        new Chart(document.getElementById('chartMasukLulus'), {
            type: 'line',
            data: {
                labels: @json($masukLulusLabels),
                datasets: [{
                        label: 'Masuk',
                        data: @json($masukChart),
                        borderColor: '#3b82f6'
                    },
                    {
                        label: 'Lulus',
                        data: @json($lulusChart),
                        borderColor: '#10b981'
                    },
                    {
                        label: 'Belum Lulus',
                        data: @json($belumLulusChart),
                        borderColor: '#ef4444'
                    }
                ]
            },
            options
        });
    </script>
</x-app-layout>