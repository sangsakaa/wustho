<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Edit Data Guru') }}
        </h2>
    </x-slot>

    <div class="p-4">

        <div class="max-w-2xl mx-auto bg-white shadow-sm border rounded-lg p-6">

            <form action="/guru/{{$guru->id}}" method="POST" class="space-y-4">

                @csrf
                @method('PATCH')

                {{-- NAMA --}}
                <div>
                    <label class="block text-sm font-medium">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="nama_guru"
                        value="{{$guru->nama_guru}}"
                        class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Contoh: M. Izul Ula">
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full mt-1 px-3 py-2 border rounded">

                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{old('jenis_kelamin',$guru->jenis_kelamin)=='L' ? 'selected' : ''}}>
                            Laki-Laki
                        </option>
                        <option value="P" {{old('jenis_kelamin',$guru->jenis_kelamin)=='P' ? 'selected' : ''}}>
                            Perempuan
                        </option>

                    </select>
                </div>

                {{-- AGAMA --}}
                <div>
                    <label class="block text-sm font-medium">Agama</label>
                    <select name="agama"
                        class="w-full mt-1 px-3 py-2 border rounded">

                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{old('agama',$guru->agama)=='Islam' ? 'selected' : ''}}>
                            Islam
                        </option>

                    </select>
                </div>

                {{-- TEMPAT LAHIR --}}
                <div>
                    <label class="block text-sm font-medium">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="tempat_lahir"
                        value="{{$guru->tempat_lahir}}"
                        class="w-full mt-1 px-3 py-2 border rounded"
                        placeholder="Contoh: Malang">
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block text-sm font-medium">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                        name="tanggal_lahir"
                        value="{{$guru->tanggal_lahir}}"
                        class="w-full mt-1 px-3 py-2 border rounded">
                </div>

                {{-- TANGGAL MASUK --}}
                <div>
                    <label class="block text-sm font-medium">
                        Tanggal Masuk <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                        name="tanggal_masuk"
                        value="{{$guru->tanggal_masuk}}"
                        class="w-full mt-1 px-3 py-2 border rounded">
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status"
                        class="w-full mt-1 px-3 py-2 border rounded">

                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" {{old('status',$guru->status)=='Aktif' ? 'selected' : ''}}>
                            Aktif
                        </option>
                        <option value="Non Aktif" {{old('status',$guru->status)=='Non Aktif' ? 'selected' : ''}}>
                            Non Aktif
                        </option>
                        <option value="Cuti" {{old('status',$guru->status)=='Cuti' ? 'selected' : ''}}>
                            Cuti
                        </option>

                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2 pt-2">

                    <button type="submit"
                        class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700 transition">
                        Update
                    </button>

                    <a href="/guru"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>
</x-app-layout>