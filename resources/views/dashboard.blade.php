<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama')
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="p-6 space-y-6 bg-gray-100 dark:bg-slate-900 min-h-screen">

        {{-- HEADER INFO --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-6 border border-gray-100 dark:border-slate-700">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                Madrasah Diniyah Takmiliyah {{ $TitleMadrasak->jenjang ?? '-' }}
            </h3>

            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                {{ $TitleMadrasak->periode ?? '-' }} • {{ $TitleMadrasak->ket_semester ?? '-' }}
            </p>
        </div>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- TOTAL --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-5 border">
                <p class="text-sm text-gray-500">Total Siswa</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                    {{ $siswaStats->total ?? 0 }}
                </h2>
            </div>

            {{-- LAKI --}}
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-2xl shadow-md p-5 border">
                <p class="text-sm text-blue-700 dark:text-blue-300">Laki-laki</p>
                <h2 class="text-3xl font-bold text-blue-800 dark:text-white mt-2">
                    {{ $siswaStats->laki ?? 0 }}
                </h2>
            </div>

            {{-- PEREMPUAN --}}
            <div class="bg-pink-50 dark:bg-pink-900/30 rounded-2xl shadow-md p-5 border">
                <p class="text-sm text-pink-700 dark:text-pink-300">Perempuan</p>
                <h2 class="text-3xl font-bold text-pink-800 dark:text-white mt-2">
                    {{ $siswaStats->perempuan ?? 0 }}
                </h2>
            </div>

            {{-- JENJANG --}}
            {{-- JENJANG --}}
            <div class="bg-green-50 dark:bg-green-900/30 rounded-2xl shadow-md p-5 border">
                <p class="text-sm text-green-700 dark:text-green-300">Jenjang</p>

                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                    {{ ($siswaStats->ula ?? 0) + ($siswaStats->wustho ?? 0) + ($siswaStats->ulya ?? 0) }}
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Total semua jenjang
                </p>
            </div>

        </div>

        {{-- CHART --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-5 border">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Siswa per Kelas
                </h3>
                <div class="h-80">
                    <canvas id="chartKelas"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-5 border">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Jenis Kelamin per Kelas
                </h3>
                <div class="h-80">
                    <canvas id="chartJK"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-5 border xl:col-span-2">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Tahun Masuk
                </h3>
                <div class="h-96">
                    <canvas id="chartTahun"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- DATA --}}
    @php
    $kelasLabels = $dataSiswaPerKelas->pluck('kelas');
    $kelasData = $dataSiswaPerKelas->pluck('total');

    $jkLabels = $jenisKelamin->pluck('kelas');
    $jkLaki = $jenisKelamin->pluck('laki');
    $jkPerempuan = $jenisKelamin->pluck('perempuan');

    $tahunLabels = $tahunMasuk->pluck('tahun');
    $tahunData = $tahunMasuk->pluck('total');
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const options = {
            responsive: true,
            maintainAspectRatio: false
        };

        new Chart(document.getElementById('chartKelas'), {
            type: 'bar',
            data: {
                labels: @json($kelasLabels),
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: @json($kelasData),
                    borderWidth: 1
                }]
            },
            options: {
                ...options,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        new Chart(document.getElementById('chartJK'), {
            type: 'bar',
            data: {
                labels: @json($jkLabels),
                datasets: [{
                        label: 'Laki-laki',
                        data: @json($jkLaki)
                    },
                    {
                        label: 'Perempuan',
                        data: @json($jkPerempuan)
                    }
                ]
            },
            options: options
        });

        new Chart(document.getElementById('chartTahun'), {
            type: 'line',
            data: {
                labels: @json($tahunLabels),
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: @json($tahunData),
                    tension: 0.4,
                    fill: true
                }]
            },
            options: options
        });
    </script>
</x-app-layout>