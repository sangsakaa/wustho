<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Edit Kegiatan') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>

                    <div class=" grid grid-cols-1 py-6 px-4">
                        <form action="/kegiatan/{{$kegiatan->id}}" method="post">
                            @csrf
                            @method('patch')
                            <input type="text" name="kegiatan" class=" w-1/4 py-1 " placeholder=" kegiatan : Roan Ahad Pagi" value="{{$kegiatan->kegiatan}}">
                            <button class=" bg-sky-500 text-white rounded-md px-2 py-1"> Update</button>
                            <a href="/kegiatan" class=" bg-blue-600 text-white rounded-md px-2 py-1">Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>