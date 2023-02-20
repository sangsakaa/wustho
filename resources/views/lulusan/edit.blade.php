<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Reservasi Nomor Ijazah' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Reservasi Nomor Ijazah') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">

        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">
                            <form action="/daftar-lulusan/{{$daftar_lulusan->id}}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" class=" py-1" name="lulusan_id" value="{{$daftar_lulusan->id}}">
                                <input type="text" class=" w-1/2 py-1" name="nomor_ijazah" placeholder=" Nomor Ijazah" value="{{$daftar_lulusan->nomor_ijazah}}">
                                <button class=" px-1 py-1 bg-red-600 text-white">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>