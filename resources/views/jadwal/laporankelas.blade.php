<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Kelas' )

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard kegiatan Kelas') }}
        </h2>
    </x-slot>
    <div class="px-4 py-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" p-2 gap-2  flex  bg-white border-b border-gray-200">
                <div>
                    <a href="/Daftar-Jadwal" class=" py-1 px-2 bg-red-600 text-white ">Jadwal</a>
                </div>
                <div>
                    <button class=" bg-red-600  dark:bg-purple-600 w-full rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
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
            <div class="bg-white overflow-hidden  sm:rounded-lg text-sm sm:text-sm">
                <div class="p-2 bg-white  border-gray-200 ">
                    @if($Periode !== null )
                    <center>
                        <div class=" ">
                            <p class=" font-semibold sm:text-xs  text-2xl text-green-800">
                                MADRASAH DINIYAH WUSTHO WAHIDIYAH
                            </p>
                            <p class=" font-semibold sm:text-xs  text-lg text-green-800">
                                LAPORAN PLOTING GURU
                            </p>
                            <p class=" font-semibold text-xs  sm:text-md uppercase text-green-800">
                                TAHUN PELAJARAN
                                @if($Periode !== null )
                                {{$Periode->periode}} {{$Periode->ket_semester}}
                                @else

                                @endif
                            </p>
                        </div>
                    </center>
                    <hr class=" border-b-2   border-b-green-700">
                    <div class=" overflow-auto ">
                        <div class=" grid grid-cols-2">
                            <div>Jumla Kelas</div>
                            <div> : {{$Periode->jumlah_kelas}}</div>
                            <div>Jumlah Mata Pelajaran</div>
                            <div> : {{$Periode->jumlah_mapel}}</div>
                        </div>
                        <table class=" w-full ">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="border border-green-800 text-center py-1">No</th>
                                    <th rowspan="2" class="border border-green-800 text-center py-1">Nama Guru</th>
                                    <th colspan="{{$laporan->pluck('nama_kelas')->unique()->count();}}" class="border border-green-800 text-center py-1">Kelas</th>
                                    <th rowspan="2" class="border border-green-800 py-1">Jumlah <br> Mapel</th>
                                    <th rowspan="2" class="border border-green-800 py-1 ">Jumlah <br> Kelas</th>
                                </tr>
                                <tr>
                                    @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
                                    <th class="border border-green-800 py-1">{{ $nama_kelas }}</th>
                                    @endforeach


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan->pluck('nama_guru')->unique()->sort() as $nama_guru)
                                <tr>
                                    <td class="border border-green-800 text-center">{{ $loop->iteration }}</td>
                                    <td class="border border-green-800 py-1 px-1">{{ $nama_guru }}</td>
                                    @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
                                    <td class="border  
@if ($laporan->where('nama_guru', $nama_guru)->where('nama_kelas', $nama_kelas)->sum('jumlah_mapel') > 0)
border-green-800 bg-green-200 
@endif
 border-green-800
text-center">
                                        {{ $laporan->where('nama_guru', $nama_guru)->where('nama_kelas', $nama_kelas)->sum('jumlah_mapel') }}
                                    </td>
                                    @endforeach
                                    <td class="border border-green-800 text-center">{{ $laporan->where('nama_guru', $nama_guru)->sum('jumlah_mapel') }}</td>
                                    <td class="border border-green-800 text-center">{{ $laporan->where('nama_guru', $nama_guru)->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>





                    </div>
                    @else
                    <span>
                        Tidak Ada Ploting Guru
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>