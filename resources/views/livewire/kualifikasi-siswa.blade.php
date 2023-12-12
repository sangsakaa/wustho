<div>

    <div>
        <select wire:model="angkatan" class=" py-1">
            <option>2021</option>
            <option>2022</option>
            <option>2023</option>
        </select>
        <!-- resources/views/namafile.blade.php -->
        <table class="border w-full">
            <thead>
                <tr>
                    <th rowspan="2" class=" border">NIM</th>
                    <th rowspan="2" class=" border">Nama Siswa</th>
                    <th rowspan="2" class=" border"> Semester</th>
                    <th colspan="4" class=" border">Keterangan</th>
                    <th rowspan="2" class=" border">Sesi</th>
                    <th rowspan="2" class=" border">% Hadir</th>
                    <th rowspan="2" class=" border">Status</th>
                </tr>
                <tr>
                    <th class=" border"> A</th>
                    <th class=" border"> I</th>
                    <th class=" border"> S</th>
                    <th class=" border"> H</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataSiswa as $data)
                <tr>
                    <td class=" border text-center"> {{ $data->nis }}</td>
                    <td class=" border"> {{ $data->nama_siswa }}</td>
                    <td class=" border text-center">{{$data->periode}} {{ $data->ket_semester }}</td>
                    <td class=" border text-center px-1"> {{ $data->jumlah_alfa }}</td>
                    <td class=" border text-center px-1"> {{ $data->jumlah_izin }}</td>
                    <td class=" border text-center px-1"> {{ $data->jumlah_sakit }}</td>
                    <td class=" border text-center px-1"> {{ $data->jumlah_hadir }}</td>
                    <td class=" border text-center"> {{ $data->jumlah_sesikelas_id }}</td>
                    <td class=" border text-center"> {{ number_format($data->presentase_hadir),2 }}%</td>
                    <td class=" border text-center">
                        @if(number_format($data->presentase_hadir >=75 ))
                        V
                        @else
                        X
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>











    </div>






</div>