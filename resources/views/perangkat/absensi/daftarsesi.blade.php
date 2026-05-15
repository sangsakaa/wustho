<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Perangkat
        </h2>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-5">

            {{-- NOTIFIKASI --}}
            @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
            @endif

            {{-- HEADER --}}
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-5">
                    <h3 class="text-lg font-semibold text-white">
                        Presensi Perangkat
                    </h3>
                    <p class="text-blue-100 text-sm">
                        {{ \Carbon\Carbon::parse($sesiPerangkat->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                    </p>
                </div>
            </div>

            <form action="/daftar-sesi-perangkat/{{ $sesiPerangkat->id }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="sesi_perangkat_id" value="{{ $sesiPerangkat->id }}">

                {{-- BUTTON --}}
                <div class="flex gap-3 flex-col sm:flex-row">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow">
                        Simpan Presensi
                    </button>

                    <a href="/sesi-perangkat"
                        class="bg-white border border-gray-300 px-6 py-3 rounded-xl text-center hover:bg-gray-50">
                        Kembali
                    </a>
                </div>

                {{-- DESKTOP --}}
                <div class="hidden md:block bg-white shadow rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-center">No</th>
                                    <th class="px-4 py-3 text-left">Nama Perangkat</th>
                                    <th class="px-4 py-3 text-center">Keterangan</th>
                                    <th class="px-4 py-3 text-left">Alasan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @foreach ($dataPerangkat as $item)
                                @php
                                $selected = old(
                                "keterangan.$item->id",
                                $item->status_presensi ?? 'hadir'
                                );
                                @endphp

                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ strtolower($item->nama_perangkat) }}
                                        <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            @foreach (['hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alfa' => 'A'] as $val => $label)
                                            @php
                                            $colorClass = match($val) {
                                            'hadir' => 'peer-checked:bg-green-600 peer-checked:border-green-600',
                                            'izin' => 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500',
                                            'sakit' => 'peer-checked:bg-blue-600 peer-checked:border-blue-600',
                                            'alfa' => 'peer-checked:bg-red-600 peer-checked:border-red-600',
                                            default => 'peer-checked:bg-gray-600 peer-checked:border-gray-600',
                                            };
                                            @endphp

                                            <label class="cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $val }}"
                                                    class="peer hidden"
                                                    {{ old("keterangan.$item->id", $selected) == $val ? 'checked' : '' }}>

                                                <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg border-2
                    text-xs font-medium transition-all duration-200
                    border-gray-300 text-gray-700 bg-white
                    peer-checked:text-white
                    {{ $colorClass }}">
                                                    {{ $label }}
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <input
                                            type="text"
                                            name="alasan[{{ $item->id }}]"
                                            value="{{ old("alasan.$item->id", $item->alasan_presensi) }}"
                                            placeholder="Isi alasan..."
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE --}}
                <div class="md:hidden space-y-4">
                    @foreach ($dataPerangkat as $item)
                    @php
                    $selected = old(
                    "keterangan.$item->id",
                    $item->status_presensi ?? 'hadir'
                    );
                    @endphp

                    <div class="bg-white shadow rounded-2xl p-5 space-y-4">
                        <div>
                            <h3 class="font-semibold ">
                                {{ $item->nama_perangkat }}
                            </h3>
                            <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-2">
                                Keterangan
                            </p>

                            <div class="grid grid-cols-4 gap-2">
                                @php
                                $selected = $item->absensiHariIni?->keterangan;
                                @endphp

                                @foreach (['hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alfa' => 'A'] as $val => $label)
                                @php
                                $colorClass = match($val) {
                                'hadir' => 'peer-checked:bg-green-600 peer-checked:border-green-600',
                                'izin' => 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500',
                                'sakit' => 'peer-checked:bg-orange-500 peer-checked:border-orange-500',
                                'alfa' => 'peer-checked:bg-red-600 peer-checked:border-red-600',
                                default => 'peer-checked:bg-gray-600 peer-checked:border-gray-600',
                                };
                                @endphp

                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="keterangan[{{ $item->id }}]"
                                        value="{{ $val }}"
                                        class="peer hidden"
                                        {{ old("keterangan.$item->id", $selected) == $val ? 'checked' : '' }}>

                                    <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg border-2
                text-xs font-medium transition-all
                border-gray-300 text-gray-700 bg-white
                peer-checked:text-white
                {{ $colorClass }}">
                                        {{ $label }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-2">
                                Alasan
                            </p>

                            <input
                                type="text"
                                name="alasan[{{ $item->id }}]"
                                value="{{ old("alasan.$item->id", $item->alasan_presensi) }}"
                                placeholder="Isi alasan..."
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm">
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</x-app-layout>