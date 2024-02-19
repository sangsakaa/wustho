<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Detail Siswa ') }}
        </h2>
    </x-slot>
    <div class="py-2 px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" sm:grid grid grid-cols-2 sm:grid-cols-4 overflow-auto  ">
                        <div class=" ">Nama </div>
                        <div class="  uppercase font-semibold   text-xs ">: {{$siswa->nama_siswa}}</div>
                        <div class=" ">Tempat </div>
                        <div class="  capitalize">: {{strtolower($siswa->tempat_lahir)}} ,{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</div>

                        <div class="  ">Jenis Kelamin </div>
                        <div class=" "> : {{$siswa->jenis_kelamin}}</div>
                        <div class="      ">Status Asrama </div>
                        <div class="    "> :
                            @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama !== null)
                            {{$siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama}}
                            @else
                            <span class=" text-red-600 ">Belum Memiliki Asrama</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" gap-2 sm:flex hidden ">
                        <div>
                            <a href="/siswa" class=" bg-blue-500 px-2 py-1  hover:bg-purple-500 text-white ">Kembali</a>
                        </div>
                        @role('siswa')
                        <div class="  ">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @endrole
                        <div class=" ">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @role('super admin')
                        <div class=" ">
                            <a href="/biodata/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Biodata Lengkap</a>
                        </div>
                        <div class=" ">
                            <a href="/statuspengamal/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Pengamal</a>
                        </div>
                        <div class=" ">
                            <a href="/statusanak/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Anak</a>
                        </div>
                        @endrole
                    </div>
                    <div class=" grid grid-cols-1 gap- mt-2 ">
                        <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">

                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border bg-gray-100">
                                        <th class=" border text-center py-1">No</th>
                                        <th class=" border text-center"> Periode</th>
                                        <th class=" border text-center"> Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($pesertakelas->count() != null)
                                    @foreach($pesertakelas as $kelas)
                                    <tr>

                                        <td class=" border px-2 py-1 text-center ">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->periode}} {{$kelas->ket_semester}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->nama_kelas}}
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class=" border  text-center text-red-600">
                                            Data Kelas tidak ada
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border bg-gray-100">
                                        <th class=" border text-center py-1">No</th>
                                        <th class=" border text-center"> Periode</th>
                                        <th class=" border text-center"> Asrama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($historiAsrama->count() != null)
                                    @foreach($historiAsrama as $kelas)
                                    <tr>
                                        <td class=" border px-2 py-1 text-center ">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->periode}} {{$kelas->ket_semester}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->nama_asrama}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class=" border  text-center text-red-600">
                                            Data Kelas tidak ada
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <form action="/siswa/{{$siswa->id}}" method="get" class="w-full  hidden">
                                <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">

                                <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                    Pilih Presensi
                                </button>
                            </form>

                        </div>
                    </div>
                    <div class=" mt-2 overflow-auto">

                        <table class=" w-full">
                            <thead>
                                <tr>
                                    <th rowspan="2" class=" border">Periode</th>
                                    <th rowspan="2" class=" border">Sesi</th>
                                    <th colspan="6" class=" border">keterangan</th>


                                </tr>
                                <tr>

                                    <th class=" border">H</th>
                                    <th class=" border">S</th>
                                    <th class=" border">I</th>
                                    <th class=" border">A</th>
                                    <th class=" border">%H</th>
                                    <th class=" border">Status</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($PresensiKelas as $item)
                                <tr>
                                    <td class=" border text-center ">
                                        {{$item->periode}}
                                        {{$item->ket_semester}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{$item->count_sesikelas_id}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{$item->hadir}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{$item->sakit}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{$item->izin}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{$item->alfa}}
                                    </td>
                                    <td class=" border text-center ">
                                        {{ number_format($item->presentase_kehadiran,0)}}
                                    </td>
                                    <td class=" border text-center ">

                                        @if($item->presentase_kehadiran >= 75)
                                        <span class=" text-green-700 font-semibold">M</span>
                                        @else
                                        <span class=" text-red-700 font-semibold">TM</span>
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
    </div>
</x-app-layout>