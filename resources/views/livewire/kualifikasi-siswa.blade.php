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
    <select wire:model="Kelas" class=" py-1">
        <option>1A</option>
        <option>2A</option>
        <option>3A</option>

    </select>
    <table class="w-full">
        <thead>
            <tr>
                <th class="border">No</th>
                <th class="border">NIM</th>
                <th class="border">Nama Siswa</th>
                <th class="border">Kelas</th>

            </tr>
        </thead>
        <tbody>




        </tbody>
    </table>
    <div>



        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Periode</th>
                    <th>NIS</th>
                    <th>Nama Kelas</th>
                    <th>Keterangan Semester</th>
                    <th>Total Hadir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataSiswa as $index => $siswa)
                <tr>
                    <td class=" border ">{{ $index + 1 }}</td>
                    <td class=" border ">{{ $siswa->nama_siswa }}</td>
                    <td class=" border ">{{ $siswa->periode }}</td>
                    <td class=" border ">{{ $siswa->nis }}</td>
                    <td class=" border ">{{ $siswa->nama_kelas }}</td>
                    <td class=" border ">{{ $siswa->ket_semester }}</td>
                    <td class=" border ">{{ $siswa->total_hadir }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>






</div>