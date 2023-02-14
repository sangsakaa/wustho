<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
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
    <div class=" flex gap-1 px-4 py-1">
        <button class=" flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
            <x-icons.print></x-icons.print>
            Validasi
        </button>
    </div>
    <div class=" bg-white px-1 py-1">
        <form action="/validasi-data" method="get" class="  text-sm gap-1 flex">
            <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari .." autofocus>
            <!-- <select name="cari" id="">
                @foreach($dataKelas as $item)
                <option value="{{ $item->id }}" {{ $kelasmi?->id == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kelas }}{{$item->id}} - {{ $item->periode }} {{ $item->ket_semester }}
                </option>
                @endforeach
            </select> -->
            <button type="submit" class=" px-2    bg-blue-500  rounded-md text-white">
                Cari By Nama </button>
        </form>
    </div>
    <div id="div1" class="  bg-white grid  grid-cols-1 px-2 py-2 gap-2">

        <span class=" text-center uppercase font-semibold">Data Validasi</span>

        <table class=" w-full">
            <thead>
                <tr class=" text-xs">
                    <th class=" px-1 capitalize border border-black">No</th>
                    <th class=" px-1 capitalize border border-black">Nama</th>
                    <th class=" px-1 capitalize border border-black">JK</th>
                    <th class=" px-1 capitalize border border-black">TTL</th>
                    <th class=" px-1 capitalize border border-black">KLS</th>
                    <th class=" px-1 capitalize border border-black">Nama Ayah</th>
                    <th class=" px-1 capitalize border border-black">Pekerjaan Ayah</th>
                    <th class=" px-1 capitalize border border-black">No Hp Ayah</th>
                    <th class=" px-1 capitalize border border-black">Nama Ibu</th>
                    <th class=" px-1 capitalize border border-black">Pekerjaan Ibu</th>
                    <th class=" px-1 capitalize border border-black">No Hp ibu</th>
                    <th class=" px-1 capitalize border border-black">Status anak</th>
                    <th class=" px-1 capitalize border border-black">jml Sdr</th>
                    <th class=" px-1 capitalize border border-black">anak ke</th>
                    <th class=" px-1 capitalize border border-black">daerah asal</th>
                    <th class=" px-1 capitalize border border-black">Status Pengamal</th>

                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr class=" text-xs  even:bg-gray-100">
                    <th class=" px-1 py-2 capitalize border border-black">{{$loop->iteration}}</th>
                    <td class=" px-1 py-2 capitalize border border-black">{{strtolower($item->nama_siswa)}}</td>
                    <td class=" px-1 py-2 capitalize border border-black text-center">{{$item->jenis_kelamin}}</td>
                    <td class=" px-1 py-2 capitalize border border-black">{{strtolower($item->tempat_lahir)}}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</td>
                    <td class=" px-1 py-2 capitalize border border-black text-center">{{$item->nama_kelas}}</td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                    <td class=" px-1 py-2 capitalize border border-black"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>