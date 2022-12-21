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
            <canvas class="" id="chartLine"></canvas>
        </div>
        <!-- Required chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Chart line -->
        <script>
            const labels = ["January", "February", "March", "April", "May", "June", "July"];
            const data = {
                labels: labels,
                datasets: [{
                    label: "My First dataset",
                    backgroundColor: "hsl(252, 82.9%, 67.8%)",
                    borderColor: "hsl(252, 82.9%, 67.8%)",
                    data: [0, 10, 5, 2, 20, 30, 45],
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