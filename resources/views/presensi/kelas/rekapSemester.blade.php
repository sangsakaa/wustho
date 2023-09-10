<x-app-layout>
    <x-slot name="header">
        @section('title', '| Rekap Semester : ' . $kelasmi?->nama_kelas)
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Rekap Semester') }} : {{ $kelasmi?->nama_kelas }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/absensikelas/rekap-semester" method="get" class="w-full">
                        <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/5 py-1 dark:bg-dark-bg">
                            <option value="">-- Semua --</option>
                            @foreach ($dataKelasMi as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Tampilkan
                        </button>
                    </form>
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
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
    <div class="py-1">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            <div class=" p-1 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg  ">
                    <div class=" text-center text-green-900">
                        <p class=" font-semibold text-3xl uppercase">
                            MADRASAH DINIYAH {{ $kelasmi?->jenjang }} WAHIDIYAH
                        </p>
                        <p class=" font-semibold uppercase">
                            TAHUN PELAJARAN {{$periode->periode}} {{$periode->ket_semester}}

                        </p>
                    </div>
                    <hr class=" border-b-2 border-green-900">
                    <div class=" grid grid-cols-4">
                        <div class=" text-sm text-green-900 mt-1 font-semibold">
                            KELAS
                        </div>
                        <div>
                            : {{ $kelasmi?->nama_kelas }}
                        </div>
                    </div>
                    <table class="table-fixed w-full text-green-900">
                        <thead class="border border-b-2 border-green-600">
                            <tr class="border  border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1 w-8">NO</th>
                                <th class="border border-green-600 px-1 w-1/2">NAMA SISWA</th>
                                <th class="border border-green-600 px-1 w-8">JK</th>

                                <th class="border border-green-600 px-1 w-16">KELAS</th>
                                <th class="border border-green-600 px-1 w-14 sm:w-14">HADIR</th>
                                <th class="border border-green-600 px-1 w-14 sm:w-14">IZIN</th>
                                <th class="border border-green-600 px-1 w-14 sm:w-14">SAKIT</th>
                                <th class="border border-green-600 px-1 w-14 sm:w-14">ALFA</th>
                                <th class="border border-green-600 px-1 w-14 ">%H</th>
                                <th class="border border-green-600 px-1 ">Status</th>
                            </tr>
                        </thead>
                        <tbody class=" text-xs sm:text-sm">
                            @foreach ($dataAbsensi->sortByDesc(function ($absensi) {
                            $total_absensi = $absensi->hadir + $absensi->sakit + $absensi->alfa + $absensi->izin;
                            return $total_absensi > 0 ? ($absensi->hadir / $total_absensi * 100) : 0;
                            }) as $absensi)
                            <tr class=" border border-green-600 odd:bg-white  even:bg-gray-200 ">
                                <td class="border border-green-600 text-center px-1">{{ $loop->iteration }}</td>
                                <td class="border border-green-600 px-1 capitalize">
                                    {{strtolower($absensi->nama_siswa) }}
                                </td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->jenis_kelamin }}</td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->nama_kelas }}</td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->hadir !== 0 ? $absensi->hadir : '-' }}</td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->izin !== 0 ? $absensi->izin : '-' }}</td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->sakit !== 0 ? $absensi->sakit : '-' }}</td>
                                <td class="border border-green-600 text-center px-1">{{ $absensi->alfa !== 0 ? $absensi->alfa : '-' }}</td>
                                <td class=" text-center border border-green-600">
                                    <?php
                                    $total_absensi = $absensi->hadir + $absensi->sakit + $absensi->alfa + $absensi->izin;
                                    $persentase_absensi = $absensi->hadir / $total_absensi * 100;
                                    echo  number_format($persentase_absensi, 0) . "%";
                                    ?>

                                </td>
                                <td class=" text-center border border-green-600">

                                    @if($persentase_absensi >= 75)
                                    <span class="  font-semibold "> Tutas</span>
                                    @else
                                    <span class="  font-semibold  text-red-600"> Belum Tuntas</span>
                                    @endif
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>