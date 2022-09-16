<x-app-layout>
    <x-slot name="header">
        @section('title', ' | BIODATA' )
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
                    <div class=" grid sm:grid-cols-4 grid-cols-2">
                        <div>Nama </div>

                        <div>:

                            {{$siswa->nama_siswa}}

                        </div>
                        <div>Tanggal Lahir </div>
                        <div>: {{$siswa->tempat_lahir}}</div>
                        <div>Jenis Kelamin </div>
                        <div>: {{$siswa->jenis_kelamin}}</div>
                        <div>Tempat Lahir </div>
                        <div>: {{$siswa->tanggal_lahir}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @role('admin')
    <div class=" px-4">

        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-1 justify-end gap-2">
                        <a href="/siswa/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 text-white">Kembali</a>

                        <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                            Cetak Biodata</button>
                    </div>
                    <div id="div1" class=" grid grid-cols-1">
                        <div class=" text-center font-semibold border py-2 text-md mt-2 text-2xl bg-gray-100">BIODATA SISWA</div>
                        <div class=" grid grid-cols-2 py-2">
                            <div class=" border py-2 px-2">1. Nomor Induk Siswa</div>
                            <div class=" border py-1 px-2 font-semibold text-2xl">: {{$siswa->nis}}</div>
                            <div class=" border py-2 px-2">2. Nama Lengkap</div>
                            <div class=" border py-2 px-2">: {{$siswa->nama_siswa}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">3. Jenis Kelamin</div>
                            <div class=" border py-2 px-2">: {{$siswa->jenis_kelamin}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">4. Agama</div>
                            <div class=" border py-2 px-2">: {{$siswa->agama}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">5. Tempat,Tanggal Lahir</div>
                            <div class=" border py-2 px-2">: {{$siswa->tempat_lahir}},{{$siswa->tanggal_lahir}}</div>
                            <div class=" border py-2 px-2" class=" w-1/2">6. Status Pengamal</div>
                            <div class=" border py-2 px-2">: Pengamal / Belum Pengamal / Simpatisan</div>
                            <div class=" border py-2 px-2" class=" w-1/2">7. Jumlah Saudara Kandung</div>
                            <div class=" border py-2 px-2">: 5 </div>
                            <div class=" border py-2 px-2" class=" w-1/2">8. Anak Ke</div>
                            <div class=" border py-2 px-2">: 5 </div>
                            <div class=" border py-2 px-2" class=" w-1/2">9. Status Anak </div>
                            <div class=" border py-2 px-2">: Kandung / Angkat</div>
                            <div class=" border py-2 px-2" class=" w-1/2">10. Nama Ayah </div>
                            <div class=" border py-2 px-2">: Ahmad Bastomi Wahid</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Pekerjaan </div>
                            <div class=" border py-2 px-2">: Swasta</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Nomor Hp </div>
                            <div class=" border py-2 px-2">: 083234345678</div>
                            <div class=" border py-2 px-2" class=" w-1/2">11. Nama Ibu </div>
                            <div class=" border py-2 px-2">: Wartini</div>
                            <div class=" border py-2 px-2" class=" w-1/2">12. Nama Wali </div>
                            <div class=" border py-2 px-2">: Ahmad Bastomi Wahid</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Pekerjaan </div>
                            <div class=" border py-2 px-2">: Swasta</div>
                            <div class=" border py-2 px-6" class=" w-1/2">Nomor Hp </div>
                            <div class=" border py-2 px-2">: Swasta</div>
                            <div class=" border py-2 px-2" class=" w-1/2">13. Daerah Asal </div>
                            <div class=" border py-2 px-2">: {{$siswa->kota_asal}}</div>
                        </div>
                        <div class=" grid grid-cols-2">
                            <div></div>
                            <div>
                                <p>
                                    Kedunglo, <?php
                                                $date = date_create(now());
                                                echo date_format($date, "d-m-Y");
                                                ?></p>
                                <p>Al Mudir / Kepala Sekolah</p><br><br><br><br>
                                <p>Muh. Bahrul Ulum,S.H</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole


</x-app-layout>