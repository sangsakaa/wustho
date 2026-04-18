<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Lulusan')
        <h2 class="font-semibold text-xl text-gray-800">
            Manajemen Data Lulusan
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- NAVIGATION -->
        <div class="flex gap-2">
            <a href="/periode"
                class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                Periode
            </a>

            <a href="/daftar-transkip"
                class="px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm capitalize">
                Daftar Transkrip
            </a>
        </div>

        <!-- FORM -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-600 uppercase mb-3">
                Tambah Data Lulusan
            </h3>

            <form action="/lulusan" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

                    <!-- PERIODE -->
                    <div>
                        <label class="text-sm font-medium">Periode Lulusan</label>
                        <select name="periode_id"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                            @foreach($dataPeriode as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- KELAS -->
                    <div>
                        <label class="text-sm font-medium">Kelas</label>
                        <select name="kelasmi_id"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                            @foreach($kelasMi as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kelas }} - {{ $item->periode }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TANGGAL MULAI -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                    <!-- TANGGAL SELESAI -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                    <!-- TANGGAL KELULUSAN -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Kelulusan</label>
                        <input type="date" name="tanggal_kelulusan"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                    <!-- HIJRIYAH -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Hijriyah</label>
                        <input type="text" name="tanggal_lulus_hijriyah"
                            placeholder="12 Rabi'ul Awwal 1444 H"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm">
                    </div>

                </div>

                <!-- INFO -->
                <div class="mt-3 text-xs text-red-600">
                    * Data ini diambil dari bagian kurikulum
                </div>

                <!-- BUTTON -->
                <div class="mt-3">
                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-3 border-b">
                <h3 class="text-sm font-semibold text-gray-600 uppercase">
                    Daftar Data Lulusan
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="border px-2 py-2 w-10">No</th>
                            <th class="border px-2 py-2 text-center">Periode</th>
                            <th class="border px-2 py-2 text-center">Kelas</th>
                            <th class="border px-2 py-2 text-center">Mulai</th>
                            <th class="border px-2 py-2 text-center">Selesai</th>
                            <th class="border px-2 py-2 text-center">Kelulusan</th>
                            <th class="border px-2 py-2 text-center w-24">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($dataLulusan as $list)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <a href="/daftar-lulusan/{{ $list->id }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </a>
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $list->nama_kelas }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ \Carbon\Carbon::parse($list->tanggal_mulai)->isoFormat('D MMM Y') }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ \Carbon\Carbon::parse($list->tanggal_selesai)->isoFormat('D MMM Y') }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ \Carbon\Carbon::parse($list->tanggal_kelulusan)->isoFormat('D MMMM Y') }}
                                <div class="text-xs text-gray-500">
                                    {{ $list->tanggal_lulus_hijriyah }}
                                </div>
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <form action="/lulusan/{{ $list->id }}" method="POST"
                                    onsubmit="return confirm('Hapus data lulusan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7"
                                class="text-center py-3 text-gray-500 italic">
                                Belum ada data lulusan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->

        </div>

    </div>
</x-app-layout>