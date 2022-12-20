<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class="px-6 py-2 overflow-hidden bg-white shadow-md dark:bg-dark-eval-1">
        {{ __("You're logged in!")  }} <br> <span class=" flex capitalize">
            User Log : {{Auth::user()->name}}
        </span>
    </div>
    <div class=" grid grid-cols-1 gap-2 sm:grid-cols-6 p-4">
        <div class="  bg-green-700 p-3 rounded-md text-center text-white">NIS : {{$siswa}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">USER : {{Auth::user()->count()}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">LK : {{$lk}}</div>
        <div class=" bg-pink-600 p-3 rounded-md text-center text-white">PR : {{$pr}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">PA : {{$pa}}</div>
        <div class=" bg-pink-600 p-3 rounded-md text-center text-white">PI : {{$pi}}</div>
    </div>
    <div class=" px-4">
        <div class="shadow-lg rounded-lg overflow-hidden">
            <div class="py-3 px-5 bg-gray-50">Line chart</div>
            <canvas class="p-10" id="chartLine"></canvas>
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
                    data: [0, 10, 5, 2, 20, 1, 45],
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