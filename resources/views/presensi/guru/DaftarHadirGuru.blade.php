<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Presensi Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ALERT --}}
            @if (session('status'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
                {{ session('status') }}
            </div>
            @endif

            {{-- HEADER CARD --}}
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Presensi Guru
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($title->tanggal)->translatedFormat('l, j F Y') }}
                            </p>
                        </div>

                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-sm font-medium">
                            Kelas: {{ $title->nama_kelas }}
                        </div>
                    </div>
                </div>
            </div>

            <form action="/sesi-presensi-guru/{{ $sesi_Kelas_Guru->id }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="sesi_kelas_guru_id" value="{{ $sesi_Kelas_Guru->id }}">

                {{-- ACTION BUTTON --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 transition">
                        Simpan Presensi
                    </button>

                    <a href="/sesi-presensi-guru"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>
                </div>

                {{-- TABLE --}}
                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Guru</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Keterangan</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Alasan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($dataGuru as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4 text-center text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900 capitalize">
                                            {{ strtolower($item->nama_guru) }}
                                        </div>
                                        <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-4">
                                        <div class="flex justify-center gap-2 flex-wrap">
                                            @foreach([
                                            'hadir' => 'Hadir',
                                            'izin' => 'Izin',
                                            'sakit' => 'Sakit',
                                            'alfa' => 'Alfa',
                                            ] as $val => $label)

                                            <label>
                                                <input
                                                    type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $val }}"
                                                    class="peer hidden"
                                                    {{
                        old("keterangan.$item->id", $item->keterangan ?? 'hadir') === $val
                        ? 'checked'
                        : ''
                    }}>

                                                <span
                                                    @class([ 'inline-flex cursor-pointer rounded-lg border px-3 py-2 text-xs font-medium transition' , 'text-gray-600 border-gray-300' , 'peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600'=> $val === 'hadir',
                                                    'peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600' => $val === 'izin',
                                                    'peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500' => $val === 'sakit',
                                                    'peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600' => $val === 'alfa',
                                                    ])
                                                    >
                                                    {{ $label }}
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- ALASAN --}}
                                    <td class="px-4 py-4">
                                        <input
                                            type="text"
                                            value="{{ old("alasan.$item->id", $item->alasan) }}"
                                            name="alasan[{{ $item->id }}]"
                                            placeholder="Isi alasan jika tidak hadir"
                                            class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>