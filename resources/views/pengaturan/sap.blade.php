<x-app-layout>
    <x-slot name="header">
        @if($kelasmi)
        @section('title', '| SAP KELAS : '. $kelasmi->nama_kelas)
        @endif
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Satuan Acara Pembelajaran') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">

            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-2 w-full sm:grid-cols-2  gap-2">
                    <div class=" w-full">
                        <form action="/sap" method="get" class="w-full">
                            <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/2 py-1 dark:bg-dark-bg" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($dataKelasMi as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                    {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                                </option>
                                @endforeach
                            </select>
                            <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Pilih Kelas
                            </button>
                        </form>
                    </div>
                    <div class=" justify-end grid">
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                            Cetak
                        </button>
                    </div>
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
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <div>
    </div>
    @if($kelasmi)
    <div class="py-1" id="blanko">
        <div class="px-2 bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
            @foreach ($dataMapel as $mapel)
            <div class=" p-1 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg  ">
                    <div class=" text-center text-green-900  tracking-wider flex">
                        <div class=" py-1">
                            <img src={{ asset("asset/images/logo.png") }} alt="" width="90" class=" ">
                        </div>
                        <div class=" w-full py-1">

                            <p class=" font-semibold text-1xl  uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>
                            <p class=" text-2xl uppercase font-semibold">Satuan Acara Pembelajaran</p>
                            <p class=" font-semibold uppercase">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                        </div>
                    </div>
                    <hr class=" border-b-2 border-green-800">
                    <div class=" grid grid-cols-4 text-green-800">
                        <div class=" text-sm text-green-800 mt-1 font-semibold">
                            KELAS
                        </div>
                        <div class=" font-semibold">
                            : {{ $kelasmi->nama_kelas }}
                        </div>
                        <div class=" text-sm text-green-800 font-semibold">
                            MATA PELAJARAN
                        </div>
                        <div class=" font-semibold">
                            : {{ $mapel->mapel }}
                        </div>
                        <div class=" text-sm text-green-800 font-semibold">
                            GURU MAPEL
                        </div>
                        <div class=" font-semibold">
                            : {{ $mapel->nama_guru }}
                        </div>
                        <div class=" text-sm text-green-800 font-semibold">
                            HARI
                        </div>
                        <div class=" font-semibold capitalize ">
                            : {{ strtolower($mapel->hari )}}
                        </div>
                    </div>
                    <table class="table-fixed w-full text-green-800">
                        <thead class="border border-b-2 border-green-600">
                            <tr class="border  border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1 w-8" rowspan="2">NO</th>
                                <th class="border border-green-600 px-1 w-1/5">

                                    TANGGAL KBM
                                </th>
                                <th class="border border-green-600 px-1 text-xs" colspan="2">NILAI TUGAS</th>
                                <?php
                                // Pastikan variabel $mapel->hari memiliki nilai yang benar
                                $hari = strtolower($mapel->hari); // Ambil hari dari objek $mapel dan ubah menjadi huruf kecil
                                $tanggal_awal = Illuminate\Support\Carbon::parse($kelasmi->tanggal_mulai); // Gunakan $tanggal_awal sebagai tanggal awal

                                // Tambahkan hari yang diperlukan berdasarkan $mapel->hari
                                switch ($hari) {
                                    case 'jumat':
                                        $tanggal_awal->modify('next friday');
                                        break;
                                    case 'sabtu':
                                        $tanggal_awal->modify('next saturday');
                                        break;
                                    case 'minggu':
                                        $tanggal_awal->modify('next sunday');
                                        break;
                                    case 'senin':
                                        $tanggal_awal->modify('next monday');
                                        break;
                                    case 'selasa':
                                        $tanggal_awal->modify('next tuesday');
                                        break;
                                    case 'rabu':
                                        $tanggal_awal->modify('next wednesday');
                                        break;
                                    default:
                                        // Tindakan jika $mapel->hari tidak valid
                                        break;
                                }

                                $jumlah_hari = 17; // Pastikan variabel $jumlah_hari memiliki nilai yang benar

                                if ($tanggal_awal instanceof Illuminate\Support\Carbon) {

                                    for ($hari = 0; $hari < $jumlah_hari; $hari++) {
                                        echo '<th class="border border-green-600 px-1 text-xs">' . '' .
                                            // $tanggal_awal->format('d/m ') . 
                                            '</th>';
                                        $tanggal_awal->modify('+7 days'); // Menambahkan 7 hari ke tanggal_awal
                                    }
                                }
                                ?>

                                <th></th>
                            </tr>
                            <tr class="border border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1">NAMA</th>
                                <th class="border border-green-600 px-1">1</th>
                                <th class="border border-green-600 px-1">2</th>
                                @for ($i = 1; $i <= 18; $i++) <th class="border border-green-600 px-1 text-xs">PERT {{ $i }}</th>
                                    @endfor
                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            @foreach ($dataSiswa as $siswa)
                            <tr class=" border border-green-600 text-xs sm:text-sm even:bg-gray-100 ">
                                <td class="border border-green-600 text-center px-1 text-xs">{{ $loop->iteration }}</td>
                                <td class="border border-green-600 px-1 py-2 text-xs capitalize">{{ strtolower($siswa->nama_siswa) }}</td>
                                @for ($i = 0; $i < 20; $i++) <td class="border border-green-600 px-1">
                                    </td>
                                    @endfor
                            </tr>
                            @endforeach
                            @for ($i = $dataSiswa->count(); $i < 40; $i++) <tr class="border border-green-600 text-xs sm:text-sm {{ $i % 2 == 0 ? 'even:bg-gray-100' : '' }}">
                                <td class="border border-green-600 text-center px-1 py-2 h-2 text-xs">{{$i+1}}</td>
                                @for ($x = 0; $x < 21; $x++) <td class="border border-green-600 px-1 py-2 text-xs capitalize">
                                    </td>
                                    @endfor
                                    </tr>
                                    @endfor

                        </tbody>
                    </table>
                    <div class="break-after-page"></div>
                    <div>
                        <div class=" text-center text-green-900  tracking-wider flex">
                            <div class=" py-1">
                                <img src={{ asset("asset/images/logo.png") }} alt="" width="90" class=" ">
                            </div>
                            <div class=" w-full py-1">

                                <p class=" font-semibold text-1xl uppercase">
                                    MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                </p>
                                <p class=" text-2xl uppercase font-semibold">Satuan Acara Pembelajaran</p>
                                <p class=" font-semibold uppercase">
                                    TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                </p>
                            </div>
                        </div>
                        <hr class=" border-b-2 border-green-800">
                        <div class=" grid grid-cols-4 text-green-800">
                            <div class=" text-sm text-green-800 mt-1 font-semibold">
                                KELAS
                            </div>
                            <div class=" font-semibold">
                                : {{ $kelasmi->nama_kelas }}
                            </div>
                            <div class=" text-sm text-green-800 font-semibold">
                                MATA PELAJARAN
                            </div>
                            <div class=" font-semibold">
                                : {{ $mapel->mapel }}
                            </div>
                            <div class=" text-sm text-green-800 font-semibold">
                                GURU MAPEL
                            </div>
                            <div class=" font-semibold">
                                : {{ $mapel->nama_guru }}
                            </div>
                            <div class=" text-sm text-green-800 font-semibold">
                                HARI
                            </div>
                            <div class=" font-semibold capitalize ">
                                : {{ strtolower($mapel->hari )}}
                            </div>

                        </div>
                    </div>
                    <div class=" grid grid-cols-2 gap-2">
                        <div>
                            <table class=" mt-1 w-full border text-sm">
                                <thead>
                                    <tr class=" text-green-800">
                                        <th class=" border border-green-600 w-5  text-center">No</th>
                                        <th class=" border border-green-600">Hari / Tangggal</th>
                                        <th class=" border border-green-600 px-1">Pert Ke </th>
                                        <th class=" border border-green-600">Materi</th>
                                        <th class=" border border-green-600">Rincian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < 10; $i++) <tr class=" text-green-800">
                                        <td class="border border-green-600 py-4  text-center">{{$i}}</td>
                                        <td class="border border-green-600   w-36">

                                        </td>
                                        <td class="border border-green-600  w-5  text-center capitalize font-semibold">Pert {{$i}}</td>
                                        <td class="border border-green-600  w-1/4"></td>
                                        <td class="border border-green-600 "></td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <table class=" mt-1 w-full border text-sm">
                                <thead>
                                    <tr class=" text-green-800">
                                        <th class=" border border-green-600 w-5  text-center">No</th>
                                        <th class=" border border-green-600">Hari / Tangggal</th>
                                        <th class=" border border-green-600 px-1">Pert Ke </th>
                                        <th class=" border border-green-600">Materi</th>
                                        <th class=" border border-green-600">Rincian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 10; $i < 19; $i++) <tr class=" text-green-800">
                                        <td class="border border-green-600 py-4  text-center">{{$i}}</td>
                                        <td class="border border-green-600   w-36">

                                        </td>
                                        <td class="border border-green-600  w-5  text-center capitalize font-semibold">Pert {{$i}}</td>
                                        <td class="border border-green-600  w-1/4"></td>
                                        <td class="border border-green-600 "></td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="break-after-page"></div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
</x-app-layout>