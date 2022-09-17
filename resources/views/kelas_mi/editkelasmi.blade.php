<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Edit Kelas Madin' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form  Edit Kelas Madrasah Wustho') }}
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
                        <form action="/kelas_mi/{{$kelasmi->id}}" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="nama_kelas" class=" w-1/4 py-1 " placeholder=" Kelas : 40" value="{{$kelasmi->nama_kelas}}">
                            <input type="hidden" name="periode_id" class=" w-1/4 py-1 " placeholder=" Kelas : 40" value="{{$kelasmi->periode_id}}">
                            <input type="hidden" name="kelas_id" class=" w-1/4 py-1 " placeholder=" Kelas : 40" value="{{$kelasmi->kelas_id}}">
                            <input type="text" name="kuota" class=" w-1/4 py-1 " placeholder=" Kelas : 40" value="{{$kelasmi->kuota}}">
                            <button class=" bg-sky-400 text-white rounded-md px-2 py-1">Update</button>
                            <a href="/kelas_mi" class=" bg-blue-600 text-white rounded-md px-2 py-1">Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>