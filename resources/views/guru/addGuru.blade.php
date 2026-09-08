<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah Data Guru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- Header Form --}}
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Tambah Data Guru
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Silakan lengkapi data guru berikut.
                    </p>
                </div>

                
                <form action="/guru" method="POST">
                    @csrf

                    <div class="p-6">

                        {{-- GRID 2 KOLOM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="nama_guru"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nama_guru"
                                    id="nama_guru"
                                    value="{{ old('nama_guru') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    placeholder="Contoh: M. Izul Ula"
                                    required>

                                @error('nama_guru')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Kelamin
                                    <span class="text-red-600">*</span>
                                </label>

                                <select
                                    name="jenis_kelamin"
                                    id="jenis_kelamin"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="P"
                                        {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>

                                @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Agama --}}
                            <div>
                                <label for="agama"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Agama
                                    <span class="text-red-600">*</span>
                                </label>

                                <select
                                    name="agama"
                                    id="agama"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam"
                                        {{ old('agama') == 'Islam' ? 'selected' : '' }}>
                                        Islam
                                    </option>
                                </select>

                                @error('agama')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Tempat Lahir --}}
                            <div>
                                <label for="tempat_lahir"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Tempat Lahir
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="tempat_lahir"
                                    id="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    placeholder="Contoh: Malang"
                                    required>

                                @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Lahir
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>

                                @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Tanggal Masuk --}}
                            <div>
                                <label for="tanggal_masuk"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Masuk
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_masuk"
                                    id="tanggal_masuk"
                                    value="{{ old('tanggal_masuk') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>

                                @error('tanggal_masuk')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Status --}}
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                    <span class="text-red-600">*</span>
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>
                                    <option value="">-- Pilih Status --</option>

                                    <option value="Aktif"
                                        {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option value="Non Aktif"
                                        {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>
                                        Non Aktif
                                    </option>

                                    <option value="Cuti"
                                        {{ old('status') == 'Cuti' ? 'selected' : '' }}>
                                        Cuti
                                    </option>
                                </select>

                                @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>


                            {{-- Jenjang --}}
                            <div>
                                <label for="jenjang"
                                    class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenjang
                                    <span class="text-red-600">*</span>
                                </label>

                                <select
                                    name="jenjang"
                                    id="jenjang"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           py-2 px-3"
                                    required>
                                    <option value="">-- Pilih Jenjang --</option>

                                    <option value="Ula"
                                        {{ old('jenjang') == 'Ula' ? 'selected' : '' }}>
                                        Ula
                                    </option>

                                    <option value="Wustho"
                                        {{ old('jenjang') == 'Wustho' ? 'selected' : '' }}>
                                        Wustho
                                    </option>

                                    <option value="Ulya"
                                        {{ old('jenjang') == 'Ulya' ? 'selected' : '' }}>
                                        Ulya
                                    </option>
                                </select>

                                @error('jenjang')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                        </div>


                        {{-- BUTTON --}}
                        <div class="mt-6 pt-5 border-t border-gray-200
                    flex flex-col sm:flex-row sm:justify-end gap-2">

                            <a
                                href="/guru"
                                class="inline-flex items-center justify-center
                       px-4 py-2 rounded-md
                       bg-gray-500 hover:bg-gray-600
                       text-white text-sm font-medium
                       transition">
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                       px-4 py-2 rounded-md
                       bg-blue-600 hover:bg-blue-700
                       text-white text-sm font-medium
                       transition">
                                Simpan Data
                            </button>

                        </div>

                    </div>
                </form>
                


            </div>
        </div>
    </div>
</x-app-layout>