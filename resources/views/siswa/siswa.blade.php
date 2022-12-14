<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Siswa' )
        <h2 class="font-semibold text-xl leading-tight">
            @role('super admin')
            {{ __('Dashboard Daftar Data Siswa') }}
            @endrole
            @role('pengurus')
            {{ __('Dashboard Daftar Data Santri') }}
            @endrole
        </h2>
    </x-slot>
    @can('show post')
    <div class="dark:bg-dark-bg dark:text-purple-600   ">
        <div class="  shadow-sm sm:rounded-md">
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
            <div class=" p-2 overflow-auto bg-white dark:bg-black ">
                <div class="px-1 py-2 border-b border-gray-200 flex   gap-1">
                    <a href="/addsiswa">
                        <button class=" bg-blue-500 dark:bg-green-700 text-white p-1 rounded-md">
                            <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></span>
                        </button>
                    </a>
                    <form action="/siswa" method="get" class="  text-sm gap-1 flex">
                        <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus>
                        <button type="submit" class=" px-2    bg-blue-500  rounded-md text-white">
                            Cari By Nama </button>
                    </form>
                </div>
                <table class=" w-full  ">
                    <thead class=" dark:bg-dark-bg bg-gray-100 uppercase">
                        <tr class=" border-collapse  sm:text-sm text-xs">
                            <th class=" py-1 border text-center">No</th>
                            <th class=" px-1 border text-center uppercase">nis</th>
                            <th class=" px-1 border text-center">Nama</th>
                            <th class=" px-1 border text-center">JK</th>
                            <th class=" px-1 border text-center">Asrama</th>
                            <th class=" px-1 border text-center">Madin</th>
                            <th class=" px-1 border text-center">Jenjang</th>
                            <th class=" px-1 border text-center">Angkatan</th>
                            <th class=" px-1 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($dataSiswa->count() != null)
                        @foreach ( $dataSiswa as $peserta)
                        <tr class=" text-xs  border hover:bg-blue-100  sm:text-sm  even:bg-gray-100 ">
                            <td class=" text-sm  border  text-center py-1 ">
                                {{$loop->iteration}}
                            </td>
                            <td class=" text-sm  px-2 border  text-center ">
                                @if($peserta->NisTerakhir != null)
                                {{$peserta->NisTerakhir->nis}}
                                @else
                                <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                                @endif
                            </td>
                            <td class=" text-xs sm:text-sm  border px-2 capitalize">
                                <a href="/siswa/{{$peserta->id}}">
                                    {{strtolower($peserta->nama_siswa)}}
                                </a>
                            </td>
                            <td class=" text-sm  border text-center ">
                                {{$peserta->jenis_kelamin}}
                            </td>
                            <td class=" text-sm  border text-center ">
                                @if($peserta->asramaTerkhir != null )
                                {{$peserta->asramaTerkhir->asramaSiswa->asrama->nama_asrama}}
                                @else
                                <span class=" text-red-600 font-semibold capitalize"> belum ada asrama </span>
                                @endif
                            </td>
                            <td class=" text-sm  border text-center ">
                                @if($peserta->kelasTerakhir)
                                {{$peserta->kelasTerakhir->KelasMi->nama_kelas}}
                                @else
                                <span class=" text-red-600 font-semibold capitalize"> belum ada kelas </span>
                                @endif
                            </td>
                            <td class=" text-sm  px-2 border  text-center ">
                                @if($peserta->NisTerakhir != null)
                                {{$peserta->NisTerakhir->madrasah_diniyah}}
                                @else
                                <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                                @endif
                            </td>
                            <td class=" text-sm  border text-center ">

                                @if($peserta->NisTerakhir != null)

                                {{ \Carbon\Carbon::parse($peserta->NisTerakhir->tanggal_masuk)->isoFormat('Y') }}
                                @else
                                <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                                @endif
                            </td>

                            <td class=" text-sm flex justify-center py-1  gap-1">

                                @can('delete post')
                                <form action="/siswa/{{$peserta->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class=" bg-red-500 text-white p-1 rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" onclick="return  confirm ('apakah anda yakin menghapus data ini : {{$peserta->nis}} {{$peserta->nama_siswa}}')" )>
                                            <path stroke-linecap=" round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg></button>
                                </form>
                                @endcan
                                @can('edit post')
                                <a href="/siswa/{{$peserta->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg></a>
                                @endcan
                                <a href="/siswa/{{$peserta->id}}" class=" text-white bg-sky-400 py-0 hover:bg-purple-600  px-2 rounded-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div colspan="10" class=" px-1 dark:text-purple-600 dark:bg-dark-bg text-xs sm:text-sm mt-1">
                    {{$dataSiswa->links()}}
                </div>
                <div class=" bg-sky-400 rounded-md text-white px-1 grid grid-cols-1 mt-1">
                    <span class="px-4 mt-4 text-bold">Keterangan :</span>
                    <div class=" px-6 mb-4">
                        <p>1. Siswa yang berstatus <b>Aktif</b> adalah siswa masih dalam pondok dan mengikuti pembelajaran</p>
                        <p>2. Siswa yang berstatus <b>Lulus</b> adalah siswa sudah dinytakan Selesai dalam mengikuti pembelajaran</p>
                        <p>3. Siswa yang berstatus <b>Boyong</b> adalah siswa yang sudah tidak didalam pondok dan tidak mengikuti pembelajaran</p>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>