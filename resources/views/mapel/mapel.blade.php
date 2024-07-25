<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kurikulum' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Mata Pelajaran dan Kurikulum') }}
        </h2>
    </x-slot>
    <div class=" px-2 mt-2 overflow-auto ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 border-b border-gray-200">
                    <div class=" flex w-full gap-1 ">
                        <a href="/addmapel" class=" capitalize rounded-md   bg-blue-800 flex text-white px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tambah Mata Pelajaran

                        </a>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 sm:px-1 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-4 grid grid-cols-1">
                            @if (session('delete'))
                            <div class="py-2">
                                <div class="bg-red-500 px-2 py-1 text-white">
                                    {{ session('delete') }}
                                </div>
                            </div>
                            <meta http-equiv="refresh" content="5">
                            @endif
                            @if (session('success'))
                            <div class="py-2">
                                <div class="bg-green-500 px-2 py-1 text-white">
                                    {{ session('success') }}
                                </div>
                            </div>
                            <meta http-equiv="refresh" content="5">
                            @endif
                            @if (session('update'))
                            <div class="py-2">
                                <div class="bg-blue-500 px-2 py-1 text-white">
                                    {{ session('update') }}
                                </div>
                            </div>
                            <meta http-equiv="refresh" content="5">
                            @endif
                            <div class=" overflow-auto">
                                <table class=" w-full border">
                                    <thead class=" border bg-gray-200 uppercase text-xs sm:text-xs ">
                                        <tr class=" overflow-auto">
                                            <th class=" border px-2 py-1">No</th>
                                            <th class=" border px-2 text-center sm:text-sm text-xs">Periode</th>
                                            <th class=" border px-2 text-center sm:text-sm text-xs">Mata Pelajaran</th>
                                            <th class=" border px-2 text-center sm:text-sm text-xs">Nama Kitab</th>
                                            <th class=" border px-2 text-center sm:text-sm text-xs">Kelas</th>
                                            <th class=" border px-2 text-center sm:text-sm text-xs">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" overflow-auto">
                                        @foreach($listmapel as $list)
                                        <tr class=" hover:bg-gray-100">
                                            <th class=" border sm:text-sm text-xs">
                                                <a href="/report/{{$list->id}}"> {{$loop->iteration}}</a>
                                            </th>
                                            <th class=" border sm:text-sm text-xs px-2 text-center">
                                                <a href="/report/{{$list->id}}"> {{$list->periode}} {{$list->ket_semester}}</a>
                                            </th>
                                            <th class=" border sm:text-sm text-xs px-2 text-left">
                                                <a href="/report/{{$list->id}}"> {{$list->mapel}}</a>
                                            </th>
                                            <th class=" border sm:text-sm text-xs px-2 text-left">
                                                <a href="/report/{{$list->id}}"> {{$list->nama_kitab}}</a>
                                            </th>
                                            <th class=" border sm:text-sm text-xs px-2 text-center">
                                                <a href="/report/{{$list->id}}">
                                                    {{$list->kelas}}
                                                </a>
                                            </th>
                                            <th class=" border sm:text-sm text-xs flex px-1  py-1 gap-1 justify-center  ">
                                                <form action="/mapel/{{$list->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="  rounded-md  bg-red-500 text-white p-1  " onclick=" return confirm('apakah anda yakin menghapus data ini : {{$list->mapel}}')">Hapus</button>
                                                </form>
                                                <a href="/edit-mapel/{{$list->id}}" class=" rounded-md bg-yellow-400 px-2 py-1 text-black">
                                                    Ubah
                                                </a>
                                            </th>

                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>