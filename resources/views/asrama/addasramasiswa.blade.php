<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah Asrama') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>
                    <form action="/asramasiswa" method="post">
                        @csrf
                        <div class=" grid grid-cols-1  sm:grid sm:grid-cols-2 py-6 px-4">
                            <div class=" grid    gap-2 ">
                                <select name="asrama_id" id="" class="     capitalize py-1">
                                    <option value=""> -- Pilih Asrama --</option>
                                    @foreach($datasrama as $item )
                                    <option class="  text-sm" value="{{$item->id}}"> {{'Asrama - '.$item->nama_asrama}}</option>
                                    @endforeach
                                </select>
                                {{-- <select name="periode_id" id="" class=" w-1/2  py-1 sm:text-sm text-xs">
                                        <option value=""> -- Pilih Periode --</option>
                                        @foreach($periode as $item )
                                        <option value="{{$item->id}}"> {{$item->periode}} {{$item->ket_semester}}</option>
                                @endforeach
                                </select> --}}
                                <input type="text" name="kuota" class=" py-1  " placeholder=" Kuota : 40">
                                <div class=" flex gap-2">
                                    <button type="submit" class="  px-4  bg-blue-600 text-white font-medium text-xs leading-normal uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex align-center">

                                        <span class=" px-4 py-2">SIMPAN</span>
                                    </button>
                                    <a href="/asramasiswa" class="  px-4  bg-blue-600 text-white font-medium text-xs leading-normal uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex align-center">
                                        <span class=" px-4 p-2">Kembali</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>