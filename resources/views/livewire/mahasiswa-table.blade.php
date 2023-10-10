<div>
    <div class=" flex gap-2">
        <div class=" ">
            <a href="/addsiswa">
                <button class=" bg-blue-500 dark:bg-green-700 text-white p-1 rounded-md">
                    <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                </button>
            </a>
        </div>
        <div>
            <input type="search" wire:model="search" class=" py-1" placeholder=" cari">
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
    <div class=" overflow-auto">
        <table class=" w-full mt-2  ">
            <thead class=" dark:bg-dark-bg bg-gray-100 uppercase">
                <tr class=" border-collapse  sm:text-sm text-xs">
                    <th class=" py-1 border text-center">No</th>
                    <th class=" px-1 border text-center uppercase">nis</th>
                    <th class=" px-1 border text-center">Nama</th>
                    <th class=" px-1 border text-center">JK</th>
                    <th class=" px-1 border text-center">Asrama</th>
                    <th class=" px-1 border text-center">Madin</th>
                    <th class=" px-1 border text-center">Jenjang</th>
                    <th class=" px-1 border text-center">Angkatan</th>
                    <th class=" px-1 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ( $data as $peserta)
                <tr class=" text-xs  border hover:bg-blue-100  sm:text-sm  even:bg-gray-100 ">
                    <td class=" text-sm  border  text-center py-1 ">
                        {{$loop->iteration}}
                    </td>
                    <td class=" text-sm  px-2 border  text-center ">
                        @if($peserta->NisTerakhir != null)
                        {{$peserta->NisTerakhir->nis}}
                        @else
                        <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                        @endif
                    </td>
                    <td class=" text-xs sm:text-sm  border px-2 capitalize">
                        <a href="/siswa/{{$peserta->id}}">
                            {{strtolower($peserta->nama_siswa)}}
                        </a>
                    </td>
                    <td class=" text-sm  border text-center ">
                        {{$peserta->jenis_kelamin}}
                    </td>
                    <td class=" text-sm  border text-center ">
                        @if($peserta->asramaTerkhir != null )
                        {{$peserta->asramaTerkhir->asramaSiswa->asrama->nama_asrama}}
                        @else
                        <span class=" text-red-600 font-semibold capitalize"> belum ada asrama </span>
                        @endif
                    </td>
                    <td class=" text-sm  border text-center ">
                        @if($peserta->kelasTerakhir)
                        {{$peserta->kelasTerakhir->KelasMi->nama_kelas}}
                        @else
                        <span class=" text-red-600 font-semibold capitalize"> belum ada kelas </span>
                        @endif
                    </td>
                    <td class=" text-sm  px-2 border  text-center ">
                        @if($peserta->NisTerakhir != null)
                        {{$peserta->NisTerakhir->madrasah_diniyah}}
                        @else
                        <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                        @endif
                    </td>
                    <td class=" text-sm  border text-center ">
                        @if($peserta->NisTerakhir != null)
                        {{ \Carbon\Carbon::parse($peserta->NisTerakhir->tanggal_masuk)->isoFormat('Y') }}
                        @else
                        <span class=" text-red-600 font-semibold capitalize"> belum ada nis </span>
                        @endif
                    </td>
                    <td class=" text-sm flex justify-center py-1  gap-1">

                        @can('delete post')
                        <form action="/siswa/{{$peserta->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class=" bg-red-500 text-white p-1 rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" onclick="return  confirm ('apakah anda yakin menghapus data ini : {{$peserta->nis}} {{$peserta->nama_siswa}}')" )>
                                    <path stroke-linecap=" round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></button>
                        </form>
                        @endcan
                        @can('edit post')
                        <a href="/siswa/{{$peserta->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg></a>
                        @endcan
                        <a href="/siswa/{{$peserta->id}}" class=" text-white bg-sky-400 py-0 hover:bg-purple-600  px-2 rounded-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td colspan=" 9" class=" py-1">

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>