<x-app-layout>
    <x-slot name="header">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                {{ __('Tambah Data Siswa') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Form input biodata siswa / santri
            </p>
        </div>
    </x-slot>

    <div class="bg-gray-100 dark:bg-dark-bg min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">

            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-200 dark:border-gray-700">

                <form action="/siswa" method="post" class="space-y-5">
                    @csrf

                    {{-- TITLE --}}
                    <div>
                        @role('super admin')
                        <h3 class="text-lg font-semibold text-blue-600 capitalize">Biodata Siswa</h3>
                        @endrole

                        @role('pengurus')
                        <h3 class="text-lg font-semibold text-blue-600 capitalize">Biodata Santri</h3>
                        @endrole
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Lengkap
                        </label>
                        <input name="nama_siswa" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('nama_siswa') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('nama_siswa') }}">

                        @error('nama_siswa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- JK --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki Laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    {{-- AGAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Agama
                        </label>
                        <select name="agama"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="Islam" selected>Islam</option>
                        </select>
                    </div>

                    {{-- TEMPAT & TGL LAHIR --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tempat Lahir
                            </label>
                            <input name="tempat_lahir" type="text"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan tempat lahir"
                                value="{{ old('tempat_lahir') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Lahir
                            </label>
                            <input name="tanggal_lahir" type="date"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    {{-- KOTA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Asal Kota
                        </label>
                        <input name="kota_asal" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan asal kota"
                            value="{{ old('kota_asal') }}" required>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm">
                            Simpan
                        </button>

                        <a href="/siswa"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow-sm">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>