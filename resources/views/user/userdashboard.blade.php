<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa' )
        <h2 class="font-semibold  text-center text-gray-800 leading-tight">
            <span class=" uppercase">{{ __('Dashboard Detail Siswa ') }} </span><br>
        </h2>
    </x-slot>
    <div class="py-4 px-4">
        <div class=" mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 text-center py-1">
                        <span class=" text-sm">{{ $title->nama_siswa }}</span>
                        <span class=" text-xs">NIS : {{$title->nis}}</span>
                    </div>
                </div>
            </div>
            <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4  bg-white border-b border-gray-200">

                    <div class=" grid sm:grid-cols-4 grid-cols-2 gap-2">

                        <div class=" bg-sky-400 p-6 text-center text-white rounded-md">
                            <span class=" capitalize">total mapel</span>
                            <span>{{$jml}}</span>
                        </div>
                        <div class=" bg-sky-400 p-6 text-center text-white rounded-md">

                            <span>IPK : {{(number_format($b,2,','))}}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <span class=" text-lg">Riwayat Asrama </span>

                            <table class=" w-full    ">
                                <thead>
                                    <tr class=" border bg-gray-100">
                                        <th class=" border text-center py-1">No</th>
                                        <th class=" border text-center"> Periode</th>
                                        <th class=" border text-center"> Asrama</th>
                                        <th class=" border text-center"> Type Asrama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Asrama as $user)
                                    <tr class=" border">
                                        <td class=" border text-center p-1">
                                            {{$loop->iteration}}
                                        </td>
                                        <td class=" border text-center">
                                            {{$user->periode}} {{$user->ket_semester}}
                                        </td>
                                        <td class=" border text-center">
                                            {{$user->nama_asrama}}
                                        </td>
                                        <td class=" border text-center">
                                            {{$user->type_asrama}}
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