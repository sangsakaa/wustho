<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Perangkat' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Perangkat') }}
        </h2>
    </x-slot>
    <div class=" bg-white p-2 sm:p-2  ">
        <div>
            <a href="/form-perangkat" class=" bg-blue-600 text-white rounded-md px-2 py-1 capitalize">Tambah data</a>
            <a href="jabatan" class=" bg-blue-600 text-white rounded-md px-2 py-1 capitalize">Tambah jabatan</a>
        </div>
        <div class=" overflow-auto">
            <Table class=" sm:w-full w-full  mt-2">
                <thead class=" bg-gray-50 dark:bg-purple-600">
                    <tr class=" border text-xs sm:text-sm ">
                        <th class="px-2 border py-1">No</th>
                        <th class="px-2 border text-center ">NIG</th>
                        <th class="px-2 border text-center w-1/2 sm:w-1/4">Nama Guru</th>
                        <th class="px-2 border text-center">Jabatan</th>
                        <th class="px-2 border text-center">JK</th>
                        <th class="px-2 border text-center w-10">Agama</th>
                        <th class="px-2 border text-center">Tempat Lahir</th>
                        <th class="px-2 border text-center w-50">Tanggal Lahir</th>
                        <th class="px-2 border text-center">Tanggal Masuk</th>
                        <th class="px-2 border text-center">Status</th>
                        <th class="px-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dataPerangkat->count() != null)
                    @foreach ($dataPerangkat as $item)
                    <tr class=" border hover:bg-green-100 text-xs sm:text-sm">
                        <th class=" text-center border">{{$loop->iteration}}</th>

                        <td class=" px-2 border text-center capitalize">
                            <a href="detail-perangkat/{{$item->id}}">
                                @if($item->NigTerakhir != null)
                                {{$item->NigTerakhir->nig}}
                                @else
                                <span class=" text-xs text-red-600 "> nig</span>
                                @endif
                            </a>
                        </td>
                        <td class=" px-2">
                            <a href="detail-perangkat/{{$item->id}}">
                                {{$item->nama_perangkat}}
                            </a>
                        </td>
                        <td class=" px-2">
                            <a href="detail-perangkat/{{$item->id}}">
                                @if($item->Jabatan == null)
                                -
                                @else
                                @foreach($item->Jabatan->titleJab as $lits)
                                {{ $lits->nama_jabatan ?? '-' }}
                                @endforeach
                                @endif


                            </a>
                        </td>
                        <td class=" border px-2 text-center w-10"> {{$item->jenis_kelamin}}</td>
                        <td class=" border px-2 text-center"> {{$item->agama}}</td>
                        <td class=" border px-2 text-center capitalize"> {{$item->tempat_lahir}}</td>
                        <td class=" border px-2 text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') }}
                        </td>
                        <td class=" border px-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D/M/Y') }} </td>
                        <td class=" border px-2 text-center">{{ $item->status }} </td>
                        <td class="  text-center flex justify-center gap-1 p-1">
                            <form action="/edit-form-perangkat/{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button class=" bg-red-500 text-white p-1  rounded-md flex" onclick=" return confirm('apakah anda yakin menghapus data ini: {{$item->nama_guru}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></button>
                            </form>
                            <a href="/edit-form-perangkat/{{$item->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg></a>
                            <a href="edit-form-perangkat/{{$item->id}}" class=" text-white bg-sky-400 py-0 hover:bg-purple-600  px-2 rounded-sm">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            Data Tidak ditemukan
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="10">

                        </td>
                    </tr>
                </tbody>
            </Table>
        </div>
    </div>
</x-app-layout>