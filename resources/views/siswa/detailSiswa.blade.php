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
                    <div class=" grid sm:grid-cols-4 grid-cols-2">
                        <div>Nama </div>
                        <div class=" border-red-500 text-sm ">: {{$siswa->nama_siswa}}</div>
                        <div>Tanggal Lahir </div>
                        <div>: {{$siswa->tempat_lahir}}</div>
                        <div>Jenis Kelamin </div>
                        <div>: {{$siswa->jenis_kelamin}}</div>
                        <div>Tempat Lahir </div>
                        <div>: {{$siswa->tanggal_lahir}}</div>
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
                        @role('super admin')
                        @if($siswa->count() != null)
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/biodata/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Biodata Lengkap</a>
                        </div>
                        @endif
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/statuspengamal/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Pengamal</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/statusanak/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Status Anak</a>
                        </div>

                        @endrole
                    </div>
                    <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>