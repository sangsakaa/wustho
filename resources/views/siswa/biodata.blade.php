<x-app-layout>
    <x-slot name="header">
        @section('title','BIODATA : ' . $siswa->nama_siswa )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Biodata
        </h2>
    </x-slot>
    <script>
        function printContent(el) {
            let fullbody = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>

    <!-- HEADER INFO -->
    <div class="py-4 px-6">
        <div class="bg-white shadow rounded-xl p-4">
            <div class="grid sm:grid-cols-2 gap-3 text-sm">

                <div class="flex">
                    <div class="w-40 font-medium">Nama</div>
                    <div class="flex-1 font-semibold uppercase">: {{$siswa->nama_siswa}}</div>
                </div>

                <div class="flex">
                    <div class="w-40 font-medium">Tanggal Lahir</div>
                    <div class="flex-1">
                        : {{$siswa->tempat_lahir}},
                        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                    </div>
                </div>

                <div class="flex">
                    <div class="w-40 font-medium">Jenis Kelamin</div>
                    <div class="flex-1">: {{$siswa->jenis_kelamin}}</div>
                </div>

                <div class="flex">
                    <div class="w-40 font-medium">Status Asrama</div>
                    <div class="flex-1">
                        :
                        @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama)
                        {{$siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama}}
                        @else
                        <span class="text-red-600">Belum Memiliki Asrama</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- BIODATA -->
    <div class="px-6 pb-6">
        <div class="bg-white shadow rounded-xl p-4">

            <!-- ACTION -->
            <div class="flex justify-end gap-2 mb-4">
                <a href="/siswa/{{$siswa->id}}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md">
                    Kembali
                </a>

                <button onclick="printContent('div1')"
                    class="bg-green-700 hover:bg-green-800 text-white px-3 py-1 rounded-md flex items-center gap-1">
                    <x-icons.print />
                    Biodata
                </button>
            </div>

            <!-- PRINT AREA -->
            <div id="div1">

                <h2 class="text-center text-xl font-bold border-b pb-2 mb-4 bg-gray-100 py-2">
                    BIODATA MURID
                </h2>

                <div class="grid grid-cols-2 text-sm">

                    <div class="border p-2">1. Nomor Induk Murid</div>
                    <div class="border p-2 font-semibold text-lg">
                        : {{$biodata->nis ?? 'Belum ada NIS'}}
                    </div>

                    <div class="border p-2">2. Nama Lengkap</div>
                    <div class="border p-2">: {{$biodata->nama_siswa}}</div>

                    <div class="border p-2">3. Jenis Kelamin</div>
                    <div class="border p-2">: {{$biodata->jenis_kelamin}}</div>

                    <div class="border p-2">4. Agama</div>
                    <div class="border p-2">: {{$biodata->agama}}</div>

                    <div class="border p-2">5. Tempat, Tanggal Lahir</div>
                    <div class="border p-2 capitalize">
                        : {{$biodata->tempat_lahir}}, {{$biodata->tanggal_lahir}}
                    </div>

                    <div class="border p-2">6. Status Pengamal</div>
                    <div class="border p-2 capitalize">: {{$biodata->status_pengamal}}</div>

                    <div class="border p-2">7. Jumlah Saudara</div>
                    <div class="border p-2">: {{$biodata->jumlah_saudara}}</div>

                    <div class="border p-2">8. Anak Ke</div>
                    <div class="border p-2">: {{$biodata->anak_ke}}</div>

                    <div class="border p-2">9. Status Anak</div>
                    <div class="border p-2 capitalize">: {{$biodata->status_anak}}</div>

                    <div class="border p-2">10. Nama Ayah</div>
                    <div class="border p-2 capitalize">: {{$biodata->nama_ayah}}</div>

                    <div class="border p-2 pl-6">Pekerjaan</div>
                    <div class="border p-2 capitalize">: {{$biodata->pekerjaan_ayah}}</div>

                    <div class="border p-2 pl-6">No HP</div>
                    <div class="border p-2">: {{$biodata->nomor_hp_ayah}}</div>

                    <div class="border p-2">11. Nama Ibu</div>
                    <div class="border p-2 capitalize">: {{$biodata->nama_ibu}}</div>

                    <div class="border p-2 pl-6">Pekerjaan</div>
                    <div class="border p-2 capitalize">: {{$biodata->pekerjaan_ibu}}</div>

                    <div class="border p-2 pl-6">No HP</div>
                    <div class="border p-2">: {{$biodata->nomor_hp_ibu}}</div>

                    <div class="border p-2">12. Nama Wali</div>
                    <div class="border p-2 capitalize">: {{$biodata->nama_ayah}}</div>

                    <div class="border p-2">13. Daerah Asal</div>
                    <div class="border p-2 capitalize">: {{$biodata->kota_asal}}</div>

                </div>

                <!-- FOOTER -->
                <div class="grid grid-cols-2 mt-6">

                    <div class="flex justify-center">
                        <div class="border w-32 h-40 flex items-center justify-center text-gray-400">
                            Foto 3x4
                        </div>
                    </div>

                    <div class="text-left text-sm">
                        <p>
                            Kedunglo,
                            {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                        </p>
                        <p>Kepala Madrasah</p>

                        <div class="h-20"></div>

                        <p class="uppercase font-semibold">
                            {{$perangkat->first()?->nama_perangkat}}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>
    ```

</x-app-layout>