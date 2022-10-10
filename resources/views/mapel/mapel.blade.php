<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Mata Pelajaran' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class=" px-2 mt-2 overflow-auto ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 border-b border-gray-200">
                    <div class=" flex w-full gap-1">
                        <a href="/addmapel">
                            <button class=" flex sm:text-sm text-xs bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                create mapel
                            </button>
                        </a>
                        <a href="#">
                            <button class=" flex sm:text-sm text-xs bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                create asrama siswa
                            </button>
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
                            <div class=" overflow-auto">
                                <table class=" w-full border">
                                    <thead class=" border bg-gray-200 ">
                                        <tr class=" overflow-auto">
                                            <th class=" border px-2 py-1">No</th>
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
                                            <th class=" border sm:text-sm text-xs ">
                                                <form action="/mapel/{{$list->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="   bg-red-500 text-white p-1 rounded-md " onclick=" return confirm('apakah anda yakin menghapus data ini : {{$list->mapel}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg></button>
                                                </form>
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