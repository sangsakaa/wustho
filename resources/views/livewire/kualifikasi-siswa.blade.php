<div>
    <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama kelas">
    <select wire:model="perPage" class=" py-1">
        <option>6</option>
        <option>12</option>
        <option>18</option>
        <option>24</option>
        <option>50</option>
        <option>100</option>
        <option>300</option>
        <option>500</option>

    </select>
    <table class="w-full">
        <thead>
            <tr>
                <th class="border">No</th>
                <th class="border">NIM</th>
                <th class="border">Nama Siswa</th>
                <th class="border">Kelas</th>
                @foreach($dataSiswa->pluck('periode')->unique() as $periode)
                <th class="border">{{ $periode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($dataSiswa->unique('nama_siswa') as $siswa)
            <tr>
                <td class="border text-center">{{ $loop->iteration }}</td>
                <td class="border text-center">{{ $siswa->nis }}</td>
                <td class="border capitalize">{{ strtolower($siswa->nama_siswa )}}</td>
                <td class="border text-center">{{ $siswa->nama_kelas }}</td>
                @foreach($dataSiswa->pluck('periode')->unique() as $periode)
                @php
                $kehadiran = $dataSiswa->where('nama_siswa', $siswa->nama_siswa)->where('periode', $periode)->first();
                @endphp
                <td class="border text-center">{{ $kehadiran ? $kehadiran->kehadiran  : '-' }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>







</div>