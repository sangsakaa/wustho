<x-app-layout>
    <x-slot name="header">
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
                            labels: ['ULA', 'WUSTHO'],
                            datasets: [{
                                label: 'BERDASARKAN JENJANG',
                                data: [
                                    <?php echo json_encode($ula); ?>,
                                    <?php echo json_encode($wustho); ?>
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
        <div class=" p-4">
            <div class="">
                <center class=" text-center">{{$dataSiswaPeriode->periode}} {{$dataSiswaPeriode->ket_semester}}</center>
                <table class="  w-full text-sm">
                    <thead>
                        <tr>
                            <th class=" border text-center">No</th>
                            <th class=" border text-center">Kelas</th>
                            <th class=" border text-center">Nama Kelas</th>
                            <th class=" border text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($TitleKelas as $kelas)
                        <tr>
                            <th class=" border text-center">{{$loop->iteration}}</th>
                            <td class=" border text-center">{{$kelas->kelas}}</td>
                            <td class=" border text-center">{{$kelas->nama_kelas}}</td>
                            <td class=" border text-center">{{$kelas->total_siswa}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

            <div class="bg-neutral-50 py-3 px-5 dark:bg-neutral-700 dark:text-neutral-200">
                Total Murid : {{$dataSiswaPeriode->total_siswa}}

            </div>

            <canvas class="p-0" id="chartBar"></canvas>

            <!-- Required chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- Chart bar -->
            <script>
                const labelsBarChart = <?php echo json_encode($labels); ?>;
                const dataBarChart = {
                    labels: labelsBarChart,
                    datasets: [{
                        label: 'Data Murid',
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

</x-app-layout>