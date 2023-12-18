<div>
    @if (session('update'))
    <script>
        Toastify({
            text: "data berhasil di di update",
            className: "update",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
    </script>
    @endif

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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
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