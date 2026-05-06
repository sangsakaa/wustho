<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Sesi Perangkat '.\Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y'))

        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-lg sm:text-xl text-gray-800">
                Sesi Perangkat
            </h2>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($hariIni)->isoFormat('dddd, DD MMMM Y') }}
            </p>
        </div>
    </x-slot>

    <div class="p-3 sm:p-6">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- TOAST --}}
            @foreach (['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $type => $color)
            @if(session($type))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 bg-{{ $color }}-600 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm">
                {{ session($type) }}
            </div>
            @endif
            @endforeach

            {{-- FILTER + ACTION --}}

            <div class="bg-white shadow-sm border rounded-2xl p-4 space-y-4">

                <div class="flex w-full flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

                    {{-- LEFT SECTION --}}
                    <div class="flex flex-col lg:flex-row gap-3 w-full lg:w-auto">

                        {{-- FILTER --}}
                        <form action="/sesi-perangkat" method="GET"
                            class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto shrink-0">

                            <input
                                type="date"
                                name="tanggal"
                                value="{{ $tanggal->toDateString() }}"
                                class="border rounded-xl px-3 py-2 text-sm w-full sm:w-auto
                           focus:ring-2 focus:ring-blue-200 focus:outline-none">

                            <button
                                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700
                           text-white px-4 py-2 rounded-xl text-sm shadow-sm whitespace-nowrap">
                                Filter
                            </button>
                        </form>

                        {{-- BUAT SESI --}}
                        <form action="/sesi-perangkat" method="POST"
                            class="w-full lg:w-auto shrink-0">
                            @csrf
                            <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">

                            <button
                                class="w-full lg:w-auto bg-green-600 hover:bg-green-700
                           text-white px-4 py-2 rounded-xl text-sm shadow-sm whitespace-nowrap">
                                + Buat Sesi
                            </button>
                        </form>
                    </div>

                    {{-- RIGHT SECTION --}}
                    <div class="grid grid-cols-3 sm:flex gap-2 w-full lg:w-auto">
                        <a href="/laporan-harian-perangkat"
                            class="text-center bg-slate-100 hover:bg-slate-200
                       text-slate-700 px-4 py-2 rounded-xl text-sm shadow-sm whitespace-nowrap">
                            Harian
                        </a>

                        <a href="/laporan-Bulanan-perangkat"
                            class="text-center bg-slate-100 hover:bg-slate-200
                       text-slate-700 px-4 py-2 rounded-xl text-sm shadow-sm whitespace-nowrap">
                            Bulanan
                        </a>

                        <a href="/rekap-Bulanan"
                            class="text-center bg-slate-100 hover:bg-slate-200
                       text-slate-700 px-4 py-2 rounded-xl text-sm shadow-sm whitespace-nowrap">
                            Rekap
                        </a>
                    </div>

                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block bg-white shadow-sm border rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-center w-16">No</th>
                                <th class="px-4 py-3 text-center">Tanggal</th>
                                <th class="px-4 py-3 text-center">Periode</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($dataSesiPerangkat as $org)
                            <tr class="hover:bg-slate-50 text-center">

                                <td class="px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="/daftar-sesi-perangkat/{{ $org->id }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                                    </a>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-semibold">
                                        {{ $org->periode }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $org->ket_semester }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    @if($org->SesiP !== null)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Sudah Absen
                                    </span>
                                    @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        Belum Absen
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-slate-400">
                                    Data sesi belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MOBILE CARD --}}
            <div class="md:hidden space-y-3">
                @forelse($dataSesiPerangkat as $org)
                <div class="bg-white border shadow-sm rounded-2xl p-4 space-y-3">

                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-400">Tanggal</p>
                            <a href="/daftar-sesi-perangkat/{{ $org->id }}"
                                class="text-blue-600 font-medium text-sm">
                                {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat('DD MMMM Y') }}
                            </a>
                        </div>

                        <span class="text-xs bg-slate-100 px-2 py-1 rounded-lg">
                            #{{ $loop->iteration }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-slate-400 text-xs">Periode</p>
                            <p class="font-medium">{{ $org->periode }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 text-xs">Semester</p>
                            <p class="font-medium">{{ $org->ket_semester }}</p>
                        </div>
                    </div>

                    <div>
                        @if($org->SesiP !== null)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            Sudah Absen
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                            Belum Absen
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white border rounded-2xl p-8 text-center text-slate-400">
                    Data sesi belum tersedia
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>