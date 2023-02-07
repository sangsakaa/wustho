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
                    <div class=" grid  sm:grid-cols-2 grid-cols-2 ">
                        <div class=" flex w-full">
                            <div class="grid w-36  ">Nama </div>
                            <div class=" px-4 grid uppercase font-semibold   text-xs ">: {{$siswa->nama_siswa}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="grid w-36 ">Tanggal Lahir </div>
                            <div class=" px-4 capitalize">: {{$siswa->tempat_lahir}} , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</div>
                        </div>

                        <div class=" flex w-full">
                            <div class=" grid  w-36 ">Jenis Kelamin </div>
                            <div class=" px-4"> : {{$siswa->jenis_kelamin}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="  grid w-36    ">Status Asrama </div>
                            <div class=" px-4   "> :
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
    </div>
    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-1 justify-items-end gap-1">
                        <a href="/siswa" class=" bg-blue-500 px-2 py-1  hover:bg-purple-500 text-white">Kembali</a>
                        @role('siswa')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @endrole

                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        @role('super admin')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/biodata/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Biodata Lengkap</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/statuspengamal/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Pengamal</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/statusanak/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Anak</a>
                        </div>
                        @endrole
                    </div>
                    <div class=" grid grid-cols-2 sm:grid-cols-2 gap-2">
                        <div>
                            <span class=" text-lg">Detail Riwayat Kelas</span>
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
                        </div>
                        <div>
                            <span class=" text-lg">Detail Riwayat Asrama</span>
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
                        </div>
                    </div>
                    <div class=" grid  grid-cols-2 gap-2">
                        <div>
                            <span class=" text-lg">Detail Riwayat Kegiatan Asrama</span>
                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border bg-gray-100">
                                        <th class=" border text-center py-1">No</th>
                                        <th class=" border text-center"> Tanggal Presensi</th>
                                        <th class=" border text-center"> Jenis Kegiatan</th>
                                        <th class=" border text-center"> Ket</th>
                                        <th class=" border text-center"> Alasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($PresensiAsrama->count() != null)
                                    @foreach($PresensiAsrama as $kelas)
                                    <tr>
                                        <td class=" border px-2 py-1 text-center ">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class=" border px-2 text-center ">

                                            {{ \Carbon\Carbon::parse($kelas->tanggal)->isoFormat(' DD MMMM Y') }}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->kegiatan}}
                                        </td>
                                        <td class=" border px-2 text-center capitalize ">
                                            {{$kelas->keterangan}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->alasan}}
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class=" border  text-center capitalize text-red-600">
                                            Data Kegiatan Asrama tidak ada
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <span class=" text-lg">Detail Riwayat Presensi Madrasah </span>
                            <form action="/siswa/{{$siswa->id}}" method="get" class="w-full">
                                <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">

                                <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                    Pilih Presensi
                                </button>
                            </form>
                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border bg-gray-100">
                                        <th class=" border text-center py-1">No</th>
                                        <th class=" border text-center"> Tanggal Presensi</th>
                                        <th class=" border text-center"> Kelas</th>
                                        <th class=" border text-center"> Ket</th>
                                        <th class=" border text-center"> Alasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($PresensiKelas->count() != null)
                                    @foreach($PresensiKelas as $kelas)
                                    <tr>
                                        <td class=" border px-2 py-1 text-center ">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class=" border px-2 text-center ">

                                            {{ \Carbon\Carbon::parse($kelas->tgl)->isoFormat(' DD MMMM Y') }}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->nama_kelas}}
                                        </td>
                                        <td class=" border px-2 text-center capitalize ">
                                            {{$kelas->keterangan}}
                                        </td>
                                        <td class=" border px-2 text-center ">
                                            {{$kelas->alasan}}
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class=" border  text-center capitalize text-red-600">
                                            Data Kegiatan Asrama tidak ada
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>