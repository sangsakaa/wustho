<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Siswa' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Daftar Data Siswa') }}
        </h2>
    </x-slot>
    <div class="px-4 mt-4">
        <div class=" mx-auto ">
            <div class=" px-2 bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="px-1 py-2 bg-white border-b border-gray-200 flex gap-1">
                    @role('admin')
                    <a href="/addsiswa">
                        <button class=" bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </a>
                    @endrole
                    <form action="/siswa" method="get" class=" flex gap-1">
                        <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">

                        <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                            Cari </button>

                    </form>

                </div>
                @if (session('delete'))
                <div class=" py-2">
                    <div class=" bg-red-500 px-2 py-1 text-white">
                        {{ session('delete') }}
                    </div>
                </div>
                @endif
                @if (session('success'))
                <div class=" py-2">
                    <div class=" bg-green-500 px-2 py-1 text-white">
                        {{ session('success') }}
                    </div>
                </div>
                @endif
                @if (session('update'))
                <div class=" py-2">
                    <div class=" bg-blue-500 px-2 py-1 text-white">
                        {{ session('update') }}
                    </div>
                </div>
                @endif
                <div class=" overflow-scroll">
                    <table class=" table table-auto w-full ">
                        <thead>
                            <tr class=" border-collapse">
                                <th class=" border text-center">#</th>
                                <th class=" border text-center">Nomor Indus Siswa</th>
                                <th class=" border text-center">Nama siswa</th>
                                <th class=" border text-center">JK</th>
                                <th class=" border text-center">Tempat Lahir</th>
                                <th class=" border text-center">Tanggal Lahir</th>
                                <th class=" border text-center">Asrama</th>
                                <th class=" border text-center">Madin</th>
                                <th class=" border text-center">Angkatan</th>

                                @role('admin')
                                <th class=" border text-center">Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @if($dataSiswa->count())
                            @foreach ( $dataSiswa as $peserta)
                            <tr class=" border hover:bg-blue-100 ">
                                <td class=" border  text-center ">
                                    {{$loop->iteration}}
                                </td>
                                <td class=" px-2 border  text-center ">
                                    {{$peserta->nis}}
                                </td>
                                <td class=" border px-2">
                                    <a href="/siswa/{{$peserta->id}}">
                                        {{$peserta->nama_siswa}}
                                    </a>
                                </td>
                                <td class=" border text-center ">
                                    {{$peserta->jenis_kelamin}}
                                </td>
                                <td class=" border text-center">
                                    {{$peserta->tempat_lahir}}
                                </td>
                                <td class=" border text-center ">
                                    {{$peserta->tanggal_lahir}}
                                </td>
                                <td class=" border text-center ">
                                    {{$peserta->nama_asrama}}
                                </td>
                                <td class=" border text-center ">
                                    {{$peserta->nama_kelas}}
                                </td>
                                <td class=" border text-center ">
                                    <?php
                                    $date = date_create($peserta->tanggal_masuk);
                                    echo date_format($date, "Y");
                                    ?>
                                </td>

                                @role('admin')
                                <td class="flex justify-center  gap-1">
                                    <form action="/siswa/{{$peserta->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class=" flex p-0  text-center text-white bg-red-600 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg></button>


                                    </form>
                                    <a href="siswa/{{$peserta->id}}/edit" class=" bg-yellow-500 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></a>
                                </td>
                                @endrole
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" class=" border text-center  text-red-600">
                                    Data Tidak ditemukan
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="10" class=" py-1">
                                    {{$dataSiswa->links()}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="py-2 px-4">
        <div class="  ">
            <div class="bg-blue-200 overflow-hidden shadow-sm sm:rounded-md">
                <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                    <div class=" grid grid-cols-1 p-2">
                        <span class=" text-bold">Keterangan :</span>
                        <div class=" p-2">
                            <p>1. Siswa yang berstatus <b>Aktif</b> adalah siswa masih dalam pondok dan mengikuti pembelajaran</p>
                            <p>2. Siswa yang berstatus <b>Lulus</b> adalah siswa sudah dinytakan Selesai dalam mengikuti pembelajaran</p>
                            <p>3. Siswa yang berstatus <b>Boyong</b> adalah siswa yang sudah tidak didalam pondok dan tidak mengikuti pembelajaran</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>