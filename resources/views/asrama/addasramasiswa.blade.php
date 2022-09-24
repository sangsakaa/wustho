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
                    <div class=" grid grid-cols-1 py-6 px-4">
                        <form action="/asramasiswa" method="post">
                            @csrf
                            <div class=" flex grid-cols-2   gap-2 ">

                                <div>
                                    <select name="asrama_id" id="" class="  py-1">
                                        <option value=""> -- Pilih Asrama --</option>
                                        @foreach($datasrama as $item )
                                        <option value="{{$item->id}}"> {{$item->nama_asrama}}</option>
                                        @endforeach
                                    </select>
                                    <select name="periode_id" id="" class="  py-1">
                                        <option value=""> -- Pilih Periode --</option>
                                        @foreach($periode as $item )
                                        <option value="{{$item->id}}"> {{$item->periode}} {{$item->ket_semester}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="kuota" class=" py-1 " placeholder=" Kuota : 40">
                                </div>
                                <div>

                                    <button class=" bg-blue-600 text-white rounded-md px-2 py-1"> create asrama siswa </button>
                                    <a href="/asramasiswa" class=" bg-red-600 text-white rounded-md px-2 py-1"> back asrama siswa </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>