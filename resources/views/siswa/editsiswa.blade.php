<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Update Data Siswa') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 grid grid-cols-3">
                        <form action="/siswa/{{$siswa->id}}" method="post">
                            @csrf
                            @method('patch')
                            <label for="">Nama lengkap</label>
                            <input value="{{$siswa->nama_siswa}}" name="nama_siswa" type="text" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="L"? 'selected':''}} value="L">
                                    Laki-Laki</option>
                                <option {{old('jenis_kelamin',$siswa->jk)=="P"? 'selected':''}} value="P">
                                    Perempuan</option>

                            </select>
                            <label for="">Tempat Lahir</label>
                            <input value="{{$siswa->tempat_lahir}}" name="tempat_lahir" type="text" class=" w-full py-1 rounded-md @error('tempat_lahir') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <label for="">Tanggal Lahir</label>
                            <input value="{{$siswa->tanggal_lahir}}" name="tanggal_lahir" type="date" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <label for="">Agama</label>
                            <select name="agama" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('agama',$siswa->agama)=="Islam"? 'selected':''}} value="Islam">
                                    Islam</option>
                            </select>
                            <label for="">Kota Asal</label>
                            <input value="{{$siswa->kota_asal}}" name="kota_asal" type="text" class=" w-full py-1 rounded-md @error('kota_asal') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <button type="submit" class=" px-2 py-1 bg-sky-600 text-white rounded-md mt-1">Update</button>
                            <a href="/siswa" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>