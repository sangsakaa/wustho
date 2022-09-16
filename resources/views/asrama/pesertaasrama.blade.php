<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Peserta Asrama {{$tittle->nama_asrama}}
        </h2>
    </x-slot>

    <div class="px-4 py-2">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">

                <div class=" grid grid-cols-8">
                    <div>Kuota Asrama</div>
                    <div> : {{$tittle->nama_asrama}} </div>
                    <div>Kuota Asrama</div>
                    <div> : {{$tittle->kuota}} </div>
                    <div> Jml Peserta </div>
                    <div> : {{count($datapeserta)}}</div>
                    <div> Sisa Kuota </div>
                    <div> : {{($tittle->kuota)-count($datapeserta)}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-1 px-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" flex gap-2 py-1 w-full">
                        <form action="/pesertaasrama/{{$tittle->id}}" method="get" class=" flex gap-1">
                            <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">
                            <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                Cari </button>

                        </form>
                        <a href="/asramasiswa" class=" flex justify-end">
                            <button class=" flex bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg> Kembali

                            </button>
                        </a>
                        <a href="/kolektifasrama" class=" flex justify-end">
                            <div class="">
                                <button class=" flex bg-blue-500 text-white py-1 px-2 rounded-md d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                    Kolektif
                                </button>
                            </div>



                    </div>
                    </a>

                    <Table class=" w-full">
                        <thead>
                            <tr class=" border ">
                                <th class=" border py-1">#</th>
                                <th class=" border text-center px-2">NIS</th>
                                <th class=" border text-left px-2"> Daftar Peserta</th>
                                <th class=" border text-center w-1">JK</th>
                                <th class=" border text-center px-2"> Asrama</th>
                                <th class=" border text-center">Kota Asal</th>
                                <th class=" border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($datapeserta as $siswa)
                            <tr class=" boerder hover:bg-gray-100">
                                <td class=" border px-2 text-center">
                                    {{$loop->iteration}}
                                </td>
                                <td class=" border px-2 w-20">
                                    @if($siswa->nis == $siswa->nis)
                                    <span class=" text-red-500">{{$siswa->nis}}</span>
                                    @else($siswa->nis != $siswa->nis)
                                    <span class=" text-yellow-500">{{$siswa->nis}}</span>
                                    @endif
                                </td>
                                <td class=" border px-2">
                                    {{$siswa->nama_siswa}}
                                </td>
                                <td class=" border px-2">
                                    {{$siswa->jenis_kelamin}}
                                </td>
                                <td class=" border px-2 text-center">
                                    {{$siswa->nama_asrama}}
                                </td>
                                <td class=" border px-2">
                                    {{$siswa->kota_asal}}
                                </td>
                                <td class=" flex justify-center border  px-2">
                                    <form action="/pesertaasrama/{{$siswa->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class=" bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">

                                </td>
                            </tr>

                        </tbody>
                    </Table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>