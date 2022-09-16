<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah data Guru') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>

                    <form action="/guru" method="post">
                        <div class=" grid grid-cols-1 py-6 px-4 sm:w-1/4">
                            @csrf
                            <label for="">Nama Lengkap <span class=" text-red-600">*</span></label>
                            <input type="text" name="nama_guru" class=" w-full py-1 " placeholder=" Nama Lengkap : M. Izul Ula">
                            <label for="">Jenis Kelamin <span class=" text-red-600">*</span></label>
                            <select name="jenis_kelamin" id="" class=" py-1">
                                <option value=""> -Pilih Jenis Kelamin</option>
                                <option value="L"> -Laki Laki- </option>
                                <option value="P"> -Perempuan- </option>
                            </select>
                            <label for="">Agama <span class=" text-red-600">*</span></label>
                            <select name="agama" id="" class=" py-1">
                                <option value=""> -Pilih Agama</option>
                                <option value="Islam"> Islam </option>
                            </select>
                            <label for="">Tempat Lahir <span class=" text-red-600">*</span></label>
                            <input type="text" name="tempat_lahir" class=" w-full py-1 " placeholder=" Tempat Lahir : Malang">
                            <label for="">Tempat Lahir <span class=" text-red-600">*</span></label>
                            <input type="date" name="tanggal_lahir" class=" w-full py-1 " placeholder=" Nama Lengkap : M. Izul Ula">
                            <label for="">Tempat Masuk <span class=" text-red-600">*</span></label>
                            <input type="date" name="tanggal_masuk" class=" w-full py-1 " placeholder=" Nama Lengkap : M. Izul Ula">
                            <div class=" flex grid-cols-2 gap-2 py-2">

                                <div class=" flex grid-cols-2 gap-2 py-2">
                                    <button class=" bg-blue-600 text-white rounded-md px-2 py-1"> simpan</button>
                                    <a href="/guru" class=" bg-blue-600 text-white rounded-md px-2 py-1">Kembali</a>

                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>