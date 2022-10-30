<x-app-layout>
    <x-slot name="header">
        @section('title', '| Rekap Absensi Kelas')
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Rekap Absensi Kelas') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/absensikelas/rekap-per-hari" method="get" class="w-full">
                        {{-- @csrf --}}
                        <input type="date" name="tgl" class=" py-1 dark:bg-dark-bg" value="{{ $tgl->toDateString() }}">
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Pilih
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
    @if($rekapAbsensi)
    <div class="py-1">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            <div class=" p-1 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg  ">
                    <div class=" text-center text-green-900">
                        <p class=" font-semibold text-3xl">
                            MADRASAH DINIYAH WUSTHA WAHIDIYAH
                        </p>
                        <p class=" font-semibold uppercase">
                            {{-- TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}} --}}
                        </p>
                    </div>
                    <hr class=" border-b-2 border-green-900">
                    <div class="  text-2xl text-center uppercase font-semibold">
                        Laporan Harian
                    </div>
                    <div class=" grid grid-cols-2">
                        <div class=" text-green-900 mt-1 text-sm font-semibold">
                            Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
                        </div>

                    </div>
                    <table class="table-fixed w-full text-green-900">
                        <thead class="border border-b-2 border-green-600">
                            <tr class="border  border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1 w-8">No</th>
                                <th class="border border-green-600 px-1 w-1/6 ">Asrama</th>
                                <th class="border border-green-600 px-1 w-9">Kls</th>
                                <th class="border border-green-600 px-1 w-11 ">Total</th>
                                <th class="border border-green-600 px-1">Tidak Hadir</th>
                                <th class="border border-green-600 px-1 w-11">Hadir</th>
                                <th class="border border-green-600 px-1 w-1/3 ">Yang tidak hadir</th>
                                <th class="border border-green-600 px-1">Ket</th>
                                <th class="border border-green-600 px-1 w-30 ">Presentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            @foreach ($rekapAbsensi as $nama_asrama => $dataAsrama)
                            @foreach ($dataAsrama as $nama_kelas => $dataKelas)
                            @php
                            $jumlahAbsen = $dataKelas['absensi']->count();
                            @endphp
                            @foreach ($dataKelas['absensi'] as $absensi )
                            <tr class=" border border-green-600 text-xs sm:text-sm ">
                                @if ($loop->first)
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ $loop->parent->iteration }}</td>
                                @endif
                                @if ($loop->parent->first && $loop->first)
                                <td class="border border-green-600 px-1 text-center text-sm" rowspan="{{ $dataAsrama->sum('tidakHadir') }}">{{ $nama_asrama }}</td>
                                @endif
                                @if ($loop->first)
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ $nama_kelas }}</td>
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ $dataKelas['total'] }}</td>
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ $dataKelas['tidakHadir'] }}</td>
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ $dataKelas['hadir'] }}</td>
                                @endif
                                <td class="border border-green-600 px-1">{{ $absensi->nama_siswa }}</td>
                                <td class="border border-green-600 px-1 capitalize">{{ $absensi->keterangan }}</td>
                                @if ($loop->first)
                                <td class="border border-green-600 text-center px-1" rowspan="{{ $jumlahAbsen }}">{{ number_format($dataKelas['persentase'], 1, ',') }}%</td>
                                @endif
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>