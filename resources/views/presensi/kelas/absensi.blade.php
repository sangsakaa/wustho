<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas : ' . $dataKelas->nama_kelas)

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="font-semibold text-lg sm:text-xl">
                Presensi Kelas
            </h2>
            <span class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($sesikelas->tgl)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </x-slot>

    {{-- HITUNG DATA --}}
    @php
    $hadir = $dataSiswa->where('keterangan', 'hadir')->count();
    $izin = $dataSiswa->where('keterangan', 'izin')->count();
    $sakit = $dataSiswa->where('keterangan', 'sakit')->count();
    $alfa = $dataSiswa->where('keterangan', 'alfa')->count();
    $total = count($dataSiswa);
    @endphp

    {{-- INFO KELAS --}}
    <div class="bg-white shadow-sm rounded p-4 mb-3">
        <div class="grid sm:grid-cols-2 gap-2 text-sm">
            <div><b>Kelas</b> : {{ $dataKelas->nama_kelas }}</div>
            <div><b>Semester</b> : {{ $dataKelas->semester }}</div>
            <div><b>Periode</b> : {{ $dataKelas->periode }} {{ $dataKelas->ket_semester }}</div>
            <div>
                <b>Disimpan</b> :
                {{ $diSimpanPada ? \Carbon\Carbon::parse($diSimpanPada)->isoFormat('D MMM YYYY') : '-' }}
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-3 text-center text-sm">

        <div class="bg-green-500 text-white rounded p-3 shadow">
            <div class="text-lg font-bold">{{ $hadir }}</div>
            <div>Hadir</div>
        </div>

        <div class="bg-yellow-400 rounded p-3 shadow">
            <div class="text-lg font-bold">{{ $izin }}</div>
            <div>Izin</div>
        </div>

        <div class="bg-orange-500 text-white rounded p-3 shadow">
            <div class="text-lg font-bold">{{ $sakit }}</div>
            <div>Sakit</div>
        </div>

        <div class="bg-red-600 text-white rounded p-3 shadow">
            <div class="text-lg font-bold">{{ $alfa }}</div>
            <div>Alfa</div>
        </div>

        <div class="bg-gray-600 text-white rounded p-3 shadow">
            <div class="text-lg font-bold">{{ $total }}</div>
            <div>Total</div>
        </div>

    </div>

    {{-- ACTION BAR --}}
    <div class="bg-white shadow-sm rounded p-3 mb-3 flex flex-wrap gap-2 justify-between items-center">

        <div class="text-sm text-gray-600">
            Progress:
            <b>{{ $hadir + $izin + $sakit + $alfa }}</b> / {{ $total }}
        </div>

        <div class="flex gap-2">
            <a href="{{ $prev_url }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                ← Kembali
            </a>

            <button form="formPresensi"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                💾 Simpan
            </button>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session('status'))
    <div class="mb-3 px-3 py-2 bg-green-500 text-white rounded shadow">
        {{ session('status') }}
    </div>
    @endif

    {{-- FORM --}}
    <form id="formPresensi" action="/absensikelas" method="post">
        @csrf
        <input type="hidden" name="prev_url" value="{{ $prev_url }}">
        <input type="hidden" name="sesikelas" value="{{ $sesikelas->id }}">

        <div class="bg-white shadow-sm rounded overflow-hidden">
            <div class="overflow-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="border px-2 py-2 w-12">No</th>
                            <th class="border px-2 py-2 text-left">Nama Siswa</th>
                            <th class="border px-2 py-2">Kehadiran</th>
                            <th class="border px-2 py-2">Alasan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dataSiswa as $item)
                        <tr class="hover:bg-gray-50">

                            <td class="border px-2 py-2 text-center">
                                {{ $loop->iteration }}
                                <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                <input type="hidden" name="absensikelas[{{ $item->id }}]" value="{{ $item->absensikelas_id }}">
                            </td>

                            <td class="border px-2 py-2 capitalize">
                                {{ strtolower($item->nama_siswa) }}
                            </td>

                            <td class="border px-2 py-2 text-center">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    @foreach (['hadir'=>'H','izin'=>'I','sakit'=>'S','alfa'=>'A'] as $key => $label)
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                            name="keterangan[{{ $item->id }}]"
                                            value="{{ $key }}"
                                            class="hidden peer"
                                            {{ $item->keterangan === $key || ($key=='hadir' && $item->keterangan==null) ? 'checked' : '' }}>

                                        <span class="px-2 py-1 border rounded
                                                    peer-checked:bg-blue-600
                                                    peer-checked:text-white
                                                    hover:bg-gray-200 text-xs">
                                            {{ $label }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </td>

                            <td class="border px-2 py-2">
                                <input type="text"
                                    name="alasan[{{ $item->id }}]"
                                    value="{{ $item->alasan }}"
                                    placeholder="Opsional..."
                                    class="w-full border px-2 py-1 rounded focus:ring focus:ring-blue-200">
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- LEGEND --}}
    <div class="mt-3 bg-gray-50 border rounded p-3 text-sm flex gap-3 flex-wrap">
        <span class="px-2 py-1 bg-green-500 text-white rounded">H = Hadir</span>
        <span class="px-2 py-1 bg-yellow-400 rounded">I = Izin</span>
        <span class="px-2 py-1 bg-orange-500 text-white rounded">S = Sakit</span>
        <span class="px-2 py-1 bg-red-600 text-white rounded">A = Alfa</span>
    </div>

</x-app-layout>