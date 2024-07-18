<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Pengaturan')
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Dashboard Pengaturan') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-1">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" ">
                        <div class=" text-xs overflow-auto p-2 sm:p-2 grid sm:flex grid-cols-2 text-center uppercase gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/semester" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                semester
                            </a>
                            <a href="/raportkelas" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                raport
                            </a>

                            <a href="/presensikelas" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Presensi
                            </a>
                            <a href="/plotingkelas" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Ploting Kelas
                            </a>
                            <a href="/validasi-data" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Validasi Data
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" ">
                <div class=" p-2 sm:p-2 grid grid-cols-1">
                    <span class=" text-center font-semibold ">LIST CETAK RAPORT</span>
                    <hr class=" py-2">
                    <form action="/pengaturan" method="get" class=" flex gap-1">
                        <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus>

                        <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                            Cari Raport </button>

                    </form>
                    <form action="/delete-records" method="post">
                        @csrf
                        <input type="text" name="idsql" class="py-1">
                        <button class="py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">Hapus SQL</button>
                    </form>

                    <table class=" border mt-2">
                        <thead class=" border">
                            <tr class=" uppercase bg-gray-100 dark:bg-purple-600 tex-xs sm:text-xs">
                                <th class=" border px-2 py-1 ">No</th>
                                <th class=" border px-2 text-center">Daftar Raport</th>
                                <th class=" border px-2 text-center">Periode</th>
                                <th class=" border px-2 text-center">KLS</th>
                                <th class=" border px-2 text-center">NAMA KELAS</th>
                                <th class=" border px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raport as $list)
                            <tr class=" hover:bg-gray-100 dark:hover:bg-purple-600">
                                <th class=" border text-sm w-1">
                                    <a href="/report/{{ $list->id }}"> {{ $loop->iteration }}</a>
                                </th>
                                <td class=" border text-xs sm:text-sm px-2 text-left uppercase">
                                    {{ $list->nama_siswa }}
                                </td>
                                <td class=" border text-xs sm:text-sm px-2 text-center ">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </td>
                                <td class=" border text-sm px-2 text-center">
                                    {{ $list->kelas }}
                                </td>
                                <td class=" border text-sm px-2 text-center">
                                    {{ $list->nama_kelas }}
                                </td>
                                <td class=" border text-sm px-1 text-center py-1 ">
                                    <a href="/report/{{ $list->id }}" class=" justify-center bg-sky-300 rounded-md p-1 text-black flex text-center hover:bg-purple-600 hover:text-white">
                                        CETAK

                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>