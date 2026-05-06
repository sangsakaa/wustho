<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Guru
        </h2>
    </x-slot>

    <div class="p-3 sm:p-6">
        <div class="max-w-6xl mx-auto space-y-5">

            {{-- HEADER INFO --}}
            <div class="bg-white rounded-2xl shadow-sm border p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-blue-600 mb-4">
                    Presensi Guru
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Hari / Tanggal</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($title->tanggal)->translatedFormat('l, j F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Kelas</p>
                        <p class="font-medium">
                            {{ $title->nama_kelas }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-2xl shadow-sm border p-4 sm:p-6">
                <form action="/sesi-presensi-guru/{{$sesi_Kelas_Guru->id}}" method="post">
                    @csrf
                    <input type="hidden" name="sesi_kelas_guru_id" value="{{ $sesi_Kelas_Guru->id }}">

                    {{-- ACTION BUTTON --}}
                    <div class="flex flex-col sm:flex-row gap-3 mb-5">
                        <button
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 sm:py-2 rounded-xl text-sm shadow">
                            Simpan Presensi
                        </button>

                        <a href="/sesi-presensi-guru"
                            class="w-full sm:w-auto text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 sm:py-2 rounded-xl text-sm">
                            Kembali
                        </a>
                    </div>

                    {{-- ALERT --}}
                    @if (session('status'))
                    <div class="mb-4 text-sm text-green-700 bg-green-100 px-4 py-3 rounded-xl">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{-- DESKTOP TABLE --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm border rounded-xl overflow-hidden">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                                <tr>
                                    <th class="px-3 py-3 text-center">No</th>
                                    <th class="px-3 py-3 text-left">Nama Guru</th>
                                    <th class="px-3 py-3 text-center">Keterangan</th>
                                    <th class="px-3 py-3 text-center">Alasan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @foreach ($dataGuru as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-3 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-3 py-3 capitalize">
                                        {{ strtolower($item->nama_guru) }}
                                        <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                                    </td>

                                    <td class="px-3 py-3">
                                        <div class="flex justify-center gap-4 text-xs">
                                            @foreach (['hadir'=>'H', 'izin'=>'I', 'sakit'=>'S', 'alfa'=>'A'] as $val => $label)
                                            <label class="flex items-center gap-1 cursor-pointer">
                                                <input type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $val }}"
                                                    class="text-blue-600"
                                                    {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>
                                                <span>{{ $label }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="px-3 py-3">
                                        <input type="text"
                                            name="alasan[{{ $item->id }}]"
                                            value="{{ $item->alasan }}"
                                            placeholder="Isi alasan..."
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE CARD --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($dataGuru as $item)
                        <div class="border rounded-2xl p-4 shadow-sm space-y-4">

                            <div>
                                <h3 class="font-semibold text-slate-800 capitalize">
                                    {{ strtolower($item->nama_guru) }}
                                </h3>
                                <input type="hidden" name="daftar_jadwal_id[]" value="{{ $item->id }}">
                            </div>

                            {{-- RADIO --}}
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Keterangan</p>

                                <div class="grid grid-cols-2 gap-2">
                                    @foreach (['hadir'=>'Hadir', 'izin'=>'Izin', 'sakit'=>'Sakit', 'alfa'=>'Alfa'] as $val => $label)
                                    <label
                                        class="flex items-center gap-2 border rounded-xl px-3 py-2 text-sm cursor-pointer">
                                        <input type="radio"
                                            name="keterangan[{{ $item->id }}]"
                                            value="{{ $val }}"
                                            class="text-blue-600"
                                            {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>
                                        <span>{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ALASAN --}}
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Alasan</p>
                                <input type="text"
                                    name="alasan[{{ $item->id }}]"
                                    value="{{ $item->alasan }}"
                                    placeholder="Isi alasan..."
                                    class="w-full border rounded-xl px-3 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>
                        @endforeach
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>