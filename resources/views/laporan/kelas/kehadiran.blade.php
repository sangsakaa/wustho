<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Utama' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Laporan Kehadiran') }}
            </h2>

        </div>
    </x-slot>
    <div>
        {{$lapKehadiran}}
    </div>
    <div class=" bg-white grid sm:grid-cols-2 grid-cols-1 px-2 py-2 gap-2">

        <canvas id="chart"></canvas>

        <script>
            var lapKehadiran = <?php echo $lapKehadiran ?>;
            var data = {
                labels: [],
                datasets: [{
                        label: 'Hadir',
                        backgroundColor: 'rgba(75,192,192,0.4)',
                        borderColor: 'rgba(75,192,192,1)',
                        borderWidth: 1,
                        data: []
                    },
                    {
                        label: 'Alfa',
                        backgroundColor: 'rgba(255,99,132,0.4)',
                        borderColor: 'rgba(255,99,132,1)',
                        borderWidth: 1,
                        data: []
                    },
                    {
                        label: 'Izin',
                        backgroundColor: 'rgba(255,206,86,0.4)',
                        borderColor: 'rgba(255,206,86,1)',
                        borderWidth: 1,
                        data: []
                    },
                    {
                        label: 'Sakit',
                        backgroundColor: 'rgba(54,162,235,0.4)',
                        borderColor: 'rgba(54,162,235,1)',
                        borderWidth: 1,
                        data: []
                    }
                ]
            };

            lapKehadiran.forEach(function(item) {
                data.labels.push(item.nama_kelas);
                data.datasets[0].data.push(item.hadir_count);
                data.datasets[1].data.push(item.alfa_count);
                data.datasets[2].data.push(item.izin_count);
                data.datasets[3].data.push(item.sakit_count);
            });

            var chart = new Chart(document.getElementById("chart"), {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });
        </script>


    </div>


</x-app-layout>