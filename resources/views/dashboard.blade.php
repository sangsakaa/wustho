<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white grid grid-cols-2 px-2 py-2">
        <div class="shadow-lg rounded-lg overflow-hidden">
            <div class="py-3 px-5 bg-purple-600 text-white font-semibold uppercase">Line chart</div>
            <canvas class="p-10" id="chartLine"></canvas>
        </div>
        {{$data[1]->nama_asrama}} {{$data[1]->kuota}}<br>
        {{$data[2]->nama_asrama}} {{$data[2]->kuota}}<br>
        {{$data[3]->nama_asrama}} {{$data[3]->kuota}}<br>
        {{$data[4]->nama_asrama}} {{$data[4]->kuota}}<br>
        {{$data[5]->nama_asrama}} {{$data[5]->kuota}}<br>
        {{$data[6]->nama_asrama}} {{$data[6]->kuota}}<br>
        {{$data[7]->nama_asrama}} {{$data[7]->kuota}}<br>
        {{$data[8]->nama_asrama}} {{$data[8]->kuota}}<br>
        {{$data[9]->nama_asrama}} {{$data[9]->kuota}}<br>

        <!-- Required chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Chart line -->
        <script>
            var x = data[0];
            const labels = ["January", "February", "March", "April", "May", "June", "July"];
            const data = {
                labels: labels,
                datasets: [{
                    label: x[0],
                    backgroundColor: "hsl(252, 82.9%, 67.8%)",
                    borderColor: "hsl(252, 82.9%, 67.8%)",
                    data: [0],
                }, ],
            };

            const configLineChart = {
                type: "line",
                data,
                options: {},
            };

            var chartLine = new Chart(
                document.getElementById("chartLine"),
                configLineChart
            );
        </script>
    </div>
</x-app-layout>