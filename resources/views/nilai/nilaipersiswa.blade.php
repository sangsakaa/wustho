<x-app-layout>
    <x-slot name="header">
        @section('title', ' | KHT')
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Kartu Hasil Tadris') }}
        </h2>
    </x-slot>
    <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
        <div class="p-4  border-b border-gray-200">
            <div class=" flex grid-cols-1 sm:grid-cols-2 gap-1 w-full  py-1">
                <div>
                    <button class=" flex w-10 justify-center text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                    </button>
                </div>
                <script>
                    function printContent(el) {
                        var fullbody = document.body.innerHTML;
                        var printContent = document.getElementById(el).innerHTML;
                        document.body.innerHTML = printContent;
                        window.print();
                        document.body.innerHTML = fullbody;
                    }
                </script>
                <div class="">
                    <form action="/nilai" method="get">
                        <select name="kelasmi" id="" class=" border border-green-800 text-green-800 rounded-md py-1" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasmiSiswa as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmiTerpilih->id == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class=" px-1 py-1   bg-blue-500  rounded-md text-white">
                            Pilih Periode
                        </button>
                    </form>
                </div>
            </div>

            <div id="div1">
                <div class=" overflow-auto  rounded-md ">
                    <div class=" text-center  text-2xl capitalize py-2">
                        <span> kartu hasil tadris</span>
                    </div>
                    <div class=" text-xs sm:text-sm grid grid-cols-2 sm:grid-cols-4 gap-1">
                        <div>Nomor Induk Siswa </div>
                        <div> : {{$user->nis}} </div>
                        <div>Kelas / Semester </div>
                        <div> : {{$title->nama_kelas}}/{{$title->semester}}</div>
                        <div>Nama Siswa </div>
                        <div class=" w-full text-xs"> : {{$user->nama_siswa}} </div>
                        <div>Periode </div>
                        <div> : {{$title->periode}} {{$title->ket_semester}}</div>
                    </div>
                    <hr class=" py-1">
                    <table class=" text-xs sm:text-sm w-full ">
                        <thead>
                            <tr class="border bg-gray-200 dark:bg-purple-600">
                                <th class=" border px-1  py-1">#</th>
                                <th class=" border px-1">Pelajaran</th>

                                <th class=" border px-1">Nama Guru</th>
                                <th class=" border px-1">NH</th>
                                <th class=" border px-1">NU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($dataNilai->count())
                            @foreach ($dataNilai as $nilai)
                            <tr class="border ">
                                <td class=" border text-center px-1">{{ $loop->iteration }}</td>
                                <td class=" border text-center px-1 py-2">{{ $nilai->mapel }}</td>

                                <td class=" border text-left px-1">{{ $nilai->nama_guru }}</td>
                                <td class=" border text-center px-1">{{ $nilai->nilai_harian }}</td>
                                <td class=" border text-center px-1">{{ $nilai->nilai_ujian }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="border">
                                <td colspan="11" class="text-sm border text-center py-4">
                                    Tidak ada data
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>