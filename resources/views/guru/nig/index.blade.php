<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Detail Guru') }}
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- DETAIL GURU --}}
        <div class="bg-white shadow-sm border rounded-lg">
            <div class="p-4 grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">

                <div class="font-semibold">Nama Lengkap</div>
                <div>: {{$guru->nama_guru}}</div>

                <div class="font-semibold">Jenis Kelamin</div>
                <div>: {{$guru->jenis_kelamin}}</div>

            </div>
        </div>

        {{-- FORM + LIST --}}
        <div class="bg-white shadow-sm border rounded-lg p-4 space-y-6">

            {{-- NAV --}}
            <div>
                <a href="/guru/{{$guru->id}}"
                    class="inline-flex items-center px-3 py-1 bg-sky-500 text-white rounded hover:bg-sky-600 transition">
                    ← Kembali ke Detail
                </a>
            </div>

            {{-- FORM --}}
            <div>
                <h3 class="font-semibold mb-2">Generate Nomor Induk Guru</h3>

                <form action="/nig/{{$guru->id}}" method="POST"
                    class="flex flex-col md:flex-row gap-2 md:items-center">

                    @csrf

                    <input type="hidden" name="guru_id" value="{{$guru->id}}">
                    <input type="hidden" name="jenjang_id" value="2">

                    <input type="text"
                        name="nig"
                        placeholder="Contoh: 2023010001"
                        class="w-full md:w-64 px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300"
                        required>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Generate NIG
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div>
                <h3 class="font-semibold mb-2">Daftar Nomor Induk Guru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border text-sm">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-2 text-center">No</th>
                                <th class="border px-2 py-2 text-center">Nomor Induk Guru</th>
                                <th class="border px-2 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($dataNIG as $nig)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="border px-2 py-2 text-center">
                                    {{$loop->iteration}}
                                </td>

                                <td class="border px-2 py-2 text-center font-mono">
                                    {{$nig->nig}}
                                </td>

                                <td class="border px-2 py-2 text-center">

                                    <form action="/nig/{{$nig->id}}" method="POST"
                                        onsubmit="return confirm('Hapus NIG ini?')">
                                        @method('DELETE')
                                        @csrf

                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">
                                    Belum ada Nomor Induk Guru
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