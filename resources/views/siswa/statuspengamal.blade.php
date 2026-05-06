<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Status Pengamal')

        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-lg sm:text-xl text-slate-800">
                Dashboard Status Pengamal
            </h2>
            <p class="text-sm text-slate-500">
                Kelola status pengamal siswa
            </p>
        </div>
    </x-slot>

    <div class="p-3 sm:p-6 space-y-5">

        {{-- INFO SISWA --}}
        <div class="bg-white shadow-sm border rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">Informasi Siswa</h3>
            </div>

            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="text-slate-500">Nama</p>
                        <p class="font-medium">{{ $siswa->nama_siswa }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Jenis Kelamin</p>
                        <p class="font-medium">{{ $siswa->jenis_kelamin }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Tempat Lahir</p>
                        <p class="font-medium">{{ $siswa->tempat_lahir }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Tanggal Lahir</p>
                        <p class="font-medium">{{ $siswa->tanggal_lahir }}</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- ACTION MENU --}}
        <div class="bg-white shadow-sm border rounded-2xl p-4">
            <div class="flex flex-wrap gap-2">

                <a href="/siswa"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                    Kembali
                </a>

                @role('siswa')
                <a href="/nis/{{ $siswa->id }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm">
                    Nomor Induk Siswa
                </a>
                @endrole

                @role('admin')
                <a href="/biodata/{{ $siswa->id }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm">
                    Biodata Lengkap
                </a>

                <a href="/nis/{{ $siswa->id }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm">
                    Nomor Induk Siswa
                </a>

                <a href="/statuspengamal/{{ $siswa->id }}"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm">
                    Status Pengamal
                </a>
                @endrole
            </div>
        </div>

        {{-- FORM STATUS --}}
        <div class="bg-white shadow-sm border rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">Tambah Status Pengamal</h3>
            </div>

            <div class="p-5">
                <form action="/statuspengamal/{{ $siswa->id }}" method="post"
                    class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @csrf

                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <input
                        type="text"
                        value="{{ $siswa->nama_siswa }}"
                        disabled
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm bg-slate-50">

                    <select
                        name="status_pengamal"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm">
                        <option value="pengamal">Pengamal</option>
                        <option value="simpatisan">Simpatisan</option>
                    </select>

                    <button
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm">
                        Simpan Status
                    </button>
                </form>
            </div>
        </div>

        {{-- TABLE STATUS --}}
        <div class="bg-white shadow-sm border rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">Detail Status Pengamal</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-sm">
                    <thead class="bg-slate-100 text-slate-600 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($sp as $org)
                        <tr class="hover:bg-slate-50">

                            <td class="px-4 py-3">
                                {{ $org->nama_siswa }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs
                                    {{ $org->status_pengamal == 'pengamal'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($org->status_pengamal) }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">

                                    <a href="/statuspengamal/{{ $org->id }}/edit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg">
                                        ✏️
                                    </a>

                                    <form action="{{ route('statuspengamal.destroy', $org->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg">
                                            🗑️
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-slate-400">
                                Belum ada data status pengamal
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>