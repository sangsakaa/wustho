<div>
    <div class=" ">
        <div class="  grid grid-cols-2 w-full gap-1">
            <div class=" flex gap-2 ">
                <div>
                    <a href="/addasramasiswa">
                        <button class="px-2 flex  uppercase bg-blue-500 dark:bg-green-700 text-white p-1 rounded-md">
                            <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></span>
                            asrama
                        </button>
                    </a>
                </div>
                <div>
                    <a href="/asrama">
                        <button class="px-2 flex  uppercase bg-blue-500 dark:bg-green-700 text-white p-1 rounded-md">
                            <span class=" flex "><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                asrama</span>

                        </button>
                    </a>
                </div>
            </div>
            <div class=" grid justify-end">
                <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama asrama">
            </div>
        </div>
    </div>
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
    <Table class=" mt-2 sm:w-full  w-full">
        <thead class=" bg-gray-100 dark:bg-purple-600">
            <tr class=" border  uppercase text-xs ">
                <th class=" text-center px-1 border py-1">no</th>
                @role('super admin')
                <th class=" text-center px-1 border   ">periode</th>
                @endrole
                <th class=" text-center px-1 border ">Daftar Asrama</th>
                <th class=" text-center px-1 border "> asrama</th>
                <th class=" text-center px-1 border "> kuota</th>
                <th class=" text-center px-1 border "> Total
                </th>
                <th class=" text-center px-1 border "> Status </th>
                <th class=" text-center px-1 border ">
                    keterangan
                </th>
                <th class=" text-center px-1 border ">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($data->count())
            @foreach ($data as $item)
            <tr class=" border hover:bg-purple- uppercase text-xs dark:hover:bg-purple-600 ">
                <td class=" px-2 border text-center">
                    {{$loop->iteration}}
                </td>
                @role('super admin')
                <td class="border text-center transform rotate-90 lg:rotate-0 sm:rotate-90 ">
                    <a href="pesertaasrama/{{$item->id}}">
                        {{$item->periode}} {{$item->ket_semester}}
                    </a>
                </td>
                @endrole
                <td class=" px-2 border text-center font-semibold ">
                    @if($item->type_asrama == "Putra")

                    <a href="pesertaasrama/{{$item->id}}" class=" py-1 px-2  text-blue-600 rounded-md uppercase text-center ">{{$item->nama_asrama}}</a>
                    @else
                    <a href="pesertaasrama/{{$item->id}}" class=" py-1 px-2  text-pink-600 rounded-md uppercase text-center ">{{$item->nama_asrama}}</a>
                    @endif
                </td>
                <td class=" px-2 border text-center font-semibold">
                    {{$item->type_asrama}}
                </td>
                <td class=" px-2 border text-center font-semibold">
                    {{$item->kuota}} Org
                </td>
                <td class=" px-2 border text-center font-semibold ">
                    {{$item->jumlah_nilai_ujian}} Org
                </td>
                <td class=" px-2 border text-center font-semibold ">
                    @if($item->kuota == $item->jumlah_nilai_ujian )
                    <span class=" text-red-700 px-4 py-1 rounded-md capitalize ">Penuh</span>
                    @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                        <span class=" text-red-600 px-4 py-1 rounded-md capitalize  ">
                            Over
                        </span>
                        @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                        <span class=" text-green-800 px-4 py-1 rounded-md capitalize  ">
                            masih
                        </span>
                        @endif
                </td>
                <td class=" px-2 border text-center w-1/4 sm:w-1/4 ">
                    @if($item->kuota == $item->jumlah_nilai_ujian )
                    <span class=" text-red-700 px-4 py-1 rounded-md capitalize ">sesui Kuota
                        {{($item->kuota)}} org
                    </span>
                    @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                        <span class=" text-red-600 px-4 py-1 rounded-md capitalize ">
                            Over -
                            {{($item->jumlah_nilai_ujian)-($item->kuota)}} org
                        </span>

                        @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                        <span class=" text-green-800 px-4 py-1 rounded-md capitalize ">
                            Masih - {{($item->kuota)-($item->jumlah_nilai_ujian)}} org
                        </span>
                        @endif
                </td>
                <td class="  py-1 px-2 sm:flex  justify-center gap-2">
                    @role('super admin')
                    <form action="/asramasiswa/{{$item->id}}" method="post">
                        @csrf
                        @method('delete')
                        <button class=" bg-red-500 text-white p-1 rounded-md" onclick=" return confirm('apakah anda yakin menghapus data ini : {{$item->nama_asrama}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></button>
                    </form>
                    @endrole
                    <a href="asramasiswa/{{$item->id}}/edit">
                        <button class=" bg-yellow-400 p-1 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    </a>
                    <a href="pesertaasrama/{{$item->id}}">
                        <button class=" bg-sky-400 p-1 rounded-md hover:bg-purple-600 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </a>

                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9" class=" text-center border">
                    Data Tidak ditemukan
                </td>
            </tr>
            @endif
        </tbody>
    </Table>
</div>