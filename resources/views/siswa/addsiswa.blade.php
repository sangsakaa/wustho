<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" px-4 py-4 grid grid-cols-3">

                        <form action="/siswa" method="post">
                            @role('super admin')
                            <span class=" capitalize text-2xl text-blue-300">biodata siswa</span>
                            @endrole
                            @role('pengurus')
                            <span class=" capitalize text-2xl text-blue-300">biodata Santri</span>
                            @endrole
                            <div class=" grid-cols-1">
                                @csrf
                                <label for="">Nama lengkap</label>
                                <input name="nama_siswa" type="text" class=" w-full py-1 rounded-md @error('nama_siswa') is-invalid @enderror" placeholder=" masukan nama lengkap" value="{{old('nama_siswa')}}">
                                @error('nama_siswa')
                                <div class=" text-red-500">{{ $message }}</div>
                                @enderror
                                <label for="">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="" class=" w-full py-1 rounded-md" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L"> Laki Laki </option>
                                    <option value="P"> Perempuan </option>
                                </select>

                                <label for="">Agama</label>
                                <select name="agama" id="" class=" w-full py-1 rounded-md" required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam"> Islam </option>
                                </select>
                                <label for="">Tempat Lahir</label>
                                <input name="tempat_lahir" type="text" class=" w-full py-1 rounded-md" placeholder=" masukan tempat Lahir" value="{{old('tempat_lahir')}}" required>
                                <label for="">Tanggal Lahir</label>
                                <input name="tanggal_lahir" type="date" class=" w-full py-1 rounded-md" placeholder=" masukan nama lengkap" required>
                                <label for="">Asal Kota</label>
                                <input name="kota_asal" type="text" class=" w-full py-1 rounded-md" placeholder=" masukan Asal Kota" required value="{{old('kota_asal')}}">
                                <div>
                                    <button type="submit" class=" px-2 py-1 bg-blue-600 text-white rounded-md mt-1">Simpan</button>
                                    <a href="/siswa" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>