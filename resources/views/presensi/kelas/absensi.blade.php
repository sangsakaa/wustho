<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas : ' . $dataKelas->nama_kelas)

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Presensi Kelas
            </h2>

            <span class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($sesikelas->tgl)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </x-slot>

    @php
    // hanya yang sudah disimpan
    $savedData = $dataSiswa->whereNotNull('absensikelas_id');

    $hadir = $savedData->where('keterangan', 'hadir')->count();
    $izin = $savedData->where('keterangan', 'izin')->count();
    $sakit = $savedData->where('keterangan', 'sakit')->count();
    $alfa = $savedData->where('keterangan', 'alfa')->count();

    $total = $dataSiswa->count();
    $tersimpan = $savedData->count();
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- INFO --}}
            <div class="bg-white shadow rounded-xl p-5">
                <div class="grid sm:grid-cols-2 gap-3 text-sm">
                    <div><b>Kelas:</b> {{ $dataKelas->nama_kelas }}</div>
                    <div><b>Semester:</b> {{ $dataKelas->ket_semester }}</div>
                    <div><b>Periode:</b> {{ $dataKelas->periode }}</div>
                    <div>
                        <b>Terakhir Disimpan:</b>
                        {{ $diSimpanPada ? \Carbon\Carbon::parse($diSimpanPada)->isoFormat('D MMMM YYYY HH:mm') : '-' }}
                    </div>
                </div>
            </div>

            {{-- STAT --}}
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">

                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $hadir }}</div>
                    <div class="text-sm">Hadir</div>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $izin }}</div>
                    <div class="text-sm">Izin</div>
                </div>

                <div class="bg-yellow-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $sakit }}</div>
                    <div class="text-sm">Sakit</div>
                </div>

                <div class="bg-red-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $alfa }}</div>
                    <div class="text-sm">Alfa</div>
                </div>

                <div class="bg-indigo-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-indigo-600">{{ $tersimpan }}</div>
                    <div class="text-sm">Tersimpan</div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-gray-700">{{ $total }}</div>
                    <div class="text-sm">Total</div>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex justify-between">
                <a href="/sesikelas"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    ← Kembali
                </a>

                <button form="formPresensi"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Simpan Presensi
                </button>
            </div>

            {{-- FORM --}}
            <form id="formPresensi" action="/absensikelas" method="POST">
                @csrf
                <input type="hidden" name="prev_url" value="{{ $prev_url }}">
                <input type="hidden" name="sesikelas" value="{{ $sesikelas->id }}">

                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="p-3 text-center">No</th>
                                <th class="p-3 text-left">NIS</th>
                                <th class="p-3 text-left">Nama</th>
                                <th class="p-3 text-center">Kehadiran</th>
                                <th class="p-3">Alasan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($dataSiswa as $item)

                            @php
                            $isSaved = !is_null($item->absensikelas_id);

                            // kalau belum disimpan → default HADIR
                            $current = $item->keterangan ?? 'hadir';
                            @endphp

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-3 text-center">
                                    {{ $loop->iteration }}

                                    <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                    <input type="hidden" name="absensikelas[{{ $item->id }}]" value="{{ $item->absensikelas_id }}">
                                </td>

                                <td class="p-3">
                                    {{ $item->nis??'-' }}
                                </td>
                                <td class="p-3">
                                    {{ $item->nama_siswa }}
                                </td>

                                <td class="p-3">
                                    <div class="flex justify-center gap-2">

                                        @foreach([
                                        'hadir' => 'H',
                                        'izin' => 'I',
                                        'sakit' => 'S',
                                        'alfa' => 'A'
                                        ] as $key => $label)

                                        @php
                                        $selected = old("keterangan.$item->id", $current) == $key;
                                        @endphp

                                        <label>
                                            <input type="radio"
                                                class="hidden peer"
                                                name="keterangan[{{ $item->id }}]"
                                                value="{{ $key }}"
                                                {{ $selected ? 'checked' : '' }}>

                                            <span class="
    px-3 py-2 text-xs rounded-lg border cursor-pointer transition font-medium

    border-gray-300 text-gray-600 bg-white
    peer-checked:text-white

    {{-- WARNA BERDASARKAN STATUS --}}
    {{ $key == 'hadir' ? '
        peer-checked:bg-green-600
        peer-checked:border-green-600
    ' : '' }}

    {{ $key == 'izin' ? '
        peer-checked:bg-blue-600
        peer-checked:border-blue-600
    ' : '' }}

    {{ $key == 'sakit' ? '
        peer-checked:bg-yellow-500
        peer-checked:border-yellow-500
    ' : '' }}

    {{ $key == 'alfa' ? '
        peer-checked:bg-red-600
        peer-checked:border-red-600
    ' : '' }}

    {{-- DEFAULT BELUM DISIMPAN --}}
    {{ !$isSaved && $key == 'hadir' && $selected
        ? 'bg-red-100 text-red-700 border-red-300'
        : '' }}
">
                                                {{ $label }}
                                            </span>
                                        </label>

                                        @endforeach

                                    </div>
                                </td>

                                <td class="p-3">
                                    <input type="text"
                                        name="alasan[{{ $item->id }}]"
                                        value="{{ old("alasan.$item->id", $item->alasan) }}"
                                        class="w-full border rounded-lg text-sm"
                                        placeholder="Opsional...">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </form>

            {{-- NOTE / TUTORIAL --}}
            <div class="bg-white border rounded-xl p-4 text-sm text-gray-700 space-y-1">
                <b>📌 Cara Presensi:</b><br>
                1. Default semua siswa = <b>Hadir (merah muda = belum disimpan)</b><br>
                2. Klik status jika ingin ubah (Izin / Sakit / Alfa)<br>
                3. Klik <b>Simpan Presensi</b> untuk menyimpan data<br>
                4. Setelah disimpan → warna berubah jadi hijau / biru / kuning / merah<br>
            </div>

        </div>
    </div>
</x-app-layout>