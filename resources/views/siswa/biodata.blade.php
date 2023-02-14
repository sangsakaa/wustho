<x-app-layout>
    <x-slot name="header">
        @section('title','BIODATA : ' . $siswa->nama_siswa )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Biodata') }}
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
    <div class="py-2 px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid  sm:grid-cols-2 grid-cols-2 ">
                        <div class=" flex w-full">
                            <div class="grid w-36  ">Nama </div>
                            <div class=" px-4 grid uppercase font-semibold   text-sm ">: {{$siswa->nama_siswa}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="grid w-36 ">Tanggal Lahir </div>
                            <div class=" px-4">: {{$siswa->tempat_lahir}} , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</div>
                        </div>

                        <div class=" flex w-full">
                            <div class=" grid  w-36 ">Jenis Kelamin </div>
                            <div class=" px-4"> : {{$siswa->jenis_kelamin}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="  grid w-36    ">Status Asrama </div>
                            <div class=" px-4     "> :
                                @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama !== null)
                                {{$siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama}}
                                @else
                                <span class=" text-red-600 ">Belum Memiliki Asrama</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-1 justify-end gap-2">
                        <a href="/siswa/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 text-white">Kembali</a>

                        <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                            <x-icons.print></x-icons.print>
                            Biodata
                        </button>
                    </div>

                    <div id="div1" class=" grid grid-cols-1">
                        <div class=" text-center font-semibold border py-2 text-md mt-2 text-2xl bg-gray-100">BIODATA SISWA</div>
                        <div class=" grid grid-cols-2 py-2">
                            <div class=" border py-2 px-2">1. Nomor Induk Siswa</div>

                            <div class=" border py-1 px-2 ">: <span class="font-semibold text-2xl">
                                    @if($biodata !== $biodata->nis)
                                    {{$biodata->nis}}
                                    @else
                                    Belum ada NIS
                                    @endif
                                </span>
                            </div>
                            <div class=" border py-2 px-2">2. Nama Lengkap</div>
                            <div class=" border py-2 px-2">: {{$biodata->nama_siswa}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">3. Jenis Kelamin</div>
                            <div class=" border py-2 px-2">: {{$biodata->jenis_kelamin}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">4. Agama</div>
                            <div class=" border py-2 px-2">: {{$biodata->agama}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">5. Tempat,Tanggal Lahir</div>
                            <div class=" border py-2 px-2 capitalize">: {{$biodata->tempat_lahir}}, {{$biodata->tanggal_lahir}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">6. Status Pengamal</div>
                            <div class=" border py-2 px-2 capitalize">: {{$biodata->status_pengamal}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">7. Jumlah Saudara Kandung</div>
                            <div class=" border py-2 px-2">: {{$biodata->jumlah_saudara}} </div>
                            <div class=" border py-2 px-2" class=" w-1/2">8. Anak Ke</div>
                            <div class=" border py-2 px-2">: {{$biodata->anak_ke}} </div>
                            <div class=" border py-2 px-2" class=" w-1/2">9. Status Anak </div>
                            <div class=" border py-2 px-2 capitalize">: {{$biodata->status_anak}}</div>
                            <div class=" border py-2 px-2 " class=" w-1/2">10. Nama Ayah </div>
                            <div class=" border py-2 px-2">: {{$biodata->nama_ayah}}</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Pekerjaan </div>
                            <div class=" border py-2 px-2">: {{$biodata->pekerjaan_ayah}}</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Nomor Hp </div>
                            <div class=" border py-2 px-2">: {{$biodata->nomor_hp_ayah}} </div>
                            <div class=" border py-2 px-2" class=" w-1/2">11. Nama Ibu </div>
                            <div class=" border py-2 px-2">: {{$biodata->nama_ibu}} </div>
                            <div class=" border py-2 px-6" class=" w-1/2">Pekerjaan </div>
                            <div class=" border py-2 px-2">: {{$biodata->pekerjaan_ibu}} </div>
                            <div class=" border py-2 px-6" class=" w-1/2">Nomor Hp </div>
                            <div class=" border py-2 px-2">: {{$biodata->nomor_hp_ibu}} </div>
                            <div class=" border py-2 px-2" class=" w-1/2">12. Nama Wali </div>
                            <div class=" border py-2 px-2">: {{$biodata->nama_ayah}} </div>

                            <div class=" border py-2 px-2" class=" w-1/2">13. Daerah Asal </div>
                            <div class=" border py-2 px-2 capitalize">: {{$biodata->kota_asal}}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>