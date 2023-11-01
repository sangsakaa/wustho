<div>
    <div class="  grid-cols-1  flex  sm:flex sm:grid-cols-6 gap-2">
        <a href="/cetak-jadwal-1" class=" py-1 px-2 bg-red-600 text-white text-center ">JADWAL</a>

        <a href="/laporan-poling-guru" class=" py-1 px-2 bg-red-600 text-white text-center ">LAPORAN</a>
        <a href="/laporan-poling-guru-kelas" class=" py-1 px-2 bg-red-600 text-white text-center ">Ploting</a>
        <a href="/cetak-jadwal-kolektif" class=" py-1 px-2 bg-red-600 text-white text-center ">Buat Jadwal</a>
        <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama kelas">
        <select wire:model="perPage" class=" py-1">
            <option>6</option>
            <option>12</option>
            <option>18</option>
            <option>24</option>
            <option>50</option>
            <option>100</option>

        </select>
    </div>
    <div class=" overflow-auto rounded">
        <table class=" w-full w-100 mt-2">
            <thead class=" fixed-top">
                <tr class=" uppercase bg-green-800 text-white">
                    <th class=" border text-center text-xs sm:text-sm py-2">No</th>
                    <th class=" border text-center text-xs sm:text-sm">Hari</th>
                    <th class=" border text-center text-xs sm:text-sm">Periode</th>
                    <th class=" border text-center text-xs sm:text-sm">Kelas</th>
                    <th class=" border text-center text-xs sm:text-sm">Mapel</th>
                    <th class=" border text-center text-xs sm:text-sm">Daftar Pendidik</th>
                    <th class=" border text-center text-xs sm:text-sm">ACt</th>
                </tr>
            </thead>
            <tbody class=" overflow-auto">
                @foreach($daftarJadwal as $jadwal)
                <tr class=" even:bg-gray-100">
                    <th class=" px-1  border text-xs sm:text-sm text-center py-2">{{$loop->iteration}}</th>
                    <td class=" px-1 border text-xs sm:text-sm text-center capitalize">{{$jadwal->hari}}</td>
                    <td class=" px-1 border text-xs sm:text-sm text-center"> {{$jadwal->periode}} {{$jadwal->ket_semester}}</td>
                    <td class=" px-1 border text-xs sm:text-sm text-center"><a href="/jadwal-guru/{{$jadwal->id}}"> {{$jadwal->nama_kelas}}</a> </td>
                    <td class=" px-1 border text-xs sm:text-sm text-center capitalize">{{$jadwal->mapel}}</td>
                    <td class=" px-1 border text-xs sm:text-sm text-left w-1/2">
                        @if($jadwal->nama_guru !== null)
                        @if($jadwal->jenis_kelamin == 'L')
                        Bapak
                        @else
                        Ibu
                        @endif
                        {{$jadwal->nama_guru}}
                        @else
                        <span class=" text-red-600">Belum terjadwal</span>
                        @endif
                    </td>
                    <td class=" text-center border">
                        <form action="/Daftar-Jadwal/{{$jadwal->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button title="hapus jadwal">
                                <span class=" text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7" class=" py-1">
                        {{$daftarJadwal}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>