<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Peserta Lulusan' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Data Peserta Lulusan') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">

        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">
                            <div class=" flex gap-1">
                                <a href="/kolektif-lulusan/{{$lulusan->id}}" class=" text-center py-1 px-2 w-20 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    +User
                                </a>
                                <a href="/lulusan" class=" text-center py-1 px-2 w-20 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    Batal
                                </a>
                                <a href="/blangko-ijazah" class=" text-center py-1 px-2 w-30 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    Cetak Ijazah
                                </a>
                            </div>
                            <table class=" mt-1 border">
                                <thead class=" border">
                                    <tr class="  uppercase text-sm bg-gray-100">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 py-1 text-center">Nomor ijazah</th>
                                        <th class=" border px-2 py-1 text-center">Peserta Lulusan</th>
                                        <th class=" border px-2 py-1 text-center">act</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daftarLulusan as $item)
                                    <tr>
                                        <th class=" border px-1 text-center capitalize">{{$loop->iteration}}</th>
                                        <td class=" border px-1 text-center capitalize">{{$item->nomor_ijazah}}</td>
                                        <td class=" border px-1 text-left capitalize">{{strtolower($item->nama_siswa)}}</td>
                                        <td class=" border px-1 text-center capitalize">
                                            <div class=" flex grid-cols-1 gap-2 justify-center">
                                                <form action="/daftar-lulusan/{{$item->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class=" px-1 py-1 bg-red-600 text-white">
                                                        <x-icons.hapus class="flex-shrink-0 w-4 h-4" aria-hidden="true" />
                                                    </button>
                                                </form>
                                                <a href="/reservasi-ijazah/{{$item->id}}" class=" font-semibold uppercase text-xs px-2 py-1  bg-yellow-400 ">
                                                    <span class=" mt-1">Nomor Ijazah</span>
                                                </a>
                                            </div>
                                        </td>

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

</x-app-layout>