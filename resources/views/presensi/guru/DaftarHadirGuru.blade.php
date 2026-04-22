<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Guru
        </h2>
    </x-slot>

    <!-- HEADER INFO -->
    <div class="p-4">
        <div class="bg-white rounded-2xl shadow-sm border p-4">

            <h3 class="text-lg font-semibold text-blue-600 mb-3">
                Presensi Guru
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                <div class="text-gray-500">Hari / Tanggal</div>
                <div class="font-medium">
                    {{ \Carbon\Carbon::parse($title->tanggal)->translatedFormat('l, j F Y') }}
                </div>

                <div class="text-gray-500">Kelas</div>
                <div class="font-medium">
                    {{ $title->nama_kelas }}
                </div>
            </div>

        </div>
    </div>

    <!-- FORM -->
    <div class="p-4">
        <div class="bg-white rounded-2xl shadow-sm border p-4">

            <form action="/sesi-presensi-guru/{{$sesi_Kelas_Guru->id}}" method="post">
                @csrf
                <input type="hidden" name="sesi_kelas_guru_id" value="{{ $sesi_Kelas_Guru->id }}">

                <!-- ACTION BUTTON -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        Simpan Presensi
                    </button>

                    <a href="/sesi-presensi-guru"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">
                        Kembali
                    </a>
                </div>

                <!-- ALERT -->
                @if (session('status'))
                <div class="mb-3 text-sm text-green-700 bg-green-100 px-3 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
                @endif

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border rounded-xl overflow-hidden">

                        <!-- HEADER -->
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                            <tr>
                                <th class="px-3 py-2 text-center">No</th>
                                <th class="px-3 py-2 text-left">Nama Guru</th>
                                <th class="px-3 py-2 text-center">Keterangan</th>
                                <th class="px-3 py-2 text-center">Alasan</th>
                            </tr>
                        </thead>

                        <!-- BODY -->
                        <tbody class="divide-y">
                            @foreach ($dataGuru as $item)
                            <tr class="hover:bg-gray-50 transition">

                                <!-- NO -->
                                <td class="px-3 py-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- NAMA -->
                                <td class="px-3 py-2 capitalize">
                                    {{ strtolower($item->nama_guru) }}
                                    <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                                </td>

                                <!-- RADIO -->
                                <td class="px-3 py-2 text-center">
                                    <div class="flex justify-center gap-3 text-xs">

                                        @foreach (['hadir'=>'H', 'izin'=>'I', 'sakit'=>'S', 'alfa'=>'A'] as $val => $label)
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio"
                                                name="keterangan[{{ $item->id }}]"
                                                value="{{ $val }}"
                                                class="text-blue-600 focus:ring-blue-500"
                                                {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>
                                            <span>{{ $label }}</span>
                                        </label>
                                        @endforeach

                                    </div>
                                </td>

                                <!-- ALASAN -->
                                <td class="px-3 py-2">
                                    <input type="text"
                                        name="alasan[{{ $item->id }}]"
                                        value="{{ $item->alasan }}"
                                        placeholder="Isi alasan..."
                                        class="w-full border rounded-lg px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>