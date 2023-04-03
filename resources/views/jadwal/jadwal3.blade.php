<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal' )

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard kegiatan') }}
        </h2>
    </x-slot>
    <div class="px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/Daftar-Jadwal" class=" py-1 px-2 bg-red-600 text-white ">Daftar Jadwal</a>
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                        Cetak
                    </button>
                </div>
            </div>
        </div>
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
    <div id="blanko" class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-sm sm:text-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    <center>
                        <p class=" font-semibold text-2xl text-green-800">
                            MADRASAH DINIYAH WUSTHO WAHIDIYAH
                        </p>
                        <p class=" font-semibold text-3xl text-green-800">
                            JADWAL PELAJARAN
                        </p>
                        <p class=" font-semibold uppercase text-green-800">
                            TAHUN PELAJARAN
                            {{$datakelasmi->periode}} {{$datakelasmi->ket_semester}}
                        </p>
                    </center>
                    <hr class=" border-b-2   border-b-green-700">
                    <span class="   font-semibold ">Kelas : 3</span>
                    <table class=" mb-4  w-full">
                        <thead>
                            <tr class=" border text-sm">
                                <th class=" border text-sm border-green-800 py-2">Hari</th>
                                <th class=" border text-sm border-green-800">ID</th>
                                <th class=" border text-sm border-green-800">Nama Kelas</th>
                                <th class=" border text-sm border-green-800">Kelas</th>
                                <th class=" border text-sm border-green-800">Mapel</th>
                                <th class=" border text-sm border-green-800">Nama Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalByDayMap3 as $hari => $jadwals)
                            <tr class=" border text-sm border-green-800 capitalize text-center">
                                <td class=" border text-sm border-green-800 capitalize text-center" rowspan="{{ count($jadwals) }}">{{ $hari }}</td>
                                @foreach ($jadwals as $key => $jadwal)
                                @if ($key > 0)
                            <tr class=" border text-sm border-green-800 capitalize text-center even:bg-gray-100">
                                @endif
                                <td class=" border text-sm border-green-800 capitalize text-center py-1">{{ $jadwal->id }}</td>
                                <td class=" border text-sm border-green-800 capitalize text-center">{{ $jadwal->nama_kelas }}</td>
                                <td class=" border text-sm border-green-800 capitalize text-center">{{ $jadwal->kelas }}</td>
                                <td class=" border text-sm border-green-800 capitalize text-center">{{ $jadwal->mapel }}</td>
                                <td class=" border text-sm border-green-800 capitalize text-center">{{ $jadwal->nama_guru }}</td>
                                @if ($key == 0)
                            </tr>
                            @endif
                            @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>