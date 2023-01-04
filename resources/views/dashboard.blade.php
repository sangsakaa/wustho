<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white grid grid-cols-2 px-2 py-2 gap-2">
        <div class="">
            <div class="p-4">
                <div class=" px-2 font-semibold ">
                    <canvas id="jenis_kelamin" class=" font-semibold"></canvas>
                    <script>
                        var ctx = document.getElementById('jenis_kelamin').getContext('2d');
                        var studentsChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Laki-laki', 'Perempuan'],
                                datasets: [{
                                    label: 'Berdasarkan Jenis Kelamin',
                                    data: [
                                        <?php echo json_encode($countPerempuan); ?>,
                                        <?php echo json_encode($countLakiLaki); ?>
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
        </div>
    </div>

</x-app-layout>