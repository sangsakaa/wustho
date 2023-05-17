<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan' )

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard kegiatan') }}
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
                    <center>
                        <div class=" block sm:hidden">
                            <p class=" font-semibold text-xs  sm:text-2xl text-green-800">
                                MADRASAH DINIYAH WUSTHO WAHIDIYAH
                            </p>
                            <p class=" font-semibold text-xs  sm:text-md text-green-800">
                                LAPORAN PLOTING JADWAL PELAJARAN
                            </p>
                            <p class=" font-semibold text-xs  sm:text-md uppercase text-green-800">
                                TAHUN PELAJARAN

                            </p>
                        </div>
                    </center>
                    <hr class=" border-b-2   border-b-green-700">
                    <div class=" overflow-auto ">
                        <table class=" w-full mb-10 ">
                            <thead>
                                <tr class=" border font-semibold border-green-800">
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">No</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800 w-1/4 sm:w-1/4">Nama Guru</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">Periode</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">Semester</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">Jumlah Mapel</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">Jumlah Soal</th>
                                    <th class="text-xs  sm:text-sm border font-semibold border-green-800">HR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan as $data)
                                @if($data->jumlah_kelas >= 1)
                                <tr class="border text-xs  sm:text-sm border-green-800 text-center">
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-left {{ $data->jumlah_kelas+1 <= 1 ? 'text-red-600 font-semibold' : '' }}">{{ $data->nama_guru }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center">{{ $data->periode }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center">{{ $data->ket_semester }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center {{ $data->jumlah_kelas+1 <= 1 ? 'text-red-600' : '' }}">{{ $data->jumlah_kelas*2 }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center">{{ $data->jumlah_mapel }}</td>
                                    <td class="px-1 border text-xs  sm:text-sm border-green-800 text-center">{{ 'Rp.' . number_format($data->jumlah_kelas * 30000) }}</td>
                                </tr>
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="6" class=" border border-green-800 text-center">Total HR</td>
                                    <td class=" border border-green-800 text-center">{{'Rp.'.number_format($laporan->sum('jumlah_kelas')*30000)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>