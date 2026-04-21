<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Sesi Perangkat '.\Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y'))
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Sesi Perangkat : {{ \Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y') }}
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- TOAST NOTIF --}}
        @foreach (['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $type => $color)
        @if(session($type))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="fixed top-5 right-5 bg-{{ $color }}-600 text-white px-5 py-3 rounded-lg shadow z-50">
            {{ session($type) }}
        </div>
        @endif
        @endforeach

        {{-- FILTER & ACTION --}}
        <div class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-2 items-center justify-between">

            <div class="flex flex-wrap gap-2">
                {{-- FILTER TANGGAL --}}
                <form action="/sesi-perangkat" method="GET" class="flex gap-2">
                    <input type="date"
                        name="tanggal"
                        value="{{ $tanggal->toDateString() }}"
                        class="border rounded-md px-3 py-1 text-sm focus:ring focus:ring-blue-200">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm">
                        Filter
                    </button>
                </form>

                {{-- BUAT SESI --}}
                <form action="/sesi-perangkat" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm">
                        + Buat Sesi
                    </button>
                </form>
            </div>

            {{-- LINK LAPORAN --}}
            <div class="flex flex-wrap gap-2 text-sm">
                <a href="/laporan-harian-perangkat" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-md">
                    Harian
                </a>
                <a href="/laporan-Bulanan-perangkat" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-md">
                    Bulanan
                </a>
                <a href="/rekap-Bulanan" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-md">
                    Rekap
                </a>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    {{-- HEADER --}}
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-3 py-2 text-center w-10">No</th>
                            <th class="px-3 py-2 text-center">Tanggal</th>
                            <th class="px-3 py-2 text-center">Periode</th>
                            <th class="px-3 py-2 text-center">Status</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody>
                        @forelse($dataSesiPerangkat as $org)
                        <tr class="border-t hover:bg-gray-50 text-center">

                            <td class="px-3 py-2">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-3 py-2">
                                <a href="/daftar-sesi-perangkat/{{ $org->id }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                                </a>
                            </td>

                            <td class="px-3 py-2">
                                <div class="font-semibold">
                                    {{ $org->periode }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $org->ket_semester }}
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-3 py-2">
                                @if($org->SesiP !== null)
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">
                                    Sudah Absen
                                </span>
                                @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                    Belum Absen
                                </span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500 italic">
                                Data sesi belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</x-app-layout>