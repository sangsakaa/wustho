<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white grid grid-cols-2 px-2 py-2 gap-2">
        <div class="shadow-lg rounded-lg overflow-hidden">
            <div class="py-3 px-5 bg-purple-600 text-white font-semibold uppercase">Line chart ketidak hadiran</div>
            <canvas class=" uppercase " id="chartLine"></canvas>
        </div>
        <!-- Required chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Chart line -->
        <script>
            const datasets = <?php echo json_encode($datasetsAbsensi); ?>;

            const data = {
                datasets,

            };

            const configLineChart = {
                type: "line",
                data,
                options: {
                    parsing: {
                        xAxisKey: 'tgl',
                        yAxisKey: 'tidak_hadir'
                    }
                },
            };

            var chartLine = new Chart(
                document.getElementById("chartLine"),
                configLineChart
            );
        </script>

    </div>



</x-app-layout>