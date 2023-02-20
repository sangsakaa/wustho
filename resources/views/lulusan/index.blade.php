<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Lulusan' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Data Lulusan') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-2 flex grid-cols-1 gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/pengaturan" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                pengaturan
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
                                    <tr class="  uppercase text-sm bg-gray-100">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 py-1 text-center">Periode</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Mulai</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Selesai</th>
                                        <th class=" border px-2 py-1 text-center">Tanggal Kelulusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataLulusan as $list)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <td class=" border text-center capitalize"><a href="/daftar-lulusan/{{$list->id}}">{{$list->periode}} {{$list->ket_semester}}</a></td>
                                        <td class=" border text-center capitalize">

                                            {{ \Carbon\Carbon::parse($list->tanggal_mulai)->isoFormat('D MMM Y') }}
                                        </td>
                                        <td class=" border text-center capitalize">

                                            {{date( 'd-m-Y',strtotime($list->tanggal_selesai))}}
                                        </td>
                                        <td class=" border text-center capitalize">

                                            {{date( 'd-m-Y',strtotime($list->tanggal_kelulusan))}}
                                        </td>
                                        <td class=" border text-center capitalize">


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