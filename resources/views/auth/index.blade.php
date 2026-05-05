<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Manajemen Registrasi Siswa
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data siswa dan pembuatan akun user
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium transition">
                    Tambah User
                </a>

                <a href="{{ route('admin.roles.index') }}"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition">
                    Role
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm font-medium transition">
                    Users
                </a>
                <a href="{{ url('/admin/user-permissions') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow">
                    User Permissions
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-2xl border border-slate-200">

                {{-- Header Table --}}
                <div class="px-6 py-5 border-b border-slate-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">
                                Daftar Siswa
                            </h3>
                            <p class="text-sm text-slate-500">
                                Total {{ $siswa->total() }} siswa
                            </p>
                        </div>

                        <form method="GET" action="{{ route('register.index') }}" class="flex gap-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama siswa..."
                                class="w-full md:w-72 rounded-xl border-slate-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">

                            <button
                                type="submit"
                                class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr class="text-slate-600 uppercase text-xs tracking-wider">
                                <th class="px-6 py-4 text-center">No</th>
                                <th class="px-6 py-4 text-left">Nama Siswa</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($siswa as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-center text-slate-600">
                                    {{ $siswa->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ ucwords(strtolower($item->nama_siswa)) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('register', ['siswa_id' => $item->id]) }}"
                                        class="inline-flex items-center px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-medium transition">
                                        Buat Akun
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                    Data siswa tidak ditemukan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $siswa->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>