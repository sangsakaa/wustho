<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Update Data Perangkat') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="/edit-form-perangkat/{{$perangkat->id}}/edit" method="post" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input value="{{$perangkat->nama_perangkat}}" name="nama_perangkat" type="text"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200 @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200" required>
                                <option value="">-- Pilih --</option>
                                <option {{old('jenis_kelamin',$perangkat->jenis_kelamin)=="L"? 'selected':''}} value="L">Laki-Laki</option>
                                <option {{old('jenis_kelamin',$perangkat->jenis_kelamin)=="P"? 'selected':''}} value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <input value="{{$perangkat->tempat_lahir}}" name="tempat_lahir" type="text"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200"
                                placeholder="Masukkan tempat lahir">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input value="{{$perangkat->tanggal_lahir}}" name="tanggal_lahir" type="date"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200">
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                            <select name="agama"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200" required>
                                <option value="">-- Pilih --</option>
                                <option {{old('agama',$perangkat->agama)=="Islam"? 'selected':''}} value="Islam">Islam</option>
                            </select>
                        </div>

                        <!-- Tanggal Masuk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                            <input value="{{$perangkat->tanggal_masuk}}" name="tanggal_masuk" type="date"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200">
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-sky-200" required>
                                <option value="">-- Pilih --</option>
                                <option {{old('status',$perangkat->status)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                                <option {{old('status',$perangkat->status)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-2 pt-4">
                        @role('super admin')
                        <a href="/data-perangkat"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Batal
                        </a>
                        @endrole

                        @role('siswa')
                        <a href="/user"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Batal
                        </a>
                        @endrole

                        <button type="submit"
                            class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>