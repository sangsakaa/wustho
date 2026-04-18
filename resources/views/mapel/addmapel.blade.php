<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Tambah Mata Pelajaran')
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Mata Pelajaran
        </h2>
    </x-slot>

    <div class="px-4 py-6 flex justify-center">
        <div class="w-full max-w-2xl">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                <h3 class="text-sm font-semibold text-gray-500 mb-4">
                    Form Input Mata Pelajaran
                </h3>

                <form action="/mapel" method="post" class="space-y-4">
                    @csrf

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Nama Mata Pelajaran
                        </label>
                        <input name="mapel" type="text"
                            placeholder="Contoh: Fiqih"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- KITAB -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Nama Kitab
                        </label>
                        <input name="nama_kitab" type="text"
                            placeholder="Contoh: Mabadi' Fiqiyah Juz 1"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- KELAS -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Kelas
                        </label>
                        <select name="kelas_id"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($datakelas as $list)
                            <option value="{{ $list->id }}">
                                {{ $list->kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PERIODE -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Periode Pembelajaran
                        </label>
                        <select name="periode_id"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase">
                            @foreach($dataPeriode as $list)
                            <option value="{{ $list->id }}">
                                {{ $list->periode }} {{ $list->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                            Simpan
                        </button>

                        <a href="/mapel"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded-lg shadow">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>