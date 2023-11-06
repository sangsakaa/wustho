<div>
    <table class="w-full">
        <thead>
            <tr>
                <th class="border">No</th>
                <th class="border">NIM</th>
                <th class="border">Nama Siswa</th>
                @foreach($dataSiswa->pluck('periode')->unique() as $periode)
                <th class="border">{{ $periode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($dataSiswa->unique('nama_siswa') as $siswa)
            <tr>
                <td class="border">{{ $loop->iteration }}</td>
                <td class="border text-center">{{ $siswa->nis }}</td>
                <td class="border">{{ $siswa->nama_siswa }}</td>
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