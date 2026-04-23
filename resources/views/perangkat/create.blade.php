<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tambah Data Perangkat') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-6">

                <form action="/data-perangkat" method="post" class="space-y-6">
                    @csrf

                    <!-- GRID FORM -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_perangkat"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: M. Izul Ula" required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_kelamin"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Agama <span class="text-red-500">*</span>
                            </label>
                            <select name="agama"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                            </select>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Malang" required>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Tanggal Masuk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tanggal Masuk <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_masuk"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                            </select>
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="/data-perangkat"
                            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>