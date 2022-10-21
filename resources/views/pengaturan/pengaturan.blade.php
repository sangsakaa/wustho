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
                        <div class=" overflow-auto p-2 sm:p-6 grid sm:flex grid-cols-2 text-center uppercase gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/semester" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                semester
                            </a>
                            <a href="/raportkelas" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                raport
                            </a>
                            <a href="/addpelanggaran" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                pelanggaran
                            </a>
                            <a href="/presensikelas" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                Presensi
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" ">
                <div class=" p-2 sm:p-6 grid grid-cols-1">
                    <span class=" text-center font-semibold ">LIST CETAK RAPORT</span>
                    <hr class=" py-2">
                    <form action="/pengaturan" method="get" class=" flex gap-1">
                        <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus>

                        <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                            Cari Raport </button>

                    </form>
                    <table class=" border mt-2">
                        <thead class=" border">
                            <tr class=" bg-gray-100 dark:bg-purple-600 tex-xs sm:text-sm">
                                <th class=" border px-2 py-1 ">No</th>
                                <th class=" border px-2 text-center">Daftar Raport</th>
                                <th class=" border px-2 text-center">KLS</th>
                                <th class=" border px-2 text-center">NK</th>
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
                                <td class=" border text-sm px-2 text-center">
                                    {{ $list->kelas }}
                                </td>
                                <td class=" border text-sm px-2 text-center">
                                    {{ $list->nama_kelas }}
                                </td>
                                <td class=" border text-sm px-1 text-center py-1 ">
                                    <a href="/report/{{ $list->id }}" class=" justify-center bg-sky-300 rounded-md p-1 text-black flex text-center hover:bg-purple-600 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>

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