<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Jabatan')
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Data Jabatan
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Kelola data jabatan perangkat
            </p>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">

        <div class="max-w-5xl mx-auto space-y-6">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
            <div
                x-data="{ show:true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x-transition
                class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 text-green-700 px-4 py-3 shadow-sm">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>

                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div
                x-data="{ show:true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition
                class="rounded-xl border border-red-200 bg-red-50 text-red-700 p-4 shadow-sm">

                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
            @endif

            {{-- FORM --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg rounded-2xl overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Tambah Jabatan
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tambahkan jabatan baru ke dalam sistem
                        </p>
                    </div>

                    <a href="/data-perangkat"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">

                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>

                        Data Perangkat
                    </a>

                </div>

                <div class="p-6">

                    <form action="/jabatan" method="POST" class="flex flex-col md:flex-row gap-3">

                        @csrf

                        <input
                            type="text"
                            name="nama_jabatan"
                            value="{{ old('nama_jabatan') }}"
                            placeholder="Masukkan nama jabatan"
                            class="flex-1 px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                            Simpan
                        </button>

                        <a
                            href="/jabatan"
                            class="px-6 py-3 rounded-xl bg-gray-500 hover:bg-gray-600 text-white text-center transition">
                            Reset
                        </a>

                    </form>

                </div>

            </div>

            {{-- TABEL --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg rounded-2xl overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Daftar Jabatan
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-gray-50 dark:bg-gray-800">

                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Nama Jabatan
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Aksi
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dataJab as $list)

                            <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $list->nama_jabatan }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="/jabatan/{{ $list->id }}/edit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-sm transition">
                                            Edit
                                        </a>

                                        <form action="/jabatan/{{ $list->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm transition">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="py-12 text-center">

                                    <div class="flex flex-col items-center gap-3 text-gray-400">

                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                        </svg>

                                        <p>Data jabatan belum tersedia</p>

                                    </div>

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