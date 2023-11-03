<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-2 bg-white border-b border-gray-200">
            <div class=" flex justify-end gap-2">
                <a href="/kelas_mi">
                    <button class=" flex bg-blue-600 text-white rounded-sm px-2 py-1"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Kembali</button>
                </a>
                <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama siswa">
                <select wire:model="perPage" class=" py-1">
                    <option>10</option>
                    <option>15</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                    <option>500</option>
                </select>
            </div>

        </div>
    </div>
    <div>
        <form action="/pesertakolektif" method="post" enctype="multipart/form-data">
            @csrf
            <div class=" py-1 w-3/5 grid grid-cols-2 gap-2 ">
                <div class=" flex gap-2">
                    <select name="kelasmi_id" id="" class=" py-1 w-full" required>
                        <option value="">-- Pilih Kelas Sesuai Periode --</option>
                        @foreach($kelas as $kelas )
                        <option value="{{$kelas->id}}" {{ $kelas->id == $kelasmi ? "selected" : "" }}>{{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}{{$kelas->ket_periode}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class=" w-1/4 bg-blue-600 text-white rounded-sm px-4"> Kolektif</button>

                </div>

            </div>
            <table class=" w-full">
                <thead>
                    <tr class=" border uppercase text-sm">
                        <th class=" border"><input type="checkbox" name="" id=""></th>
                        <th class=" border">No</th>
                        <th class=" border">Nomor Induk Murid</th>
                        <th class=" border">Nama Murid</th>
                        <th class=" border">JK</th>
                        <th class=" border">Asal Kota</th>
                        <th class=" border">Asrama</th>
                        <th class=" border">Angkatan</th>
                    </tr>
                </thead>
                <tbody>
                    @if($Datasiswa->count())
                    @foreach ($Datasiswa as $index=> $item)
                    <tr class=" border hover:bg-green-200 even:bg-gray-100">
                        <td class=" text-center">
                            <input type="checkbox" name="siswa[]" value="{{$item->id}}" multiple>
                            <!-- <input type="checkbox" wire:model="items.{{ $item->id }}" multiple> -->
                        </td>
                        <td class=" px-2 border text-center">
                            {{$loop->iteration}}
                        </td>
                        <td class=" px-2 border text-center">
                            <label for="">{{ $item->nis}}</label>
                        </td>
                        <td class=" px-2 border text-left capitalize">
                            <label for="">{{ strtolower($item->nama_siswa) }}</label>
                        </td>
                        <td class=" px-2 border text-center">
                            <label for="">{{ $item->jenis_kelamin}}</label>
                        </td>
                        <td class=" px-2 border text-left">
                            <label for="">{{ $item->kota_asal}}</label>
                        </td>
                        <td class=" px-2 border text-center">
                            <label for="">{{ $item->nama_asrama}}</label>
                        </td>
                        <td class=" border text-center ">
                            <?php
                            $date = date_create($item->tanggal_masuk);
                            echo date_format($date, "Y");
                            ?>
                        </td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class=" px-2 border text-center" colspan="8">
                            Tidak ada data yang ditemukan
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </form>
    </div>
</div>