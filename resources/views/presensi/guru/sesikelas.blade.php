<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas Guru')

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                    Presensi Kelas Guru
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, DD MMMM Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-3 sm:p-6">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- SUMMARY --}}
            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-3">
                @foreach($summary as $key => $val)
                @php
                $colors = [
                'total_sesi'=>'blue',
                'total_absen'=>'green',
                'belum_absen'=>'red',
                'hadir'=>'emerald',
                'izin'=>'yellow',
                'sakit'=>'purple',
                'alfa'=>'gray'
                ];

                $labels = [
                'total_sesi'=>'Total Sesi',
                'total_absen'=>'Sudah Absen',
                'belum_absen'=>'Belum Absen',
                'hadir'=>'Hadir',
                'izin'=>'Izin',
                'sakit'=>'Sakit',
                'alfa'=>'Alfa'
                ];
                @endphp

                <div class="bg-white border rounded-2xl p-4 shadow-sm">
                    <p class="text-xs text-slate-500">{{ $labels[$key] }}</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-{{ $colors[$key] }}-600 mt-1">
                        {{ $val }}
                    </h3>
                </div>
                @endforeach
            </div>

            {{-- BULK DELETE --}}
            <button
                type="button"
                id="btn-bulk-delete"
                class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-3 sm:py-2 rounded-xl text-sm shadow">
                Hapus Terpilih
            </button>

            {{-- TOOLBAR --}}
            <div class="bg-white border rounded-2xl shadow-sm p-4 space-y-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    {{-- FILTER --}}
                    <form action="/sesi-presensi-guru" method="get"
                        class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ $tanggal->toDateString() }}"
                            class="border rounded-xl px-3 py-2 text-sm w-full sm:w-auto">

                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                            Filter
                        </button>
                    </form>

                    {{-- ACTION --}}
                    <div class="flex flex-wrap gap-2">
                        <form action="/sesi-presensi-guru" method="post">
                            @csrf
                            <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">
                            <button
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                                + Sesi
                            </button>
                        </form>

                        @php
                        $menus = [
                        ['url'=>'/laporan-harian-guru','label'=>'Harian','color'=>'blue'],
                        ['url'=>'/laporan-semester-guru','label'=>'Semester','color'=>'purple'],
                        ['url'=>'/sesi-presensi-guru/rekap','label'=>'Rekap','color'=>'green'],
                        ['url'=>'/rekap-kelas-mi','label'=>'Kelas','color'=>'orange'],
                        ];
                        @endphp

                        @foreach($menus as $m)
                        <a
                            href="{{ $m['url'] }}"
                            class="px-4 py-2 text-sm rounded-xl bg-slate-100 text-slate-700
                                hover:bg-{{ $m['color'] }}-50 hover:text-{{ $m['color'] }}-600
                                transition shadow-sm">
                            {{ $m['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <form action="/sesi-presensi-guru" method="POST" id="form-bulk-delete">
                @csrf
                @method('delete')

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block bg-white border rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600 text-xs uppercase">
                                <tr>
                                    <th class="px-3 py-3 text-center">
                                        <input type="checkbox" id="check-all">
                                    </th>
                                    <th class="px-3 py-3 text-center">No</th>
                                    <th class="px-3 py-3 text-center">Tanggal</th>
                                    <th class="px-3 py-3 text-center">Kelas</th>
                                    <th class="px-3 py-3 text-center">Periode</th>
                                    <th class="px-3 py-3 text-center">Status</th>
                                    <th class="px-3 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($sesikelas as $sesi)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-3 py-3 text-center">
                                        <input type="checkbox" class="check-item" value="{{ $sesi->id }}">
                                    </td>

                                    <td class="px-3 py-3 text-center">{{ $loop->iteration }}</td>

                                    <td class="px-3 py-3 text-center">
                                        {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('DD MMM Y') }}
                                    </td>

                                    <td class="px-3 py-3">
                                        <a href="/sesi-presensi-guru/{{$sesi->id}}"
                                            class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                            {{ $sesi->nama_kelas }} - {{ $sesi->nama_guru ?? '-' }}
                                        </a>
                                    </td>

                                    <td class="px-3 py-3 text-center">
                                        {{ $sesi->periode }} {{ $sesi->ket_semester }}
                                    </td>

                                    <td class="px-3 py-3 text-center">
                                        @if($sesi->total_absen == 0)
                                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs">
                                            Belum Absen
                                        </span>
                                        @else
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                            Sudah Absen
                                        </span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-3 text-center">
                                        <form action="/sesi-presensi-guru/{{ $sesi->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button
                                                onclick="return confirm('Hapus sesi {{ $sesi->nama_kelas }}?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-slate-400">
                                        Tidak ada data sesi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- MOBILE CARD --}}
                <div class="md:hidden space-y-3">
                    @forelse($sesikelas as $sesi)
                    <div class="bg-white border rounded-2xl shadow-sm p-4 space-y-3">

                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <h3 class="font-semibold text-slate-800 text-sm">
                                    {{ $sesi->nama_kelas }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ $sesi->nama_guru ?? '-' }}
                                </p>
                            </div>

                            <input type="checkbox" class="check-item" value="{{ $sesi->id }}">
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-slate-400">Tanggal</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('DD MMM Y') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-400">Periode</p>
                                <p class="font-medium">
                                    {{ $sesi->periode }} {{ $sesi->ket_semester }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                @if($sesi->total_absen == 0)
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs">
                                    Belum Absen
                                </span>
                                @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                    Sudah Absen
                                </span>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="/sesi-presensi-guru/{{$sesi->id}}"
                                    class="bg-blue-500 text-white px-3 py-2 rounded-lg text-xs">
                                    Detail
                                </a>

                                <form action="/sesi-presensi-guru/{{ $sesi->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button
                                        onclick="return confirm('Hapus sesi {{ $sesi->nama_kelas }}?')"
                                        class="bg-red-500 text-white px-3 py-2 rounded-lg text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-2xl p-8 text-center text-slate-400">
                        Tidak ada data sesi
                    </div>
                    @endforelse
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkAll = document.getElementById('check-all');

            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    document.querySelectorAll('.check-item').forEach(cb => {
                        cb.checked = this.checked;
                    });
                });
            }

            document.getElementById('btn-bulk-delete').addEventListener('click', function() {
                let checked = document.querySelectorAll('.check-item:checked');

                if (checked.length === 0) {
                    alert('Pilih data dulu!');
                    return;
                }

                if (confirm(`Hapus ${checked.length} data?`)) {
                    let form = document.getElementById('form-bulk-delete');

                    checked.forEach(cb => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });

                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>