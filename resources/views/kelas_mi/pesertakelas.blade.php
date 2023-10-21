<x-app-layout>
    <x-slot name="header">
        @section('title','| Daftar Peserta Kelas : '.$datakelasmi->nama_kelas )
        <h2 class="font-semibold text-xl  leading-tight">
            Dashboard Kelas : {{$datakelasmi->nama_kelas}}

        </h2>
    </x-slot>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>

    <div class="px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-purple-600  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2">
                    <div class=" grid grid-cols-2 sm:grid-cols-4">
                        <div>Kelas</div>
                        <div>: {{$datakelasmi->nama_kelas}} </div>
                        <div>Kuota</div>
                        <div>: {{$datakelasmi->kuota}} org</div>
                        <div>Jumlah Peserta</div>
                        <div>: {{$hitung}} org</div>
                        <div>Jenis Kelamin</div>
                        <div>: L : {{$lk}} P : {{$pr}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-2  ">
                    <div class=" grid grid-cols-1 gap-1 py-1 justify-items-end">
                    </div>
                    <div class=" flex  gap-2 grid-cols-2">
                        <div class="grid justify-items-end">
                            <form action="/pesertakelas/{{$datakelasmi->id}}" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg  border text-green-800 dark:text-purple-600 rounded-sdm py-1 " placeholder=" Cari ...">

                                <button type="submit" class=" px-2   bg-blue-500   text-white">
                                    Cari </button>
                            </form>
                        </div>
                        <div class=" flex gap-2 mt-1 ">
                            <a href="/pesertakolektif/{{ $kelasmi->id }}" class=" sm:block hidden">
                                <span class=" bg-blue-600 text-white rounded-sm px-2 py-1  "> Kolektif</span>
                            </a>
                            <a href="/kelas_mi">
                                <span class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kembali</span>
                            </a>
                        </div>

                        <div class="">
                            <button class="sm:block hidden   w-10 justify-center text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                <x-icons.print></x-icons.print>
                            </button>
                        </div>
                    </div>
                    <div id="div1" class=" text-green-800 sm:text-green-800">
                        <div class=" text-sm px-2  text-center  sm:hidden block ">
                            <div class=" flex">
                                <div><img src={{ asset("asset/images/logo.png") }} alt="" width="120" class="  mt-3  p-2"></div>
                                <div>
                                    <center>
                                        <p class=" capitalize  text-4xl  font-riqah py-2">
                                            المدرسة الدينية الوسطى الواحدية
                                        </p>
                                        </p>
                                        <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                                        <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                                            Wahidiyah</p>
                                        <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
                                        <p class=" capitalize font-serif text-lg font-semibold">Tahun Pelajaran {{$datakelasmi->periode}} {{$datakelasmi->ket_semester}}</p>
                                    </center>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <p class=" text-ml font-semibold"> Kelas : {{$datakelasmi->nama_kelas}} </p>
                            </div>
                        </div>
                        <div class=" overflow-auto">
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
                                            {{$dataKelas->links()}}
                                        </td>
                                    </tr>
                                </tbody>
                            </Table>
                        </div>
                        <div class=" text-sm     sm:hidden block ">
                            jika ada kesalahan atau tidak ada di daftar mohon hubungi WAKA KESISWAAN
                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>