<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengaturan') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 flex grid-cols-1 gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/semester" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                semester
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">
                            <table class=" border">
                                <thead class=" border">
                                    <tr class=" bg-gray-100 capitalize">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 text-center">Nama Siswa</th>
                                        <th class=" border px-2 text-center">kelas</th>
                                    </tr>
                                </thead>
                                @foreach($peserta as $user) <tbody>
                                    <tr class=" border hover:bg-gray-100">
                                        <th class=" px-2 text-center border">{{$loop->iteration}}</th>
                                        <td class=" px-2 text-left border">{{$user->nama_siswa}}</td>
                                        <td class=" px-2 text-center border">{{$user->nama_kelas}}</td>
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