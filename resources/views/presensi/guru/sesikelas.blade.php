<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas Guru')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="font-semibold text-lg sm:text-xl">
                Presensi Kelas Guru
            </h2>
            <span class="text-gray-500 text-xs sm:text-sm">
                {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, DD MMMM Y') }}
            </span>
        </div>
    </x-slot>

    <div class="p-4 space-y-5">

        {{-- ================= SUMMARY ================= --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-3">
            @foreach($summary as $key => $val)
            @php
            $colors = [
            'total_sesi'=>'blue','total_absen'=>'green','belum_absen'=>'red',
            'hadir'=>'emerald','izin'=>'yellow','sakit'=>'purple','alfa'=>'gray'
            ];
            $labels = [
            'total_sesi'=>'Total Sesi','total_absen'=>'Sudah Absen','belum_absen'=>'Belum Absen',
            'hadir'=>'Hadir','izin'=>'Izin','sakit'=>'Sakit','alfa'=>'Alfa'
            ];
            @endphp

            <div class="bg-white border rounded-2xl p-4 text-center shadow-sm">
                <div class="text-xs text-gray-500">{{ $labels[$key] }}</div>
                <div class="text-xl font-bold text-{{ $colors[$key] }}-600">
                    {{ $val }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- 🔥 TOMBOL BULK DELETE (TAMBAHAN) --}}
        <button type="button" id="btn-bulk-delete"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
            Hapus Terpilih
        </button>

        {{-- ================= TOOLBAR ================= --}}
        <div class="bg-white border rounded-2xl p-4 flex flex-col md:flex-row md:justify-between md:items-center gap-3 shadow-sm">

            {{-- FILTER --}}
            <form action="/sesi-presensi-guru" method="get" class="flex items-center gap-2">
                <input type="date" name="tanggal"
                    value="{{ $tanggal->toDateString() }}"
                    class="border rounded-xl px-3 py-2 text-sm">

                <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm">
                    Filter
                </button>
            </form>

            {{-- ACTION --}}
            <div class="flex flex-wrap gap-2">

                <form action="/sesi-presensi-guru" method="post">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                        + Sesi
                    </button>
                </form>

                {{-- MENU --}}
                @php
                $menus = [
                ['url'=>'/laporan-harian-guru','label'=>'Harian','color'=>'blue'],
                ['url'=>'/laporan-semester-guru','label'=>'Semester','color'=>'purple'],
                ['url'=>'/sesi-presensi-guru/rekap','label'=>'Rekap','color'=>'green'],
                ['url'=>'/rekap-kelas-mi','label'=>'Kelas','color'=>'orange'],
                ];
                @endphp

                @foreach($menus as $m)
                <a href="{{ $m['url'] }}"
                    class="px-4 py-2 text-sm rounded-xl bg-gray-100 text-gray-700
                          hover:bg-{{ $m['color'] }}-50 hover:text-{{ $m['color'] }}-600
                          transition shadow-sm">
                    {{ $m['label'] }}
                </a>
                @endforeach

            </div>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

            <form action="/sesi-presensi-guru" method="POST" id="form-bulk-delete">
                @csrf
                @method('delete')

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-center">
                                    <input type="checkbox" id="check-all">
                                </th>
                                <th class="px-4 py-3 text-center">No</th>
                                <th class="px-4 py-3 text-center">Tanggal</th>
                                <th class="px-4 py-3 text-center">Kelas</th>
                                <th class="px-4 py-3 text-center">Periode</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($sesikelas as $sesi)
                            <tr class="hover:bg-gray-50">

                                {{-- CHECKBOX --}}
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" class="check-item" value="{{ $sesi->id }}">
                                </td>

                                <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>

                                <td class="px-4 py-3 text-center">
                                    {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('DD MMM Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="/sesi-presensi-guru/{{$sesi->id}}"
                                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                        {{ $sesi->nama_kelas }} - {{ $sesi->nama_guru ?? '-' }}
                                    </a>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $sesi->periode }} {{ $sesi->ket_semester }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if($sesi->total_absen == 0)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs">
                                        Belum Absen
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                        Sudah Absen
                                    </span>
                                    @endif
                                </td>

                                {{-- DELETE SINGLE (TIDAK DIUBAH) --}}
                                <td class="px-4 py-3 text-center">
                                    <form action="/sesi-presensi-guru/{{ $sesi->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            onclick="return confirm('Hapus sesi {{ $sesi->nama_kelas }}?')"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-400">
                                    Tidak ada data sesi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </form>
        </div>

    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // SELECT ALL
            document.getElementById('check-all').addEventListener('change', function() {
                document.querySelectorAll('.check-item').forEach(cb => {
                    cb.checked = this.checked;
                });
            });

            // BULK DELETE
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