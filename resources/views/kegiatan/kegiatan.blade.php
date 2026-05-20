<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard Kegiatan')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Dashboard Kegiatan
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola daftar kegiatan pondok dan sesi asrama
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- ACTION BUTTON --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
            <div class="flex flex-wrap gap-3">

                <a href="/addkegiatan"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kegiatan
                </a>

                @can('show create')
                <a href="/kelas_mi"
                    class="inline-flex items-center bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-xl font-medium transition">
                    Kelas Madrasah Diniyah
                </a>
                @endcan

                <a href="/sesiasrama"
                    class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-medium transition">
                    Sesi Asrama
                </a>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-semibold text-gray-700">
                    Daftar Kegiatan Pondok
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center w-16">No</th>
                            <th class="px-4 py-3 text-left">Kegiatan</th>
                            <th class="px-4 py-3 text-center w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($kegiatan as $buah)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-4 py-3 text-center font-medium">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="font-medium text-gray-700">
                                    {{ $buah->kegiatan }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">

                                    <a href="/kegiatan/{{ $buah->id }}/edit"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5h2m-1-1v2m6.364 1.636l-9.9 9.9L5 19l1.464-3.464 9.9-9.9a2 2 0 112.828 2.828z" />
                                        </svg>
                                    </a>

                                    @role('super admin')
                                    <form action="/kegiatan/{{ $buah->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Hapus kegiatan ini?')"
                                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endrole
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-10 text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-4xl">📂</span>
                                    <p>Belum ada data kegiatan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>