<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas : ' . $dataKelas->nama_kelas)
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Presensi Kelas') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="py-4">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm ">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" px-4 py-1">
                            <span class=" text-2xl  text-blue-400">Presensi Kelas</span>
                        </div>
                        <hr>
                        <div class=" grid sm:grid-cols-4 grid-cols-2  px-4 py-2">
                            <div>Kelas / Semester</div>
                            <div> : {{ $dataKelas->nama_kelas }} / {{ $dataKelas->semester }}</div>
                            <div>Periode</div>
                            <div> : {{ $dataKelas->periode }} {{ $dataKelas->ket_semester }}</div>
                            <div>Presensi hari, tanggal</div>
                            <div class=" text-sm"> : {{ Carbon\Carbon::parse($sesikelas->tgl)->isoFormat('dddd, D MMMM YYYY') }}</div>
                            <div>Disimpan pada</div>
                            <div class=" text-sm"> :
                                {{ $diSimpanPada ? Carbon\Carbon::parse($diSimpanPada)->isoFormat('dddd, D MMMM YYYY') : '' }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm ">
                    <div class="p-2 bg-white border-b border-gray-200">
                        <form action="/absensikelas" method="post">
                            <button class=" bg-red-600 py-1 rounded-md text-white px-4">simpan presensi</button>
                            <a href="{{ $prev_url }}" class="inline-block bg-red-600 py-1 rounded-md text-white px-4">Kembali</a>
                            @if (session('status'))
                            <div class="alert alert-success w-full text-sm">
                                {{ session('status') }}
                            </div>
                            @endif
                            @csrf
                            <input type="hidden" name="prev_url" value="{{ $prev_url }}">
                            <div class=" w-full sm:overflow-auto overflow-auto ">
                                <table class=" mt-2 w-full sm:w-full text-xs sm:text-sm">
                                    <thead>
                                        <tr class="border">
                                            <th class=" border ">No</th>
                                            <th class=" border px-1 ">NAMA SISWA</th>
                                            <th class=" border px-1">KET</th>
                                            <th class=" border px-1">ALASAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataSiswa as $item)
                                        <tr class=" border hover:bg-gray-100">
                                            <td class=" px-1 border text-center">
                                                {{ $loop->iteration }}
                                                <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                                <input type="hidden" name="sesikelas" value="{{ $sesikelas->id }}">
                                                <input type="hidden" name="absensikelas[{{ $item->id }}]" value="{{ $item->absensikelas_id }}">
                                            </td>

                                            <td class=" px-2 border sm:text-sm text-xs w-1/3 capitalize ">
                                                {{ strtolower($item->nama_siswa) }}

                                            </td>
                                            <td class=" justify-center text-center w-1/3 ">
                                                <input type="radio" id="hadir[{{ $item->id }}]" value="hadir" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "hadir" || $item->keterangan === null ? "checked" : "" }}>
                                                <label for="hadir[{{ $item->id }}]">H</label>
                                                <input type="radio" id="izin[{{ $item->id }}]" value="izin" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "izin" ? "checked" : "" }}>
                                                <label for="izin[{{ $item->id }}]">I</label>
                                                <input type="radio" id="sakit[{{ $item->id }}]" value="sakit" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "sakit" ? "checked" : "" }}>
                                                <label for="sakit[{{ $item->id }}]">S</label>
                                                <input type="radio" id="alfa[{{ $item->id }}]" value="alfa" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "alfa" ? "checked" : "" }}>
                                                <label for="alfa[{{ $item->id }}]">A</label>
                                            </td>
                                            <td class="  border text-center  px-1">
                                                <input value="{{ $item->alasan }}" class=" border py-1 w-full text-center border-blue-600" name="alasan[{{ $item->id }}]" placeholder=" isi alasan">
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>