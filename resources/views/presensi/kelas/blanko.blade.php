<x-app-layout>
    <x-slot name="header">
        @if($kelasmi)
        @section('title', '| Presensi Kelas : '. $kelasmi->nama_kelas)
        @endif
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Blanko Presensi Kelas') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 flex grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/absensikelas/blanko" method="get" class="w-full">
                        {{-- @csrf --}}
                        <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">
                        <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/4 py-1 dark:bg-dark-bg" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($dataKelasMi as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600  my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
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
    <div class="py-1 px-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            <div class=" py-2 px-2 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg  ">
                    <div class=" text-center text-green-900  tracking-wider flex">
                        <div class="">
                            <img src={{ asset("asset/images/logo.png") }} alt="" width="100" class="  mb-1    ">
                        </div>
                        <div class=" w-full ">
                            @if($kelasmi->jenjang === "Wustho")
                            <div class="grid   justify-items-center     ">
                                </p>
                                <p class="   text-lg uppercase font-semibold tracking-widest ">departemen pendidikan diniyah wahidiyah</p>
                                <p class="font-semibold text-3xl uppercase">
                                    MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                </p>
                                <p class="font-semibold uppercase  tracking-widest">
                                    TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                </p>
                            </div>
                            @elseif($kelasmi->jenjang === "Ulya")
                            <p class="font-semibold text-3xl uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>
                            <p class="font-semibold uppercase  tracking-widest">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                            @elseif($kelasmi->jenjang === "Ula")
                            <p class="font-semibold text-3xl uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>
                            <p class="font-semibold uppercase  tracking-widest">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                            @endif
                        </div>
                    </div>
                    <hr class=" border-b-2 border-green-900">
                    <hr class=" mt-0.5 border-b-1 border-green-900">
                    <div class=" uppercase grid grid-cols-3">
                        <div class=" text-green-900  text-2xl  font-semibold">
                            Bulan : {{ $bulan->monthName }}
                        </div>
                        <div>
                            <div class=" text-green-900  grid-cols-2 font-semibold flex justify-center gap-2">
                                <div class=" py-1">
                                    Putra : {{$dataSiswa->where('jenis_kelamin','L')->count()}}
                                </div>
                                <div class=" py-1">
                                    Putri : {{$dataSiswa->where('jenis_kelamin','P')->count()}}
                                </div>
                            </div>
                        </div>
                        <div class=" text-right text-2xl  text-green-900 font-semibold">
                            Kelas : {{ $kelasmi->nama_kelas }}
                        </div>
                    </div>
                    <hr class=" border-b-1 border-green-600">
                    <table class="table-fixed w-full text-green-900 mt-1 ">
                        <thead class="border border-b-2 border-green-600">
                            <tr class="border  border-green-600 text-xs sm:text-sm">
                                <th class="border border-green-600 px-1 w-8" rowspan="2">No</th>
                                <th class="border border-green-600 px-1 w-1/5" rowspan="2">Nama Siswa</th>
                                <th class="border border-green-600 px-1 w-9" rowspan="2">Kls</th>
                                <th class="border border-green-600 px-1 " colspan="{{ $periodeBulan->count() }}">Tanggal</th>
                            </tr>
                            <tr class="border border-green-600 text-xs sm:text-sm">
                                @foreach ($periodeBulan as $hari)
                                <th class="border border-green-600 {{ $hari->isThursday() ? "bg-green-600 text-white" : "" }}">{{ $hari->day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            @foreach ($dataSiswa as $siswa)
                            <tr class=" border border-green-600 even:bg-green-100   text-xs sm:text-sm ">
                                <td class="border border-green-600 text-center px-1">{{ $loop->iteration }}</td>
                                <td class="border border-green-600 px-1 text-xs capitalize ">{{ strtolower($siswa->nama_siswa) }}</td>
                                <td class="border border-green-600 text-center ">{{ $siswa->nama_kelas }}</td>
                                @foreach ($periodeBulan as $hari)
                                <td class="border border-green-600 {{ $hari->isThursday() ? "bg-green-600" : "" }}"></td>
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