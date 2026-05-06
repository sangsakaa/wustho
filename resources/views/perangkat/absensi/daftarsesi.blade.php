<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Perangkat
        </h2>
    </x-slot>

    <div class="p-3 sm:p-6">
        <div class="max-w-6xl mx-auto space-y-5">

            {{-- NOTIFIKASI --}}
            @if (session('status'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                {{ session('status') }}
            </div>
            @endif

            {{-- HEADER INFO --}}
            <div class="bg-white shadow-sm border rounded-2xl p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-blue-600 mb-4">
                    Presensi Perangkat
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Hari / Tanggal</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($sesiPerangkat->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form action="/daftar-sesi-perangkat/{{ $sesiPerangkat->id }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="sesi_perangkat_id" value="{{ $sesiPerangkat->id }}">

                {{-- ACTION --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 sm:py-2 rounded-xl shadow text-sm">
                        Simpan Presensi
                    </button>

                    <a href="/sesi-perangkat"
                        class="w-full sm:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 sm:py-2 rounded-xl text-sm">
                        Kembali
                    </a>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block bg-white shadow-sm border rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto max-h-[550px]">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-xs uppercase sticky top-0 z-10 text-slate-600">
                                <tr>
                                    <th class="px-3 py-3 text-center w-16">No</th>
                                    <th class="px-3 py-3 text-left">Nama Perangkat</th>
                                    <th class="px-3 py-3 text-center">Keterangan</th>
                                    <th class="px-3 py-3 text-center">Alasan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @foreach ($dataPerangkat as $item)
                                <tr class="hover:bg-slate-50">

                                    <td class="text-center py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-3 py-3 capitalize">
                                        {{ strtolower($item->nama_perangkat) }}
                                        <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                                    </td>

                                    {{-- RADIO --}}
                                    <td class="text-center">
                                        <div class="flex justify-center gap-2 text-xs">
                                            @foreach (['hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alfa' => 'A'] as $val => $label)
                                            <label class="cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $val }}"
                                                    class="hidden peer"
                                                    {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>

                                                <span class="px-3 py-1 rounded-lg border
                                                            peer-checked:bg-blue-600
                                                            peer-checked:text-white
                                                            hover:bg-slate-100">
                                                    {{ $label }}
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- ALASAN --}}
                                    <td class="px-3 py-3">
                                        <input
                                            value="{{ $item->alasan }}"
                                            name="alasan[{{ $item->id }}]"
                                            placeholder="Isi alasan..."
                                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE CARD --}}
                <div class="md:hidden space-y-4">
                    @foreach ($dataPerangkat as $item)
                    <div class="bg-white border shadow-sm rounded-2xl p-4 space-y-4">

                        <div>
                            <h3 class="font-semibold text-slate-800 capitalize">
                                {{ strtolower($item->nama_perangkat) }}
                            </h3>
                            <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                        </div>

                        {{-- RADIO MOBILE --}}
                        <div>
                            <p class="text-xs text-slate-500 mb-2">Keterangan</p>

                            <div class="grid grid-cols-2 gap-2">
                                @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alfa'] as $val => $label)
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="keterangan[{{ $item->id }}]"
                                        value="{{ $val }}"
                                        class="hidden peer"
                                        {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>

                                    <div class="border rounded-xl px-3 py-3 text-center text-sm
                                                peer-checked:bg-blue-600
                                                peer-checked:text-white
                                                peer-checked:border-blue-600">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- ALASAN --}}
                        <div>
                            <p class="text-xs text-slate-500 mb-2">Alasan</p>
                            <input
                                value="{{ $item->alasan }}"
                                name="alasan[{{ $item->id }}]"
                                placeholder="Isi alasan..."
                                class="w-full border rounded-xl px-3 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>
                    @endforeach
                </div>

            </form>
        </div>
    </div>
</x-app-layout>