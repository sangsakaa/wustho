<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama')
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Dashboard</h2>
        </div>
    </x-slot>

    <div class="p-4 space-y-4 bg-gray-100 dark:bg-dark-bg">

        {{-- HEADER INFO --}}
        <div class="bg-white rounded-2xl shadow p-4">
            <h3 class="text-lg font-bold">
                Madrasah Diniyah Takmiliyah {{ $TitleMadrasak->jenjang ?? '-' }}
            </h3>
            <p class="text-gray-500 text-sm">
                {{ $TitleMadrasak->periode ?? '-' }} - {{ $TitleMadrasak->ket_semester ?? '-' }}
            </p>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl shadow p-4">
                <p class="text-sm text-gray-500">Total Siswa</p>
                <h2 class="text-2xl font-bold">{{ $siswaStats->total ?? 0 }}</h2>
            </div>

            <div class="bg-blue-100 rounded-2xl p-4">
                <p>Laki-laki</p>
                <h2 class="text-xl font-bold">{{ $siswaStats->laki ?? 0 }}</h2>
            </div>

            <div class="bg-pink-100 rounded-2xl p-4">
                <p>Perempuan</p>
                <h2 class="text-xl font-bold">{{ $siswaStats->perempuan ?? 0 }}</h2>
            </div>

            <div class="bg-green-100 rounded-2xl p-4">
                <p>Jenjang</p>
                <h2 class="text-sm font-bold">
                    Ula: {{ $siswaStats->ula ?? 0 }} |
                    W: {{ $siswaStats->wustho ?? 0 }} |
                    Ulya: {{ $siswaStats->ulya ?? 0 }}
                </h2>
            </div>

        </div>

        {{-- CHART --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-white rounded-2xl shadow p-4">
                <h3 class="font-semibold mb-2">Siswa per Kelas</h3>
                <canvas id="chartKelas"></canvas>
            </div>

            <div class="bg-white rounded-2xl shadow p-4">
                <h3 class="font-semibold mb-2">Jenis Kelamin per Kelas</h3>
                <canvas id="chartJK"></canvas>
            </div>

            <div class="bg-white rounded-2xl shadow p-4 md:col-span-2">
                <h3 class="font-semibold mb-2">Tahun Masuk</h3>
                <canvas id="chartTahun"></canvas>
            </div>

        </div>

    </div>

    {{-- ======================
        PREPARE DATA (ANTI ERROR PRETTIER)
    ====================== --}}
    @php
    $kelasLabels = $dataSiswaPerKelas->pluck('kelas');
    $kelasData = $dataSiswaPerKelas->pluck('total');

    $jkLabels = $jenisKelamin->pluck('kelas');
    $jkLaki = $jenisKelamin->pluck('laki');
    $jkPerempuan = $jenisKelamin->pluck('perempuan');

    $tahunLabels = $tahunMasuk->pluck('tahun');
    $tahunData = $tahunMasuk->pluck('total');
    @endphp

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const kelasLabels = @json($kelasLabels);
        const kelasData = @json($kelasData);

        const jkLabels = @json($jkLabels);
        const jkLaki = @json($jkLaki);
        const jkPerempuan = @json($jkPerempuan);

        const tahunLabels = @json($tahunLabels);
        const tahunData = @json($tahunData);

        // ======================
        // CHART KELAS
        // ======================
        new Chart(document.getElementById('chartKelas'), {
            type: 'bar',
            data: {
                labels: kelasLabels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: kelasData,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // ======================
        // CHART JENIS KELAMIN
        // ======================
        new Chart(document.getElementById('chartJK'), {
            type: 'bar',
            data: {
                labels: jkLabels,
                datasets: [{
                        label: 'Laki-laki',
                        data: jkLaki,
                    },
                    {
                        label: 'Perempuan',
                        data: jkPerempuan,
                    }
                ]
            },
            options: {
                responsive: true
            }
        });

        // ======================
        // CHART TAHUN MASUK
        // ======================
        new Chart(document.getElementById('chartTahun'), {
            type: 'line',
            data: {
                labels: tahunLabels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: tahunData,
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</x-app-layout>