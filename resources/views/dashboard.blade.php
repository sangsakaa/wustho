<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" px-2 font-semibold bg-white ">
        <div class=" grid grid-cols-1 gap-2 p-1 sm:p-5 uppercase text-sm">
            <div class="  w-full flex">
                <div class=" bg-green-800 w-1"></div>
                <div class=" bg-green-300 w-full  p-2 sm:p-5 ">
                    <p>madrasah diniyah {{$TitleMadrasak->jenjang}}</p>
                    <p>{{$TitleMadrasak->periode}} {{$TitleMadrasak->ket_semester}}</p>
                </div>
            </div>
            <div class=" grid grid-cols-3 gap-2">

                <div class="  w-full flex">
                    <div class=" bg-green-800 w-1"></div>
                    <div class=" bg-green-300 w-full  p-5 ">
                        <span>Laki Laki : {{$countLakiLaki}}</span>
                    </div>
                </div>
                <div class="  w-full flex">
                    <div class=" bg-green-800 w-1"></div>
                    <div class=" bg-green-300 w-full  p-5 ">
                        <span>Perempuan : {{$countPerempuan}}</span>
                    </div>
                </div>
                <div class=" bg-green-300 rounded-md p-5">
                    @if($ula)
                    <span> Total : <br> {{$ula}}</span>
                    @elseif($wustho)
                    <span> Total : {{$wustho}}</span>
                    @else
                    <span> Total : {{$ulya}}</span>
                    @endif
                </div>
            </div>
            <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div>
                    <canvas id="chart"></canvas>
                </div>
                <div>
                    <canvas class="p-0" id="chartBar"></canvas>
                </div>
                <div>
                    <canvas id="chartx"></canvas>
                </div>
                <div>
                    <canvas id="tahunMasukChart"></canvas>
                </div>
                <div>
                    <!-- <canvas id="madin" class=" font-semibold"></canvas> -->
                </div>
            </div>
        </div>
    </div>
    <!-- <canvas id="jenis_kelamin" class="font-semibold"></canvas> -->
    <script>
        var ctx = document.getElementById('jenis_kelamin').getContext('2d');
        var studentsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'BERDASARKAN JENIS KELAMIN',
                    data: [
                        <?php echo json_encode($countLakiLaki); ?>,
                        <?php echo json_encode($countPerempuan); ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('madin').getContext('2d');
        var datasets = [];

        <?php if ($ula) : ?>
            datasets.push({
                label: 'ULA',
                data: [<?php echo json_encode($ula); ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            });
        <?php endif; ?>

        <?php if ($wustho) : ?>
            datasets.push({
                label: 'WUSTHO',
                data: [<?php echo json_encode($wustho); ?>],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            });
        <?php endif; ?>

        <?php if ($ulya) : ?>
            datasets.push({
                label: 'ULYA',
                data: [<?php echo json_encode($ulya); ?>],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            });
        <?php endif; ?>

        var studentsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['JENJANG'],
                datasets: datasets
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($TitleKelas->pluck('nama_kelas')); ?>,
                datasets: [{
                    label: 'Berdasakan Kelas',
                    data: <?php echo json_encode($TitleKelas->pluck('total_siswa')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

    @php
    $labels = [];
    $dataSiswa = [];
    $colors = [];

    // Array warna yang akan digunakan
    $colorArray = ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"];

    foreach($dataSiswaPerKelas as $index => $data) {
    $labels[] = $data->kelas;
    $dataSiswa[] = $data->total_siswa;
    // Mengambil warna dari array warna sesuai dengan indeks data
    $colors[] = $colorArray[$index];
    }
    @endphp
    <!-- Required chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart bar -->
    <script>
        const labelsBarChart = <?php echo json_encode($labels); ?>;
        const dataBarChart = {
            labels: labelsBarChart,
            datasets: [{
                label: 'Data Murid Bedasarkan Kelas',
                backgroundColor: <?php echo json_encode($colors); ?>,
                borderColor: "hsl(217, 57%, 51%)",
                data: <?php echo json_encode($dataSiswa); ?>,
            }]
        };

        const configBarChart = {
            type: "bar",
            data: dataBarChart,
            options: {}
        };

        var chartBar = new Chart(
            document.getElementById("chartBar"),
            configBarChart
        );
    </script>
    <script>
        var ctx = document.getElementById('chartx').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jenisKelamin->unique('kelas')->pluck('kelas')); ?>,
                datasets: [{
                        label: 'Laki-Laki',
                        data: <?php echo json_encode($jenisKelamin->where('jenis_kelamin', 'L')->pluck('total_siswa')); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Perempuan',
                        data: <?php echo json_encode($jenisKelamin->where('jenis_kelamin', 'P')->pluck('total_siswa')); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var tahunMasukData = @json($tahunMasuk);

        var tahunMasukChart = new Chart(document.getElementById('tahunMasukChart'), {
            type: 'bar',
            data: {
                labels: tahunMasukData.map(data => data.tahun_masuk),
                datasets: [{
                    label: 'Tahun Angkatan',
                    data: tahunMasukData.map(data => data.total_siswa),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</x-app-layout>