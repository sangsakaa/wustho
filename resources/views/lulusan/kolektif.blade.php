<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Peserta kolektif' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Data Peserta kolektif') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">

        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">

                            <form action="/kolektif-lulusan/{{$lulusan->id}}" method="post">
                                @csrf
                                <button class=" bg-red-600 px-1 py-1 text-white capitalize">Tambah kolektif</button>
                                <a href="/daftar-lulusan/{{$lulusan->id}}" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                    Kembali
                                </a>
                                <span class=" px-4"> {{$daftarLulusan->count()}}</span>
                                <input type="hidden" name="lulusan_id" class="py-1 " readonly value="{{$lulusan->id}}">
                                <table class=" border w-full mt-2">
                                    <thead class=" border">
                                        <tr class="  uppercase text-sm bg-gray-100">
                                            <th class=" border px-2 py-1 text-center w-5"><input type="checkbox"></th>
                                            <th class=" border px-2 py-1 text-center">Peserta Lulusan</th>
                                            <th class=" border px-2 py-1">Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($daftarLulusan as $item)
                                        <tr>
                                            <th class=" border px-2 py-1 text-center w-5">
                                                <input type="checkbox" name="pesertakelas[]" value="{{$item->id}}" multiple>
                                            </th>
                                            <td class=" border px-2 py-1 text-left capitalize ">
                                                {{strtolower($item->nama_siswa)}}
                                            </td>
                                            <td class=" border px-2 py-1 text-center ">
                                                {{$item->nama_kelas}}
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>