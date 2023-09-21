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
                    <form action="/blanko-pernyataan" method="get" class="w-full">
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
    <div class="p-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm  p-4" id="blanko">



            @foreach ($dataAbsensi->sortByDesc(function ($absensi) {
            $total_absensi = $absensi->hadir + $absensi->sakit + $absensi->alfa + $absensi->izin;
            return $total_absensi > 0 ? ($absensi->hadir / $total_absensi * 100) : 0;
            }) as $absensi)
            <style>
                .page-break {
                    page-break-after: always;
                }
            </style>
            @php
            $total_absensi = $absensi->hadir + $absensi->sakit + $absensi->alfa + $absensi->izin;
            $persentase_absensi = $absensi->hadir / $total_absensi * 100;
            @endphp
            @if($persentase_absensi < 75) <div class="">
                <div class=" text-center  text-sm">
                    <p>
                        PONDOK PESANTREN KEDUNGLO AL MUNADHDHOROH
                    </p>
                    <p class=" font-semibold">
                        MADRASAH DINIYAH <span class=" uppercase">
                            {{$absensi->jenjang}}
                        </span> WAHIDIYAH
                    </p>
                    <span>Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur</span>


                    <hr class=" border-b-2 border-green-900">
                    <p class=" underline py-2 uppercase font-semibold">Surat Pernyataan</p>
                </div>
                <p>Yang Bertanda Tangan di bawah ini:</p>
                <div class="capitalize grid grid-cols-2 text-sm">

                    <div>
                        Nama
                    </div>
                    <div>
                        : {{ $absensi->nama_siswa }}
                    </div>
                    <div>
                        Kelas
                    </div>
                    <div>
                        : {{ $absensi->nama_kelas }} /{{$absensi->nama_asrama}}
                    </div>
                </div>
                <div class=" text-sm">
                    Yang terhormat,

                    <p class=" ml-8 mt-2">
                        Saya, <span class=" font-semibold capitalize">{{strtolower($absensi->nama_siswa)}}</span>, dengan ini menyatakan kesanggupan dan komitmen saya
                    </p>
                    <p class="  text-justify ">
                        saya untuk :
                    <div class=" grid grid-cols-2 gap-2">
                        <div>
                            @foreach (range(1, 5) as $number)
                            <p>{{ $number }} . </p>
                            <hr>
                            @endforeach
                        </div>
                        <div>
                            <span class=" py-2">Detail Kehadiran</span>
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="border border-black">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-black">Hadir</th>
                                        <th class="border border-black">Izin</th>
                                        <th class="border border-black">Sakit</th>
                                        <th class="border border-black">Alfa</th>

                                        <th class="border border-black">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-black text-center">
                                            {{ $absensi->hadir !== 0 ? $absensi->hadir : '-' }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ $absensi->izin !== 0 ? $absensi->izin : '-' }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ $absensi->sakit !== 0 ? $absensi->sakit : '-' }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ $absensi->alfa !== 0 ? $absensi->alfa : '-' }}
                                        </td>
                                        <td class="border border-black text-center">
                                            {{ number_format($persentase_absensi, 0) }}%
                                            @if($persentase_absensi >= 75)
                                            <span class="font-semibold"> Tuntas</span>
                                            @else
                                            <span class="font-semibold text-red-600"> Belum Tuntas</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </p>
                    <p class="  text-justify mt-2">
                        Demikian surat pernyataan kesanggupan ini saya buat sebagai Syarat Mengikuti <span class=" font-semibold underline capitalize">ujian akhir semester {{$periode->ket_semester}} Periode {{$periode->periode}} {{$periode->ket_semester}}</span> dengan sadar dan tanpa paksaan. Saya siap untuk menerima sanksi yang berlaku apabila saya melanggar komitmen ini.
                    </p>
                    <p class=" text-justify mt-2 ml-8">
                        Atas perhatian dan pengertian Bapak/Ibu Kepala Madrasah Diniyah, saya ucapkan terima
                    </p>
                    <p>kasih.</p>
                </div>
                <div class="grid-cols-2 justify-end grid">
                    <div class=" text-sm mt-2">
                        <p>
                            Hormat saya,
                        </p>

                        <br><br><br>

                        <p class=" capitalize">
                            {{strtolower($absensi->nama_siswa)}}
                        </p>
                    </div>
                    <div class=" py-2 text-sm">

                        <div>
                            <p>Ketua Pondok</p>
                            <br><br><br>
                            <p>Afif Afandi,S.E</p>
                        </div>
                    </div>
                </div>
                <div class="page-break"></div>
                @endif
                @endforeach




        </div>
</x-app-layout>