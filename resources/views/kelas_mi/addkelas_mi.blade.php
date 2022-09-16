<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah Kelas MI') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>
                    <div class=" w-1/2">
                        <form action="/kelas_mi" method="post">
                            @csrf
                            <select name="kelas_id" id="" class=" px-1 py-1 w-1/3">
                                <option value=""> --- Pilih Kelas --- </option>
                                @foreach ($dataKelas as $item)
                                <option value="{{$item->id}}">{{$item->kelas}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="kuota" class=" py-1 rounded-md" placeholder=" Kuota Kelas : 40">
                            <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> simpan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>