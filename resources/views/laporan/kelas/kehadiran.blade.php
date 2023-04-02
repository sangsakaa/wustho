<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Laporan Kehadiran') }}
            </h2>

        </div>
    </x-slot>
    <div class=" p-4 my-1 bg-white">
        <div>
            <button class=" flex w-10 justify-center text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                <x-icons.print></x-icons.print>
            </button>
        </div>
        <script>
            function printContent(el) {
                var fullbody = document.body.innerHTML;
                var printContent = document.getElementById(el).innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = fullbody;
            }
        </script>
    </div>

    <div id="div1">

        <div class=" bg-white p-4">
            <center>
                <div class=" uppercase text-green-800">
                    <p class=" text-2xl">MADRASAH DINIYAH WUSTHO WAHIDIYAH</p>
                    <p class=" text-3xl">Laporan Kehadiran</p>
                    <p>
                        {{$titlePeriode->periode}}
                        {{$titlePeriode->ket_semester}}

                    </p>
                </div>

            </center>
            <!-- Include Chart.js library -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- Create canvas element for the chart -->
            <canvas id="myChart"></canvas>

            <script>
                // Get data from PHP variable
                var data = <?php echo json_encode($laporan); ?>;

                // Extract data into arrays for labels and values
                var labels = [];
                var hadir = [];
                var alfa = [];
                var izin = [];
                var sakit = [];
                for (var i = 0; i < data.length; i++) {
                    labels.push(data[i].asrama);
                    hadir.push(data[i].hadir.toFixed(0));
                    alfa.push(data[i].alfa.toFixed(0));
                    izin.push(data[i].izin.toFixed(0));
                    sakit.push(data[i].sakit.toFixed(0));
                }

                // Create chart using Chart.js
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Hadir',
                            data: hadir,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Alfa',
                            data: alfa,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Izin',
                            data: izin,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Sakit',
                            data: sakit,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class=" p-4 bg-white">

            <!-- Include Chart.js library -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- Create canvas element for the chart -->
            <canvas id="myChartKelas"></canvas>

            <script>
                // Get data from PHP variable
                var data = <?php echo json_encode($laporanKelas); ?>;

                // Extract data into arrays for labels and values
                var labels = [];
                var hadir = [];
                var alfa = [];
                var izin = [];
                var sakit = [];
                for (var i = 0; i < data.length; i++) {
                    labels.push(data[i].kelasmi);
                    hadir.push(data[i].hadir.toFixed(0));
                    alfa.push(data[i].alfa.toFixed(0));
                    izin.push(data[i].izin.toFixed(0));
                    sakit.push(data[i].sakit.toFixed(0));
                }

                // Create chart using Chart.js
                var ctx = document.getElementById('myChartKelas').getContext('2d');
                var myChartKelas = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Hadir',
                            data: hadir,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Alfa',
                            data: alfa,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Izin',
                            data: izin,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Sakit',
                            data: sakit,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>