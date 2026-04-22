<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Tambah Kelas MI
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="max-w-2xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">

                <!-- HEADER FORM -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">
                        Tambah Data Kelas Madrasah
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lengkapi data kelas dengan benar
                    </p>
                </div>

                <!-- ERROR -->
                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded text-sm">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- FORM -->
                <form action="/kelas_mi" method="POST" class="space-y-4">
                    @csrf

                    <!-- PILIH KELAS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Pilih Kelas
                        </label>
                        <select name="kelas_id"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($dataKelas as $item)
                            <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NAMA KELAS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Kelas
                        </label>
                        <input type="text"
                            name="nama_kelas"
                            value="{{ old('nama_kelas') }}"
                            placeholder="Contoh: 1A"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                    </div>

                    <!-- KUOTA -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kuota Kelas
                        </label>
                        <input type="number"
                            name="kuota"
                            value="{{ old('kuota') }}"
                            placeholder="Contoh: 40"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                    </div>

                    <!-- ACTION -->
                    <div class="flex justify-between items-center pt-2">

                        <a href="/kelas_mi"
                            class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-md">
                            ← Kembali
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md shadow">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>