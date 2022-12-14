<x-app-layout>
    <x-slot name="header">
        @section('title','| Kelas : '.$datakelasmi->nama_kelas )
        <h2 class="font-semibold text-xl  leading-tight">
            Dashboard Kelas : {{$datakelasmi->nama_kelas}}

        </h2>
    </x-slot>
    <div class="px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-purple-600  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2">
                    <div class=" grid grid-cols-8">
                        <div>Kelas</div>
                        <div>: {{$datakelasmi->nama_kelas}} </div>
                        <div>Kuota</div>
                        <div>: {{$datakelasmi->kuota}} org</div>
                        <div>Jumlah Peserta</div>
                        <div>: {{$hitung}} org</div>
                        <div>Sisa Kuota Kelas</div>
                        <div>: {{($datakelasmi->kuota)-$hitung}} org</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="px-4">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-2  ">
                    <div class=" grid grid-cols-1 gap-1 py-1 justify-items-end">
                    </div>
                    <div class=" grid grid-cols-2">
                        <div>
                            <a href="/pesertakolektif/{{ $kelasmi->id }}">
                                <button class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kolektif</button>
                            </a>
                            <a href="/kelas_mi">
                                <button class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kembali</button>
                            </a>
                        </div>
                        <div class="grid justify-items-end">
                            <form action="/pesertakelas/{{$datakelasmi->id}}" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg  border text-green-800 dark:text-purple-600 rounded-sdm py-1 " placeholder=" Cari ...">

                                <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                    Cari </button>
                            </form>
                        </div>
                    </div>
                    <Table class=" table w-full mt-1">
                        <thead>
                            <tr class="border">
                                <th class=" text-sm px-2 border text-center  ">#</th>
                                <th class=" text-sm px-2 border text-center">Nomor Induk Siswa </th>
                                <th class=" text-sm px-2 border text-center">Daftar Peserta </th>

                                <th class=" text-sm px-2 border text-center"> Kelas </th>
                                <th class=" text-sm px-2 border text-center py-1"> Nama Kelas </th>
                                <th class=" text-sm px-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dataKelas->count())
                            @foreach($dataKelas as $list)
                            <tr class=" hover:bg-gray-100 dark:hover:bg-dark-bg even:bg-gray-100 ">
                                <td class=" border px-2 w-10 text-center">
                                    {{$loop->iteration}}
                                </td>
                                <td class=" border px-2 text-center w-50">
                                    {{$list->nis}}
                                </td>
                                <td class=" border px-2 capitalize">
                                    {{strtolower($list->nama_siswa)}}
                                </td>

                                <td class=" border px-2 text-center ">
                                    {{$list->kelas}}
                                </td>
                                <td class=" border px-2 text-center ">
                                    {{$list->nama_kelas}}
                                </td>
                                <td class=" border px-3 py-1 flex justify-center    gap-2   ">
                                    <a href="/pesertakelas/{{$list->id}}/edit" class=" grid  bg-yellow-400 py-1 px-1 text-black hover:text-white hover:bg-purple-600 rounded-md ">
                                        <x-icons.edit></x-icons.edit>
                                    </a>
                                    <form action="/pesertakelas/{{$list->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class=" grid bg-red-600 py-1 px-1 text-white hover:bg-purple-600 rounded-md ">
                                            <x-icons.hapus></x-icons.hapus>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class=" border text-center" colspan="7">
                                    Tidak ada Data ditemukan !!!
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="7" class="py-1">
                                    {{$dataKelas->links()}}
                                </td>
                            </tr>
                        </tbody>
                    </Table>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>