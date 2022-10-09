<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah Kelas MI') }}
        </h2>
    </x-slot>
    <div class="p-4 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4  border-b border-gray-200">
                <div class=" w-full ">
                    <span>Form Create Kelas Madrasah</span>
                    <form action="/kelas_mi" method="post">
                        @csrf
                        <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 sm:gap-2  ">
                            <select name="kelas_id" id="" class=" px-2 py-1    ">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($dataKelas as $item)
                                <option value="{{$item->id}}">{{$item->kelas}} </option>
                                @endforeach
                            </select>
                            <select name="periode_id" id="" class=" px-2 py-1    ">
                                <option value="">-- Pilih Periode --</option>
                                @foreach ($dataPeriode as $item)
                                <option value="{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="nama_kelas" class=" py-1  " placeholder=" Nama Kelas : 1A">
                            <input type="text" name="kuota" class=" py-1  " placeholder=" Kuota Kelas : 40">
                            <button class=" bg-blue-600 text-white rounded-sm px-2 py-1   "> simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>