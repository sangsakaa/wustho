<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas : ' . $dataKelas->nama_kelas)

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <!-- Informasi Tanggal -->
            <div class=" border-gray-200 rounded-lg px-4 py-2 md:bg-transparent md:border-0 md:p-0">
                <div class="text-xs uppercase tracking-wide text-gray-500">
                    Tanggal
                </div>

                <div class="text-sm md:text-base font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($sesikelas->tgl)->isoFormat('dddd, D MMMM YYYY') }}
                </div>
            </div>

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
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-3">

                <div class="space-y-2 text-sm">

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">🏫 Kelas</span>
                        <span class="font-semibold text-gray-800 text-right">
                            {{ $dataKelas->nama_kelas }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">📚 Semester</span>
                        <span class="font-semibold text-gray-800">
                            {{ $dataKelas->ket_semester }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">🗓️ Periode</span>
                        <span class="font-semibold text-gray-800">
                            {{ $dataKelas->periode }}
                        </span>
                    </div>

                    <div class="border-t pt-2 flex items-start justify-between">
                        <span class="text-gray-500">💾 Disimpan</span>

                        <span class="font-medium text-gray-800 text-right text-xs leading-4">
                            {{ $diSimpanPada
                    ? \Carbon\Carbon::parse($diSimpanPada)->isoFormat('D MMM YYYY HH:mm')
                    : '-' }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- STAT --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2">

                <div class="flex items-center justify-between rounded-lg bg-green-50 border border-green-200 px-3 py-2">
                    <span class="text-xs text-green-700">Hadir</span>
                    <span class="text-base font-bold text-green-600">{{ $hadir }}</span>
                </div>

                <div class="flex items-center justify-between rounded-lg bg-blue-50 border border-blue-200 px-3 py-2">
                    <span class="text-xs text-blue-700">Izin</span>
                    <span class="text-base font-bold text-blue-600">{{ $izin }}</span>
                </div>

                <div class="flex items-center justify-between rounded-lg bg-yellow-50 border border-yellow-200 px-3 py-2">
                    <span class="text-xs text-yellow-700">Sakit</span>
                    <span class="text-base font-bold text-yellow-600">{{ $sakit }}</span>
                </div>

                <div class="flex items-center justify-between rounded-lg bg-red-50 border border-red-200 px-3 py-2">
                    <span class="text-xs text-red-700">Alfa</span>
                    <span class="text-base font-bold text-red-600">{{ $alfa }}</span>
                </div>

                <div class="flex items-center justify-between rounded-lg bg-indigo-50 border border-indigo-200 px-3 py-2">
                    <span class="text-xs text-indigo-700">Simpan</span>
                    <span class="text-base font-bold text-indigo-600">{{ $tersimpan }}</span>
                </div>

                <div class="flex items-center justify-between rounded-lg bg-gray-50 border border-gray-200 px-3 py-2">
                    <span class="text-xs text-gray-700">Total</span>
                    <span class="text-base font-bold text-gray-700">{{ $total }}</span>
                </div>

            </div>
            {{-- ACTION --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                <a href="/sesikelas"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    ← Kembali
                </a>

                <button
                    form="formPresensi"
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    💾 Simpan Presensi
                </button>

            </div>

            {{-- FORM --}}
            <form id="formPresensi" action="/absensikelas" method="POST">
                @csrf

                <input type="hidden" name="prev_url" value="{{ $prev_url }}">
                <input type="hidden" name="sesikelas" value="{{ $sesikelas->id }}">

                <div class="bg-white shadow rounded-xl overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full  text-sm table-auto">

                            <thead class="bg-gray-50 border-b">
                                <tr>

                                    <th class="w-12 px-2 py-2 text-center">
                                        No
                                    </th>

                                    <th class="px-2 w-40 py-2 text-left">
                                        Nama Siswa
                                    </th>

                                    <th class=" px-2 py-2 text-center">
                                        Kehadiran
                                    </th>

                                    <!-- <th class="w-44 px-2 py-2">
                                        Alasan
                                    </th> -->

                                </tr>
                            </thead>

                            <tbody>

                                @foreach($dataSiswa as $item)

                                @php
                                $isSaved = !is_null($item->absensikelas_id);
                                $current = $item->keterangan ?? 'hadir';
                                @endphp

                                <tr class="border-t hover:bg-gray-50 transition">

                                    <td class="px-2 py-2 text-center align-top">

                                        {{ $loop->iteration }}

                                        <input
                                            type="hidden"
                                            name="pesertakelas[]"
                                            value="{{ $item->id }}">

                                        <input
                                            type="hidden"
                                            name="absensikelas[{{ $item->id }}]"
                                            value="{{ $item->absensikelas_id }}">

                                    </td>

                                    <td class="px-2 py-2 align-top">
                                        <div class="font-medium leading-tight break-words  md:max-w-xs">
                                            {{ $item->nama_siswa }}
                                        </div>

                                    </td>

                                    <td class="px-2 py-2 align-top">

                                        <div class="flex justify-center gap-1">

                                            @foreach([
                                            'hadir'=>'H',
                                            'izin'=>'I',
                                            'sakit'=>'S',
                                            'alfa'=>'A'
                                            ] as $key=>$label)

                                            @php
                                            $selected = old("keterangan.$item->id", $current) == $key;
                                            @endphp

                                            <label>

                                                <input
                                                    type="radio"
                                                    class="hidden peer"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $key }}"
                                                    {{ $selected ? 'checked' : '' }}>

                                                <span
                                                    class="
                            flex items-center justify-center
                            w-7 h-7 md:w-9 md:h-9
                            rounded-md
                            border
                            text-[10px] md:text-xs
                            font-semibold
                            cursor-pointer
                            transition-all

                            border-gray-300
                            bg-white
                            text-gray-600

                            peer-checked:text-white

                            {{ $key == 'hadir'
                                ? 'peer-checked:bg-green-600 peer-checked:border-green-600'
                                : '' }}

                            {{ $key == 'izin'
                                ? 'peer-checked:bg-blue-600 peer-checked:border-blue-600'
                                : '' }}

                            {{ $key == 'sakit'
                                ? 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500'
                                : '' }}

                            {{ $key == 'alfa'
                                ? 'peer-checked:bg-red-600 peer-checked:border-red-600'
                                : '' }}

                            {{ !$isSaved && $key == 'hadir' && $selected
                                ? 'bg-red-100 border-red-300 text-red-700'
                                : '' }}
                        ">
                                                    {{ $label }}
                                                </span>

                                            </label>

                                            @endforeach

                                        </div>

                                    </td>

                                    <!-- <td class="px-2 py-2 align-top">

                                        <input
                                            type="text"
                                            name="alasan[{{ $item->id }}]"
                                            value="{{ old("alasan.$item->id", $item->alasan) }}"
                                            class="w-full min-w-[120px] md:min-w-[180px] rounded-md border border-gray-300 px-2 py-1.5 text-xs md:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Opsional...">

                                    </td> -->

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </form>
            {{-- NOTE / TUTORIAL --}}
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-3">
                <div class="flex items-start gap-2">
                    <span class="text-lg">💡</span>

                    <div class="text-xs md:text-sm text-gray-700">
                        <p class="font-semibold text-amber-700 mb-1">
                            Petunjuk Presensi
                        </p>

                        <ul class="list-disc list-inside space-y-1">
                            <li><b>Merah muda</b> = default hadir, belum disimpan.</li>
                            <li>Pilih <b>H / I / S / A</b> sesuai kehadiran.</li>
                            <li>Isi alasan jika diperlukan.</li>
                            <li>Tekan <b>💾 Simpan Presensi</b>.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>