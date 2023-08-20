<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Update Data Perangkat') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 grid grid-cols-1">
                        <form action="/edit-form-perangkat/{{$perangkat->id}}/edit" method="post">
                            @csrf
                            @method('patch')
                            <label for="">Nama Lengkap</label>
                            <input value="{{$perangkat->nama_perangkat}}" name="nama_perangkat" type="text" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('jenis_kelamin',$perangkat->jenis_kelamin)=="L"? 'selected':''}} value="L">
                                    Laki-Laki</option>
                                <option {{old('jenis_kelamin',$perangkat->jenis_kelamin)=="P"? 'selected':''}} value="P">
                                    Perempuan</option>
                            </select>
                            <label for="">Tempat Lahir</label>
                            <input value="{{$perangkat->tempat_lahir}}" name="tempat_lahir" type="text" class=" w-full py-1 rounded-md @error('tempat_lahir') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <label for="">Tanggal Lahir</label>
                            <input value="{{$perangkat->tanggal_lahir}}" name="tanggal_lahir" type="date" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <label for="">Agama</label>
                            <select name="agama" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('agama',$perangkat->agama)=="Islam"? 'selected':''}} value="Islam">
                                    Islam</option>
                            </select>
                            <label for="">Tanggal Masuk</label>
                            <input value="{{$perangkat->tanggal_masuk}}" name="tanggal_masuk" type="date" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <label for="">Status</label>
                            <select name="status" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('status',$perangkat->status)=="Aktif"? 'selected':''}} value="Aktif">
                                    Aktif</option>
                                <option {{old('status',$perangkat->status)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">
                                    Tidak Aktif</option>
                            </select>
                            <button type="submit" class=" px-2 py-1 bg-sky-600 text-white rounded-md mt-1">Update</button>
                            @role('super admin')
                            <a href="/data-perangkat" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                            @endrole
                            @role('siswa')
                            <a href="/user" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                            @endrole
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>