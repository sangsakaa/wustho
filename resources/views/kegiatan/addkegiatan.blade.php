<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Form Tambah Kegiatan')

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Form Tambah Kegiatan
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Tambahkan kegiatan baru untuk pondok atau asrama
            </p>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">

                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-semibold text-gray-700">
                        Input Data Kegiatan
                    </h3>
                </div>

                {{-- FORM --}}
                <div class="p-6">
                    <form action="/kegiatan" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kegiatan
                            </label>

                            <input
                                type="text"
                                name="kegiatan"
                                value="{{ old('kegiatan') }}"
                                placeholder="Contoh: Roan Ahad Pagi"
                                class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            @error('kegiatan')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- ACTION BUTTON --}}
                        <div class="flex items-center gap-3 pt-2">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-medium shadow-sm transition">
                                Simpan
                            </button>

                            <a href="/kegiatan"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-xl font-medium transition">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>