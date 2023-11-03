<div>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    <div class=" p-2 grid gap-2">
        <div class=" bg-white p-4 grid grid-cols-2 sm:grid-cols-4">
            <div>Kelas</div>
            <div>: {{$datakelasmi->nama_kelas}} </div>
            <div>Kuota</div>
            <div>: {{$datakelasmi->kuota}} org</div>
            <div>Jumlah Peserta</div>
            <div>: {{$hitung}} org</div>
            <div>Jenis Kelamin</div>
            <div>: L : {{$lk}} P : {{$pr}}</div>
        </div>
        <div class=" p-2 bg-white flex gap-2">
            <input type="search" wire:model="search" class=" py-1 " placeholder=" cari nama siswa">
            <a href="/pesertakolektif/{{ $kelasmi }}" class=" mt-1 ">
                <span class=" bg-blue-600 text-white rounded-sm px-2 py-1  "> Kolektif</span>
            </a>
            <a href="/kelas_mi" class=" mt-1">
                <span class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kembali</span>
            </a>
            <button class="sm:block hidden   w-10 justify-center text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                <x-icons.print></x-icons.print>
            </button>
        </div>
        <div id="div1" class=" bg-white p-2">
            <Table class=" table w-full mt-1">
                <thead>
                    <tr class="border">
                        <th class=" text-sm px-2 border text-center  ">No</th>
                        <th class=" text-sm px-2 border text-center">NIM </th>
                        <th class=" text-sm px-2 border text-center">Nama </th>
                        <th class=" text-sm px-2 border text-center py-1"> Nama Kelas </th>
                        <th class=" text-sm px-2 border text-center   ">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dataKelas->count())
                    @foreach($dataKelas as $list)
                    <tr class=" hover:bg-gray-100 dark:hover:bg-dark-bg even:bg-gray-100 ">
                        <td class=" border px-2 w-10 text-center">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border px-2 text-center w-50">
                            {{$list->nis}}
                        </td>
                        <td class=" border px-2 capitalize">
                            {{strtolower($list->nama_siswa)}}
                        </td>
                        <td class=" border px-2 text-center ">
                            {{$list->nama_kelas}}
                        </td>
                        <td class=" hidden sm:block border px-3 py-1        gap-2    ">
                            <div class="   flex gap-2 justify-center">
                                <a href="/pesertakelas/{{$list->id}}/edit" class="   grid  bg-yellow-400 py-1 px-1 text-black hover:text-white hover:bg-purple-600 rounded-md ">
                                    <x-icons.edit></x-icons.edit>
                                </a>
                                <form action="/pesertakelas/{{$list->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class=" grid bg-red-600 py-1 px-1 text-white hover:bg-purple-600 rounded-md ">
                                        <x-icons.hapus></x-icons.hapus>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class=" border text-center" colspan="7">
                            Tidak ada Data ditemukan !!!
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="7" class="py-1">

                        </td>
                    </tr>
                </tbody>
            </Table>
        </div>
    </div>
</div>