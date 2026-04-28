<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Periode')
        <h2 class="font-semibold text-xl">
            Pengaturan Periode
        </h2>
    </x-slot>

    <div class="p-3 space-y-4">

        {{-- NAV --}}
        <div class="bg-white shadow rounded-xl p-3">
            <div class="flex gap-2 text-sm">
                <a href="{{ url('/periode') }}"
                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Periode
                </a>
                <a href="{{ url('/pengaturan') }}"
                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Pengaturan
                </a>
            </div>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 text-red-700 px-3 py-2 rounded">
            {{ session('error') }}
        </div>
        @endif

        {{-- FORM + TABLE --}}
        <div class="bg-white shadow rounded-xl p-4 space-y-4">

            {{-- FORM --}}
            <form action="{{ url('/periode') }}" method="post" class="space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                    <div>
                        <label class="text-xs text-gray-500">Periode</label>
                        <input name="periode" type="text"
                            value="{{ old('periode') }}"
                            class="w-full border rounded-lg px-3 py-1 text-sm"
                            placeholder="2025/2026">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Semester</label>
                        <select name="semester_id"
                            class="w-full border rounded-lg px-2 py-1 text-sm">
                            @foreach($semester as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}"
                            class="w-full border rounded-lg px-2 py-1 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500">Tahun Hijriyah</label>
                        <input type="text" name="tahun_hijriyah"
                            value="{{ old('tahun_hijriyah') }}"
                            class="w-full border rounded-lg px-3 py-1 text-sm"
                            placeholder="1446">
                    </div>

                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>

                    <a href="{{ url('/siswa') }}"
                        class="px-4 py-1 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                </div>
            </form>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Periode</th>
                            <th class="p-2 border">Semester</th>
                            <th class="p-2 border">Keterangan</th>
                            <th class="p-2 border">Hijriyah</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Hapus</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($periode as $list)
                        <tr class="hover:bg-gray-50">

                            <td class="border text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border text-center font-medium">
                                {{ $list->periode }}
                            </td>

                            <td class="border text-center">
                                {{ $list->semester }}
                            </td>

                            <td class="border text-center">
                                {{ $list->ket_semester }}
                            </td>

                            <td class="border text-center">
                                {{ $list->tahun_hijriyah }}
                            </td>

                            {{-- STATUS --}}
                            <td class="border text-center">
                                @if($list->is_active)
                                <span class="px-2 py-1 bg-green-500 text-white rounded text-xs">
                                    Aktif
                                </span>
                                @else
                                <form action="{{ url('/periode/aktifkan/'.$list->id) }}" method="post">
                                    @csrf
                                    <button
                                        class="px-2 py-1 bg-gray-400 text-white rounded text-xs hover:bg-blue-500">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
                            </td>

                            {{-- HAPUS --}}
                            <td class="border text-center">
                                <form action="{{ url('/periode/'.$list->id) }}" method="post"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('delete')

                                    <button
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-gray-500">
                                Belum ada data periode
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</x-app-layout>