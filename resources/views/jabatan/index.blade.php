<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jabatan') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- CARD FORM -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Tambah Jabatan</h3>
                    <a href="/data-perangkat"
                        class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Perangkat
                    </a>
                </div>

                <form action="/jabatan" method="post" class="flex gap-3 items-center">
                    @csrf
                    <input type="text" name="nama_jabatan"
                        class="flex-1 px-3 py-2 border rounded-md focus:ring focus:ring-blue-200"
                        placeholder="Masukkan nama jabatan">

                    <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>

                    <a href="/jabatan"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Reset
                    </a>
                </form>
            </div>

            <!-- CARD TABLE -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Jabatan</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-md">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">Nama Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataJab as $index => $list)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $list->nama_jabatan }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-gray-500">
                                    Data jabatan belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>