<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Presensi Kelas') }}
        </h2>
    </x-slot>

    <div class=" px-4">
        <div class="py-4">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" px-4 py-1">
                            <span class=" text-2xl  text-blue-400">Presensi Kelas</span>
                        </div>
                        <hr>

                        <div class=" grid grid-cols-4 px-4 py-2">
                            <div>Kelas / Semester</div>
                            <div> : {{ $dataKelas->nama_kelas }} / {{ $dataKelas->semester }}</div>
                            <div>Periode</div>
                            <div> : {{ $dataKelas->periode }} {{ $dataKelas->ket_semester }}</div>
                            <div>Presensi tanggal</div>
                            <div> : {{ $sesikelas->tgl }}</div>
                            <div>Disimpan pada</div>
                            <div> : {{ $diSimpanPada }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="/absensikelas" method="post">
                            <button class=" bg-red-600 py-1 rounded-md text-white px-4">simpan presensi</button>
                            <a href="/sesikelas" class=" bg-red-600 py-1 rounded-md text-white px-4">Kembali</a>
                            @if (session('status'))
                            <div class="alert alert-success w-full text-sm">
                                {{ session('status') }}
                            </div>
                            @endif
                            @csrf
                            <table class=" mt-2 w-full">
                                <thead>
                                    <tr class="border">
                                        <th class=" border px-1">#</th>
                                        <th class=" border px-1 w-1/7">NIS</th>
                                        <th class=" border px-1 ">NAMA SISWA</th>
                                        <th class=" border px-1">KELAS</th>
                                        <th class=" border px-1">NAMA KELAS</th>
                                        <th class=" border px-1">KETERANGAN</th>
                                        <th class=" border px-1">ALASAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSiswa as $item)
                                    <tr class=" border hover:bg-gray-100">
                                        <td class=" px-2 border text-center w-10">
                                            {{ $loop->iteration }}
                                            <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                            <input type="hidden" name="sesikelas" value="{{ $sesikelas->id }}">
                                            <input type="hidden" name="absensikelas[{{ $item->id }}]" value="{{ $item->absensikelas_id }}">
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->nis }}
                                        </td>
                                        <td class=" px-2 border text-sm ">
                                            {{ $item->nama_siswa }}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->kelas }}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->nama_kelas }}
                                        </td>
                                        <td class="  border text-center w-20">
                                            <input type="radio" id="hadir[{{ $item->id }}]" value="hadir" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "hadir" || $item->keterangan === null ? "checked" : "" }}>
                                            <label for="hadir[{{ $item->id }}]">Hadir</label>
                                            <input type="radio" id="izin[{{ $item->id }}]" value="izin" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "izin" ? "checked" : "" }}>
                                            <label for="izin[{{ $item->id }}]">Izin</label>
                                            <input type="radio" id="sakit[{{ $item->id }}]" value="sakit" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "sakit" ? "checked" : "" }}>
                                            <label for="sakit[{{ $item->id }}]">Sakit</label>
                                            <input type="radio" id="alfa[{{ $item->id }}]" value="alfa" name="keterangan[{{ $item->id }}]" {{ $item->keterangan === "alfa" ? "checked" : "" }}>
                                            <label for="alfa[{{ $item->id }}]">Alfa</label>
                                        </td>
                                        <td class="  border text-center w-20">
                                            <input value="{{ $item->alasan }}" class="py-1 w-full text-center" name="alasan[{{ $item->id }}]">
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
