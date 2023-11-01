<div>
    <div class=" ">
        <div class="  grid grid-cols-2 w-full gap-1">
            <div>
                <a href="/addkelas_mi">
                    <button class="px-2 flex uppercase bg-blue-500 dark:bg-green-700 text-white p-1 rounded-md">
                        <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></span>
                        kelas
                    </button>
                </a>
            </div>
            <div class=" grid justify-end">
                <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama kelas">
            </div>
        </div>
    </div>
    <div>
        <Table class=" mt-1 w-full  border-collapse border border-slate-500   ">
            <thead>
                <tr class="  border dark:bg-purple-600 uppercase text-xs sm:text-xs bg-gray-50 ">
                    <th class=" border text-xs py-2">No</th>
                    <th class=" border ">Periode</th>
                    <th class=" border w-10 px-1">Tingkat</th>
                    <th class=" border ">Jenjang</th>
                    <th class=" border "> Kelas</th>
                    <th class=" border w-10 text-xs text-center px-1">Kuota</th>
                    <th class=" border  w-10 text-xs text-center">Jml</th>
                    <th class=" border text-xs text-center">Status</th>
                    <th class=" border text-xs text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="">
                @if($listkelas->count() != null)
                @foreach ($listkelas as $item)
                <tr class=" hover:bg-green-200 border dark:hover:bg-purple-600 even:bg-gray-100 text-xs sm:text-sm">
                    <th class=" text-xs text-center border">{{$loop->iteration}}</th>
                    <td class=" text-xs text-center border"> {{$item->periode}} {{$item->ket_semester}}</td>
                    <td class=" text-xs text-center border"><a href="/pesertakelas/{{$item->id}}"> {{$item->kelas}}</a></td>
                    <td class=" text-xs text-center border"><a href="/pesertakelas/{{$item->id}}"> {{$item->jenjang}}</a></td>
                    <td class=" text-xs text-center py-2"><a href="/pesertakelas/{{$item->id}}" class=" text-xs  uppercase font-semibold py-1 px-2 rounded-md sm:xs">{{$item->nama_kelas}}</a></td>
                    <td class=" text-xs text-center border"> {{$item->kuota}}</td>
                    <td class=" text-xs text-center border">

                        {{$item->jumlah_nilai_ujian}}
                    </td>
                    <td class=" text-xs px-1 border text-center w-40">
                        @if($item->kuota == $item->jumlah_nilai_ujian )
                        <span class=" text-xs bg-yellow-300 px-4 py-1 rounded-md capitalize text-black">full</span>
                        @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                            <span class=" text-xs bg-red-600 px-4 py-1 rounded-md capitalize text-white">over</span>
                            @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                            <span class=" text-xs bg-green-800 px-4 py-1 rounded-md capitalize text-white">still</span>
                            @endif
                    </td>
                    <td class=" text-xs  text-center mt-1   flex gap-1 justify-center  align-middle   ">
                        <form action="/kelas_mi/{{$item->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class=" text-xs bg-red-500 text-white p-1 rounded-md" onclick=" return confirm('apakah anda yakin menhapus data ini: {{$item->nama_kelas}} {{$item->periode}} {{$item->ket_semester}}') "><svg xmlns="http://www.w3.org/2000/svg" class=" text-xsh-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></button>
                        </form>
                        <a href="kelas_mi/{{$item->id}}/edit">
                            <button class=" bg-yellow-400 p-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>

                        </a>

                    </td>

                </tr>
                @endforeach
                @else
                <tr>
                    <td class=" border text-center" colspan="9">
                        Data Tidak ditemukan
                    </td>
                </tr>
                @endif
            </tbody>
        </Table>
    </div>
</div>