<div>
    <div class="p-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm ">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" flex gap-2 ">
                        <div>
                            <a href="/pesertaasrama/{{$asramasiswa}}">
                                <button class=" flex bg-blue-600 text-white rounded-sm px-2 py-1"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <div>
                            <div>
                                <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama siswa">
                                <select wire:model="perPage" class=" py-1">
                                    <option>10</option>
                                    <option>15</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>500</option>
                                </select>
                                <select wire:model="jenis_kelamin" class=" py-1">
                                    <option>L</option>
                                    <option>P</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" py-1">
        <form action="/kolektifasrama" method="post" enctype="multipart/form-data">
            @csrf
            <div class="  flex   gap-2  sm:w-1/2 w-full">
                <select name="asramasiswa_id" class="py-1 w-full capitalize" required>
                    @foreach($kelas as $asrama)
                    <option value="{{$asrama->id}}" @if($asrama->id == $asramasiswa) selected @endif>
                        {{$asrama->type_asrama}} | {{$asrama->nama_asrama}}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="  bg-blue-600 text-white rounded-sm px-2 py-1"> Kolektif</button>
            </div>
            <div class=" overflow-auto mt-2">
                <table class=" w-full">
                    <thead>
                        <tr class=" border  bg-gray-100 uppercase text-sm">
                            <th class=" py-2 border px-2"><input type="checkbox" name="" id=""></th>
                            <th class=" border px-2">No</th>
                            <th class=" border px-2" class=" text-center"> NIM</th>
                            <th class=" border px-2">Nama Siswa</th>
                            <th class=" border px-2"> JK</th>
                            <th class=" border px-2 ">jenjang</th>
                            <th class=" border px-2">Angkatan</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($Datasiswa->count())
                        @foreach ($Datasiswa as $item)
                        <tr class=" border hover:bg-green-200">
                            <td class=" border text-center">
                                <input type="checkbox" name="siswa[]" value="{{$item->id}}" multiple>
                            </td>
                            <td class=" border px-2 text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class=" border px-2 text-center">
                                <label for="">{{ $item->nis }}</label>
                            </td>
                            <td class=" border px-2 text-left capitalize">
                                <label for="">{{ strtolower($item->nama_siswa )}}</label>
                            </td>
                            <td class=" border px-2 text-center">
                                <label for="">{{ $item->jenis_kelamin}}</label>
                            </td>
                            <td class=" border px-2 text-center">
                                <label for="">{{ $item->madrasah_diniyah}}</label>
                            </td>
                            <td class=" border px-2  text-center ">
                                <?php
                                $date = date_create($item->tanggal_masuk);
                                echo date_format($date, "Y");
                                ?>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class=" border text-center" colspan="7">
                                Tidak ada data yang ditemukan
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class=" py-1 " colspan="7">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>