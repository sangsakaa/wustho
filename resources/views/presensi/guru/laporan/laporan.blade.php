<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold sm:text-xl leading-tight text-sm">

            {{ __(' Laporan Presensi Guru (' . $tanggal->isoFormat('dddd, D MMMM YYYY')) . ')' }}
        </h2>
    </x-slot>
    <div class="pb-1 pt-2">

        <div class="">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 ">
                    <div class=" px-2 grid grid-cols-2">

                        <div>
                            <form action="/laporan-harian-guru" method="get" class="mr-auto">
                                <input type="date" name="tanggal" class="py-1 dark:bg-dark-bg" value="{{ $tanggal->toDateString() }}">
                                <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                    Pilih Tanggal
                                </button>
                            </form>
                        </div>
                        <div class=" py-1 flex gap-2  justify-end ">
                            <a href="/sesi-presensi-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Kembali
                            </a>
                            <a href="/laporan-harian-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                refresh
                            </a>


                        </div>
                    </div>
                    <div class=" grid grid-cols-1  justify-items-end">

                        <table class=" w-1/2">
                            <thead>
                                <tr class=" border border-green-800 px-1 text-center">
                                    <th class=" border border-green-800 px-1 text-center" colspan="5">Keterangan</th>

                                </tr>
                                <tr class=" border border-green-800 px-1 text-center">
                                    <th class=" border border-green-800 px-1 text-center">Hadir</th>
                                    <th class=" border border-green-800 px-1 text-center">Sakit</th>
                                    <th class=" border border-green-800 px-1 text-center">Izin</th>
                                    <th class=" border border-green-800 px-1 text-center">Alfa</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class=" border border-green-800 text-center">
                                    <td class=" border border-green-800 text-center">{{ $Hadir}}</td>
                                    <td class=" border border-green-800 text-center">{{ $Sakit}}</td>
                                    <td class=" border border-green-800 text-center">{{ $Izin}}</td>
                                    <td class=" border border-green-800 text-center">{{ $Alfa}}</td>
                                </tr>
                                <tr class=" border border-green-800 px-1 text-center">
                                    <th class=" border border-green-800 px-1 text-center">Hadir</th>
                                    <th class=" border border-green-800 px-1 text-center">Sakit</th>
                                    <th class=" border border-green-800 px-1 text-center">Izin</th>
                                    <th class=" border border-green-800 px-1 text-center">Alfa</th>
                                </tr>
                                <tr class=" border border-green-800 px-1 text-center">
                                    <td class=" border border-green-800 px-1 text-center">{{ number_format($presentasiHadir, 2) }}%</td>
                                    <td class=" border border-green-800 px-1 text-center">{{ number_format($presentasiSakit, 2) }}%</td>
                                    <td class=" border border-green-800 px-1 text-center">{{ number_format($presentasiIzin, 2) }}%</td>
                                    <td class=" border border-green-800 px-1 text-center">{{ number_format($presentasiAlfa, 2) }}%</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>
                    <table class=" mt-2 px-2 w-full">
                        <thead>
                            <tr class="border bg-gray-200 dark:bg-purple-600 text-xs sm:text-sm">
                                <th class=" border px-1  py-1">No</th>
                                <th class=" border px-1 ">Tanggal</th>
                                <th class=" border px-1 ">Daftar Guru Yang Terjadwal</th>
                                <th class=" border px-1 ">Kelas</th>
                                <th class=" border px-1 ">Keterangan</th>
                                <th class=" border px-1 ">Alasan</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporanGuru as $list)
                            <tr class=" even:bg-gray-100">
                                <th class=" border px-1 text-center">{{$loop->iteration}}</th>
                                <td class=" border px-1 text-center">
                                    {{ $list->tanggal}}
                                </td>
                                <td class=" border px-1 text-left">
                                    {{ $list->nama_guru}}
                                </td>
                                <td class=" border px-1 text-center">
                                    {{ $list->nama_kelas}}
                                </td>
                                <td class="  capitalize border px-1 text-center">
                                    {{ $list->keterangan}}
                                </td>
                                <td class=" capitalize border px-1 text-center">
                                    {{ $list->alasan}}
                                </td>

                            </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="my-1">
        <div class="">
            <div class=" bg-sky-200 dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-6  ">
                    <p class=" font-semibold">Keterangan : </p>
                    <p class=" px-2">1. Nilai diambail dari <b class=" underline">Ulangan Harian dan Ujian Akhir
                            Semester</b></p>
                    <p class=" px-2 capitalize">2. Untuk pengisian nilai jika tidak ada harap kosongkan form penilaian
                    </p>
                    <p class=" px-2 capitalize">3. Untuk pengisinan nilai <b><u>harus</u></b> memasukan peserta kelas
                        terlebih dahulu di menu kelas</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>