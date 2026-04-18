<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Edit Mata Pelajaran')
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Mata Pelajaran
        </h2>
    </x-slot>

    <div class="px-4 py-6 flex justify-center">
        <div class="w-full max-w-2xl">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                <h3 class="text-sm font-semibold text-gray-500 mb-4">
                    Form Edit Mata Pelajaran
                </h3>

                <form action="/mapel/{{ $mapel->id }}" method="post" class="space-y-4">
                    @csrf
                    @method('patch')

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Mata Pelajaran
                        </label>
                        <input type="text" name="mapel"
                            value="{{ $mapel->mapel }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Fiqih">
                    </div>

                    <!-- KITAB -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Nama Kitab
                        </label>
                        <input type="text" name="nama_kitab"
                            value="{{ $mapel->nama_kitab }}"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Mabadi' Fiqiyah Juz 1">
                    </div>

                    <!-- KELAS -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Kelas
                        </label>
                        <select name="kelas_id"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($datakelas as $list)
                            <option value="{{ $list->id }}"
                                {{ $mapel->kelas_id == $list->id ? 'selected' : '' }}>
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
                            <option value="{{ $list->id }}"
                                {{ $mapel->periode_id == $list->id ? 'selected' : '' }}>
                                {{ $list->periode }} {{ $list->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                            Update
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