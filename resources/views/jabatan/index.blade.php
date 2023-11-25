<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jabatan') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/data-perangkat">
                        <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> Perangkat</button>
                    </a>
                    <div class=" grid grid-cols-1 py-6 px-4">
                        <form action="/jabatan" method="post">
                            @csrf
                            <input type="text" name="nama_jabatan" class=" w-1/4 py-1 " placeholder=" nama_jabatan : 1">
                            <button class=" bg-blue-600 text-white rounded-md px-2 py-1"> simpan</button>
                            <a href="/jabatan" class=" bg-blue-600 text-white rounded-md px-2 py-1">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>
                    <div class=" grid grid-cols-1 py-6 px-4">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataJab as $list)
                                <tr>
                                    <td>
                                        {{$list->nama_jabatan}}
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
</x-app-layout>