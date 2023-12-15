<x-app-layout>
    <x-slot name="header">
        @section('title', ' |Kalas : 1 Daftar Jadwal' )

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
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" mx-auto ">
            @if($datakelasmi)
            <div class="bg-white overflow-hidden  sm:rounded-lg text-sm sm:text-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    <center>
                        <p class=" font-semibold text-2xl text-green-800 uppercase">
                            MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
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
                    <hr class=" border-b  mt-0.5   border-b-green-700">

                    @php
                    $jadwalByKelas = [];

                    foreach ($jadwalByDayMap as $hari => $jadwals) {
                    foreach ($jadwals as $jadwal) {
                    $nama_kelas = $jadwal->nama_kelas;

                    if (!isset($jadwalByKelas[$nama_kelas][$hari])) {
                    $jadwalByKelas[$nama_kelas][$hari] = [];
                    }

                    $jadwalByKelas[$nama_kelas][$hari][] = [
                    'nama_guru' => $jadwal->nama_guru,
                    'kelas' => $jadwal->kelas,
                    'mapel' => $jadwal->mapel,
                    ];
                    }
                    }
                    @endphp

                    <table class="mb-4 mt-2 w-full">
                        <thead>
                            <tr>
                                <th class="  border text-sm border-green-800 uppercase" rowspan="2">Kelas</th>
                                <th class="  border text-sm border-green-800 uppercase" colspan="6">Hari</th>
                            </tr>
                            <tr class="border text-sm">

                                <?php
                                // Array asal
                                // Ubah urutan hari
                                $customOrder = ['jumat', 'sabtu', 'minggu', 'senin', 'selasa', 'rabu'];

                                // Urutkan array sesuai urutan yang ditentukan
                                $sortedJadwalByDayMap = [];
                                foreach ($customOrder as $hari) {
                                    if (isset($jadwalByDayMap[$hari])) {
                                        $sortedJadwalByDayMap[$hari] = $jadwalByDayMap[$hari];
                                    }
                                }

                                // Sekarang Anda dapat melakukan iterasi dengan urutan yang diinginkan
                                foreach ($sortedJadwalByDayMap as $hari => $jadwals) {
                                    echo '<th class="border text-sm border-green-800 uppercase">' . $hari . '</th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalByKelas as $nama_kelas => $jadwalsByHari)
                            <tr class=" even:bg-yellow-100 border text-sm border-green-800 capitalize text-center">
                                <td class="border text-lg font-semibold border-green-800">{{ $nama_kelas }}</td>
                                @foreach ($customOrder as $hari)
                                <td class="border text-sm border-green-800">
                                    @if (isset($jadwalsByHari[$hari]))
                                    @foreach ($jadwalsByHari[$hari] as $jadwal)
                                    <span class=" font-semibold  text-md-center uppercase">
                                        {{ $jadwal['mapel'] }}
                                    </span>
                                    <br>
                                    <span class=" text-sm ">{{ strtolower($jadwal['nama_guru']) }}

                                        @endforeach
                                        @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="page-break"></div>
                </div>
            </div>
            @else
            <div class=" px-4 bg-blue-300">
                <span>belum ada ploting guru dan mapel</span>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>