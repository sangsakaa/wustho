<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Dashboard
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">
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

    <div class="min-h-screen bg-slate-100 dark:bg-slate-900 p-4 md:p-6 space-y-6">

        {{-- HEADER INFO --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">
                Madrasah Diniyah Takmiliyah {{ $TitleMadrasak->jenjang ?? '-' }}
            </h3>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                {{ $TitleMadrasak->periode ?? '-' }} • {{ $TitleMadrasak->ket_semester ?? '-' }}
            </p>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 shadow-sm border">
                <p class="text-sm text-slate-500">Total Siswa</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-800 dark:text-white">
                    {{ $siswaStats->total ?? 0 }}
                </h2>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-3xl p-5 shadow-sm border">
                <p class="text-sm text-blue-700 dark:text-blue-300">Laki-laki</p>
                <h2 class="mt-3 text-3xl font-bold text-blue-700 dark:text-white">
                    {{ $siswaStats->laki ?? 0 }}
                </h2>
            </div>

            <div class="bg-pink-50 dark:bg-pink-900/20 rounded-3xl p-5 shadow-sm border">
                <p class="text-sm text-pink-700 dark:text-pink-300">Perempuan</p>
                <h2 class="mt-3 text-3xl font-bold text-pink-700 dark:text-white">
                    {{ $siswaStats->perempuan ?? 0 }}
                </h2>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-3xl p-5 shadow-sm border">
                <p class="text-sm text-amber-700 dark:text-amber-300">Semester Aktif</p>
                <h2 class="mt-3 text-lg font-bold text-amber-700 dark:text-white">
                    {{ $TitleMadrasak->ket_semester ?? '-' }}
                </h2>
                <p class="mt-2 text-xs text-slate-500">
                    Periode {{ $TitleMadrasak->periode ?? '-' }}
                </p>
            </div>
        </div>

        {{-- TIMELINE --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Timeline Perjalanan Siswa
                </h3>
                <span class="text-xs text-slate-500">Monitoring proses akademik</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-5">
                @foreach ([
                ['👤', 'Registrasi'],
                ['🏠', 'Asrama'],
                ['📚', 'Kelas'],
                ['🕒', 'Presensi'],
                ['📝', 'Rapot'],
                ['🎓', 'Kelulusan'],
                ] as $item)
                <div class="text-center">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-2xl shadow-sm">
                        {{ $item[0] }}
                    </div>

                    <p class="mt-3 text-sm font-medium text-slate-700 dark:text-white">
                        {{ $item[1] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CHART SECTION --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- SISWA PER KELAS --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border p-6">
                <h3 class="font-semibold text-slate-800 dark:text-white mb-4">
                    Siswa per Kelas
                </h3>
                <div class="h-80">
                    <canvas id="chartKelas"></canvas>
                </div>
            </div>

            {{-- JK --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border p-6">
                <h3 class="font-semibold text-slate-800 dark:text-white mb-4">
                    Jenis Kelamin per Kelas
                </h3>
                <div class="h-80">
                    <canvas id="chartJK"></canvas>
                </div>
            </div>

            {{-- TAHUN MASUK --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border p-6 xl:col-span-2">
                <h3 class="font-semibold text-slate-800 dark:text-white mb-4">
                    Statistik Tahun Masuk
                </h3>
                <div class="h-80">
                    <canvas id="chartTahun"></canvas>
                </div>
            </div>

            {{-- MASUK VS LULUS --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border p-6 xl:col-span-2">
                <h3 class="font-semibold text-slate-800 dark:text-white mb-4">
                    Angkatan: Masuk vs Lulus vs Belum Lulus
                </h3>
                <div class="h-96">
                    <canvas id="chartMasukLulus"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART JS --}}
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
                        color: '#64748b',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#64748b'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#64748b'
                    },
                    grid: {
                        color: 'rgba(148,163,184,0.12)'
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
                    backgroundColor: 'rgba(59,130,246,0.8)',
                    borderRadius: 12
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
                        backgroundColor: 'rgba(59,130,246,0.8)',
                        borderRadius: 10
                    },
                    {
                        label: 'Perempuan',
                        data: @json($jkPerempuan),
                        backgroundColor: 'rgba(236,72,153,0.8)',
                        borderRadius: 10
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
                    borderColor: 'rgb(16,185,129)',
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
                        borderColor: 'rgb(59,130,246)',
                        backgroundColor: 'rgba(59,130,246,0.12)',
                        fill: true,
                        tension: 0.35
                    },
                    {
                        label: 'Lulus',
                        data: @json($lulusChart),
                        borderColor: 'rgb(16,185,129)',
                        backgroundColor: 'rgba(16,185,129,0.12)',
                        fill: true,
                        tension: 0.35
                    },
                    {
                        label: 'Belum Lulus',
                        data: @json($belumLulusChart),
                        borderColor: 'rgb(239,68,68)',
                        backgroundColor: 'rgba(239,68,68,0.12)',
                        fill: true,
                        tension: 0.35
                    }
                ]
            },
            options
        });
    </script>
</x-app-layout>