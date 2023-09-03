<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>

    <div class=" bg-white grid sm:grid-cols-2 grid-cols-1 px-2 py-2 gap-2">

        <div class="p-0 ">
            <div class=" px-2 font-semibold ">
                <canvas id="jenis_kelamin" class=" font-semibold"></canvas>
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
                                    'rgba(255,99, 132, 0.2)'
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
            </div>
        </div>
        <div class="p-0">
            <div class=" px-2 font-semibold ">
                <canvas id="madin" class=" font-semibold"></canvas>
                <script>
                    var ctx = document.getElementById('madin').getContext('2d');
                    var studentsChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['WUSTHO', 'ULA'],
                            datasets: [{
                                label: 'BERDASARKAN JENJANG',
                                data: [

                                    <?php echo json_encode($wustho); ?>,
                                    <?php echo json_encode($ula); ?>

                                ],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255,99, 132, 0.2)'
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

            </div>
        </div>
        <div class=" text-xs p-0">
            <canvas id="chart"></canvas>

            <script>
                var ctx = document.getElementById('chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($TitleKelas->pluck('nama_kelas')); ?>,
                        datasets: [{
                            label: 'Total Siswa',
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
        </div>
        <div class=" bg-white">
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

            <div class=" bg-white  px-5">

                <canvas class="p-0" id="chartBar"></canvas>

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
            </div>

        </div>

    </div>
    <div class=" grid sm:grid-cols-2 grid-cols-1">


        <div class="bg-white">
            <canvas id="chartx"></canvas>

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
        </div>
        <div class=" bg-white">

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <canvas id="tahunMasukChart"></canvas>

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


        </div>
    </div>


</x-app-layout>