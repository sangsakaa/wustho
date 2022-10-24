<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Blanko Presensi Kelas')
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Blanko Presensi Kelas') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/absensikelas/blanko" method="get" class="w-full">
                        {{-- @csrf --}}
                        <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">
                        <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/5 py-1 dark:bg-dark-bg" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($dataKelasMi as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Pilih Blanko
                        </button>
                    </form>
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    @if($kelasmi)
    <div class="py-1">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            <div class="p-4 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 ">
                    Bulan : {{ $bulan->monthName }}
                    Kelas : {{ $kelasmi->nama_kelas }}
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="border text-xs sm:text-sm">
                                <th class="border px-1 w-8" rowspan="2">No</th>
                                <th class="border px-1 w-1/5" rowspan="2">Nama Siswa</th>
                                <th class="border px-1 w-9" rowspan="2">Kls</th>
                                <th class="border px-1 " colspan="{{ $periodeBulan->count() }}">Tanggal</th>
                            </tr>
                            <tr class="border text-xs sm:text-sm">
                                @foreach ($periodeBulan as $hari)
                                <th class="border {{ $hari->isThursday() ? "bg-gray-200" : "" }}">{{ $hari->day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSiswa as $siswa)
                            <tr class=" border    text-xs sm:text-sm ">
                                <td class="border text-center px-1">{{ $loop->iteration }}</td>
                                <td class="border px-1 text-sm">{{ $siswa->nama_siswa }}</td>
                                <td class="border text-center px-1">{{ $siswa->nama_kelas }}</td>
                                @foreach ($periodeBulan as $hari)
                                <td class="border {{ $hari->isThursday() ? "bg-gray-200" : "" }}"></td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>