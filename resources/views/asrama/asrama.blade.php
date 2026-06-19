<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Asrama')

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Dashboard Asrama
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola data asrama, penghuni, dan presensi harian santri
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 space-y-6">

        {{-- ACTION BAR --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">

            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">

                <a href="/addasrama"
                    class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-medium transition shadow-sm">
                    <span>➕</span>
                    Tambah Asrama
                </a>

                <a href="/asramasiswa"
                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-xl text-sm font-medium transition shadow-sm">
                    <span>🏠</span>
                    Asrama Siswa
                </a>

                <a href="/sesiasrama"
                    class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl text-sm font-medium transition shadow-sm">
                    <span>📅</span>
                    Presensi Harian
                </a>

            </div>
        </div>

        {{-- CONTENT --}}
        {{-- CONTENT --}}
        <div
            x-data="{ tab: 'putra' }"
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">

            {{-- HEADER TAB --}}
            <div class="p-5 border-b border-gray-200 dark:border-gray-800">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                            Data Asrama
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Kelola data asrama putra dan putri
                        </p>
                    </div>

                    <div class="flex gap-2">

                        <button
                            @click="tab='putra'"
                            :class="tab=='putra'
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-100 text-gray-600'"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition">

                            👦 Putra
                            <span class="font-bold">
                                ({{ $Putra->count() }})
                            </span>

                        </button>

                        <button
                            @click="tab='putri'"
                            :class="tab=='putri'
                        ? 'bg-pink-600 text-white'
                        : 'bg-gray-100 text-gray-600'"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition">

                            👧 Putri
                            <span class="font-bold">
                                ({{ $Putri->count() }})
                            </span>

                        </button>

                    </div>

                </div>

            </div>

            {{-- TAB PUTRA --}}
            <div x-show="tab === 'putra'" x-transition>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-blue-50 text-gray-700 uppercase text-xs">

                            <tr>
                                <th class="px-4 py-3 text-center w-16">
                                    No
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Nama Asrama
                                </th>

                                <th class="px-4 py-3 text-center w-40">
                                    Type
                                </th>

                                @role('super admin')
                                <th class="px-4 py-3 text-center w-32">
                                    Aksi
                                </th>
                                @endrole

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @forelse($Putra as $buah)

                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition">

                                <td class="px-4 py-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $buah->nama_asrama }}
                                </td>

                                <td class="px-4 py-3 text-center">

                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                        {{ $buah->type_asrama }}
                                    </span>

                                </td>

                                @role('super admin')
                                <td class="px-4 py-3 text-center">

                                    <form
                                        action="/asrama/{{ $buah->id }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus asrama ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">

                                            Hapus

                                        </button>

                                    </form>

                                </td>
                                @endrole

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-10 text-gray-500">

                                    Tidak ada data Asrama Putra

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- TAB PUTRI --}}
            <div x-show="tab === 'putri'" x-transition>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-pink-50 text-gray-700 uppercase text-xs">

                            <tr>

                                <th class="px-4 py-3 text-center w-16">
                                    No
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Nama Asrama
                                </th>

                                <th class="px-4 py-3 text-center w-40">
                                    Type
                                </th>

                                @role('super admin')
                                <th class="px-4 py-3 text-center w-32">
                                    Aksi
                                </th>
                                @endrole

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @forelse($Putri as $buah)

                            <tr class="hover:bg-pink-50 dark:hover:bg-gray-800 transition">

                                <td class="px-4 py-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $buah->nama_asrama }}
                                </td>

                                <td class="px-4 py-3 text-center">

                                    <span class="px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-xs">
                                        {{ $buah->type_asrama }}
                                    </span>

                                </td>

                                @role('super admin')
                                <td class="px-4 py-3 text-center">

                                    <form
                                        action="/asrama/{{ $buah->id }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus asrama ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">

                                            Hapus

                                        </button>

                                    </form>

                                </td>
                                @endrole

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-10 text-gray-500">

                                    Tidak ada data Asrama Putri

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- INFO --}}
        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl p-5">

            <h4 class="font-semibold text-yellow-700 mb-3">
                Informasi
            </h4>

            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex gap-2">
                    <span class="font-bold text-yellow-600">•</span>
                    Tambahkan data asrama baru jika belum tersedia
                </li>

                <li class="flex gap-2">
                    <span class="font-bold text-yellow-600">•</span>
                    Pisahkan data Putra & Putri untuk pengelolaan lebih rapi
                </li>

                <li class="flex gap-2">
                    <span class="font-bold text-yellow-600">•</span>
                    Gunakan menu presensi untuk absensi harian santri
                </li>
            </ul>

        </div>

    </div>

</x-app-layout>