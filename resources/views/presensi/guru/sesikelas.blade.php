<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas Guru')
        <h2 class="font-semibold sm:text-xl leading-tight text-sm">
            {{ __('Presensi Kelas Guru (' . \Carbon\Carbon::parse($tanggal)->isoFormat('dddd DD MMMM Y') ) . ')' }}
        </h2>
    </x-slot>
    <div class="">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg px-2 shadow-sm ">
                <div class="px-2 grid sm:flex sm:grid-cols-1  gap-1 w-full border-gray-200">
                    <div class="  ">
                        <form action="/sesi-presensi-guru" method="get" class="mr-auto">
                            <input type="date" name="tanggal" class="py-1 dark:bg-dark-bg" value="{{ $tanggal->toDateString() }}">
                            <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Pilih Tanggal
                            </button>
                        </form>
                    </div>
                    <div class="  ">
                        <form action="/sesi-presensi-guru" method="post">
                            @csrf
                            <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">
                            <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Buat Sesi
                            </button>
                        </form>
                    </div>
                    <div class=" py-2  hidden  sm:block">
                        <a href="/laporan-harian-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Laporan Harian
                        </a>

                    </div>
                    <div class=" py-2  hidden  sm:block">
                        <a href="/laporan-semester-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Laporan Semester
                        </a>
                    </div>
                    <div class=" py-2  hidden  sm:block">
                        <a href="/sesi-presensi-guru/rekap" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Rekap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-1 pt-2">
        <div class="">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="p-4 ">
                    {{-- <div class=" grid grid-cols-1 sm:grid-cols-1">
                        <div class=" flex grid-cols-1 justify-end">
                            <form action="/sesikelas" method="get" class=" flex gap-1">
                                <input type="date" name="cari" value="{{ $tanggal->toDateString() }}" class=" border border-green-800 text-green-800 rounded-md py-1 dark:bg-dark-bg " placeholder=" Cari ..">
                    <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                        Cari By Tanggal </button>
                    </form>
                </div>
            </div> --}}
            <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 ">
                <table class=" w-full">
                    <thead>
                        <tr class="border bg-gray-200 dark:bg-purple-600 text-xs sm:text-sm">
                            <th class=" border px-1  py-1">No</th>
                            <th class=" border px-1 ">Tanggal</th>
                            <th class=" border px-1 ">Kelas</th>
                            <th class=" border px-1 ">Periode</th>
                            <th class=" border px-1 ">Status</th>
                            <th class=" border px-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($sesikelas as $sesi)
                        <tr class=" border hover:bg-gray-100  dark:hover:bg-purple-600 text-xs sm:text-sm ">
                            <th class=" border px-1">{{ $loop->iteration }}</th>
                            <th class=" border text-center px-1">
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat(' DD MMMM Y') }}
                            </th>
                            <td class=" border text-center px-1 w-11">
                                <a href="/sesi-presensi-guru/{{ $sesi->id }}" class=" bg-blue-600 rounded-md px-1 py-1 text-white dark:text-purple-600  dark:bg-dark-bg text-xs">
                                    {{ $sesi->nama_kelas }}
                                </a>
                            </td>
                            <td class=" border text-center px-1">
                                <a href="/sesi-presensi-guru/{{ $sesi->id }}">
                                    {{ $sesi->periode }} {{ $sesi->ket_semester }}
                                </a>
                            </td>
                            <td class=" border px-1">
                                <div class="grid justify-items-center">
                                    @if($sesi->guru_id !== null )
                                    {{$sesi->nama_guru}}
                                    @else
                                    <span class=" text-red-600">
                                        <x-icons.x-mark></x-icons.x-mark>
                                    </span>
                                    @endif
                                </div>

                            </td>
                            <td class=" grid justify-items-center py-1 ">
                                <form action="/sesi-presensi-guru/{{ $sesi->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class=" bg-red-500 text-white p-1 rounded-md" onclick=" return confirm ('apakah hapus yakin  sesi ini : {{ $sesi->nama_kelas }} Tanggal : {{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat(' DD MMMM Y') }} ')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="my-1">
        <div class="">
            <div class=" bg-sky-200 dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-2 sm:text-sm text-xs  ">
                    <p class=" font-semibold">Keterangan : </p>
                    <p class=" px-2">1. Nilai diambail dari <b class=" underline">Ulangan Harian dan Ujian Akhir
                            Semester</b></p>
                    <p class=" px-2 capitalize">2. Untuk pengisian nilai jika tidak ada harap kosongkan form penilaian
                    </p>
                    <p class=" px-2 capitalize">3. Untuk pengisinan nilai <b><u>harus</u></b> memasukan peserta kelas
                        terlebih dahulu di menu kelas</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>