td<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard Presensi Perangkat
        </h2>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-5">

            @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
            @endif

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
                                $item->absensiHariIni?->keterangan ?? 'hadir'
                                );

                                $alasan = old(
                                "alasan.$item->id",
                                $item->absensiHariIni?->alasan
                                );
                                @endphp

                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>

                                    <td class="px-4 py-3 capitalize">
                                        {{ strtolower($item->nama_perangkat) }}
                                        <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">

                                            @foreach([
                                            'hadir' => ['H', 'green'],
                                            'izin' => ['I', 'yellow'],
                                            'sakit' => ['S', 'blue'],
                                            'alfa' => ['A', 'red'],
                                            ] as $value => [$label, $color])

                                            <label class="cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="keterangan[{{ $item->id }}]"
                                                    value="{{ $value }}"
                                                    class="peer sr-only"
                                                    {{ $selected === $value ? 'checked' : '' }}>

                                                <span class="
                                                            inline-flex w-10 h-10 items-center justify-center
                                                            rounded-lg border-2 border-gray-300
                                                            bg-white text-gray-700 text-xs font-semibold
                                                            transition-all duration-200
                                                            peer-checked:text-white
                                                            peer-checked:scale-110

                                                            {{ $color === 'green' ? 'peer-checked:bg-green-600 peer-checked:border-green-600' : '' }}
                                                            {{ $color === 'yellow' ? 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500' : '' }}
                                                            {{ $color === 'blue' ? 'peer-checked:bg-blue-600 peer-checked:border-blue-600' : '' }}
                                                            {{ $color === 'red' ? 'peer-checked:bg-red-600 peer-checked:border-red-600' : '' }}
                                                        ">
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
                                            value="{{ $alasan }}"
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
                    $item->absensiHariIni?->keterangan ?? 'hadir'
                    );

                    $alasan = old(
                    "alasan.$item->id",
                    $item->absensiHariIni?->alasan
                    );
                    @endphp

                    <div class="bg-white shadow rounded-2xl p-5 space-y-4">
                        <h3 class="font-semibold capitalize">{{ $item->nama_perangkat }}</h3>

                        <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">

                        <div class="grid grid-cols-4 gap-2">

                            @foreach([
                            'hadir' => ['H', 'green'],
                            'izin' => ['I', 'yellow'],
                            'sakit' => ['S', 'blue'],
                            'alfa' => ['A', 'red'],
                            ] as $value => [$label, $color])

                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="keterangan[{{ $item->id }}]"
                                    value="{{ $value }}"
                                    class="peer sr-only"
                                    {{ $selected === $value ? 'checked' : '' }}>

                                <span class="
                                            inline-flex w-full h-11 items-center justify-center
                                            rounded-lg border-2 border-gray-300
                                            bg-white text-gray-700 text-sm font-semibold
                                            transition-all duration-200
                                            peer-checked:text-white
                                            peer-checked:scale-105

                                            {{ $color === 'green' ? 'peer-checked:bg-green-600 peer-checked:border-green-600' : '' }}
                                            {{ $color === 'yellow' ? 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500' : '' }}
                                            {{ $color === 'blue' ? 'peer-checked:bg-blue-600 peer-checked:border-blue-600' : '' }}
                                            {{ $color === 'red' ? 'peer-checked:bg-red-600 peer-checked:border-red-600' : '' }}
                                        ">
                                    {{ $label }}
                                </span>
                            </label>
                            @endforeach
                        </div>

                        <input
                            type="text"
                            name="alasan[{{ $item->id }}]"
                            value="{{ $alasan }}"
                            placeholder="Isi alasan..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm">
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</x-app-layout>