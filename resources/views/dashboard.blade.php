<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white grid sm:grid-cols-2 grid-cols-1 px-2 py-2 gap-2">
        <div class="p-4 ">
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
        <div class="p-4">
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
            <div class="bg-white rounded-lg shadow-md">
                <canvas id="angkatan-chart" class="h-64"></canvas>
            </div>
            <script>
                var ctx = document.getElementById('angkatan-chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys($dataAngkatan),
                        datasets: [{
                            label: 'Angkatan',
                            data: Object.values($dataAngkatan),
                            backgroundColor: '#3490dc',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        legend: {
                            labels: {
                                fontColor: 'black',
                                fontSize: 14,
                                fontFamily: 'sans-serif',
                                fontStyle: 'bold'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Angkatan',
                            fontColor: 'black',
                            fontSize: 18,
                            fontFamily: 'sans-serif',
                            fontStyle: 'bold'
                        }
                    }
                });
            </script>

        </div>

    </div>

</x-app-layout>