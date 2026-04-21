<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Presensi Perangkat
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- NOTIFIKASI --}}
        @if (session('status'))
        <div class="bg-green-600 text-white px-4 py-2 rounded-lg shadow">
            {{ session('status') }}
        </div>
        @endif

        {{-- HEADER INFO --}}
        <div class="bg-white shadow rounded-xl p-4">
            <h3 class="text-lg font-semibold text-blue-600 mb-2">
                Presensi Perangkat
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
                <div class="font-medium text-gray-600">Hari / Tanggal</div>
                <div class="col-span-1 sm:col-span-3">
                    :
                    <span class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($sesiPerangkat->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <form action="/daftar-sesi-perangkat/{{ $sesiPerangkat->id }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="sesi_perangkat_id" value="{{ $sesiPerangkat->id }}">

            {{-- ACTION --}}
            <div class="flex flex-wrap gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                    💾 Simpan Presensi
                </button>

                <a href="/sesi-perangkat"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow text-sm">
                    ⬅ Kembali
                </a>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-sm">

                        {{-- HEADER --}}
                        <thead class="bg-gray-100 text-xs uppercase sticky top-0 z-10">
                            <tr>
                                <th class="px-2 py-2 text-center w-10">No</th>
                                <th class="px-2 py-2 text-left">Nama Perangkat</th>
                                <th class="px-2 py-2 text-center">Keterangan</th>
                                <th class="px-2 py-2 text-center">Alasan</th>
                            </tr>
                        </thead>

                        {{-- BODY --}}
                        <tbody>
                            @foreach ($dataPerangkat as $item)
                            <tr class="border-t hover:bg-gray-50">

                                <td class="text-center py-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-2 capitalize">
                                    {{ strtolower($item->nama_perangkat) }}
                                    <input type="hidden" name="perangkat_id[]" value="{{ $item->id }}">
                                </td>

                                {{-- RADIO --}}
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 text-xs">

                                        @foreach (['hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alfa' => 'A'] as $val => $label)
                                        <label class="cursor-pointer">
                                            <input type="radio"
                                                name="keterangan[{{ $item->id }}]"
                                                value="{{ $val }}"
                                                class="hidden peer"
                                                {{ $item->keterangan === $val || ($val === 'hadir' && $item->keterangan === null) ? 'checked' : '' }}>

                                            <span class="px-2 py-1 rounded-md border 
                                                peer-checked:bg-blue-600 
                                                peer-checked:text-white 
                                                hover:bg-gray-200">
                                                {{ $label }}
                                            </span>
                                        </label>
                                        @endforeach

                                    </div>
                                </td>

                                {{-- ALASAN --}}
                                <td class="px-2 py-2">
                                    <input
                                        value="{{ $item->alasan }}"
                                        name="alasan[{{ $item->id }}]"
                                        placeholder="Isi alasan..."
                                        class="w-full border rounded-md px-2 py-1 text-center focus:ring focus:ring-blue-200">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </form>
    </div>
</x-app-layout>