<x-app-layout>
  <x-slot name="header">
    @section('title', ' | PLOTING KELAS' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('PLOTING JENIS KELAMIN') }}
    </h2>
  </x-slot>
  <style>
    .page-break {
      page-break-after: always;
    }
  </style>
  <script>
    function printContent(el) {
      var fullbody = document.body.innerHTML;
      var printContent = document.getElementById(el).innerHTML;
      document.body.innerHTML = printContent;
      window.print();
      document.body.innerHTML = fullbody;
    }
  </script>
  <div class=" px-4 py-2 my-2 bg-white ">
    <div class=" flex  grid-cols-1">
      <div class=" w-full">
        <form action="/ploting-kelas-jenis-kelamin" method="get" class="flex gap-1">
          <select name="cari" id="" class="uppercase py-1 px-2 w-1/4">
            @foreach($datakelas as $item)
            <option value="{{ $item->kelas }}" {{ $item->kelas == request('cari', $datakelas[0]->kelas) ? 'selected' : '' }}>Kelas {{ $item->kelas }}</option>
            @endforeach
          </select>
          <button type="submit" class="px-2 bg-blue-500 rounded-md text-white">Plotting</button>
        </form>

      </div>
      <div class=" w-full flex justify-end gap-2">
        <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
          Cetak
        </button>
        <a href="/ploting-kelas-jenis-kelamin">Refresh</a>
        <a href="/plotingkelas">Berdasarkan Kelas</a>
      </div>
    </div>
  </div>
  <div id="div1">
    <div class=" text-center text-green-800">
      <p class=" font-semibold text-1xl">
        MADRASAH DINIYAH WUSTHO WAHIDIYAH
      </p>
      <p class=" text-2xl uppercase font-semibold">Daftar Ploting Ke</p>
      <p class=" font-semibold uppercase">
        TAHUN PELAJARAN
      </p>
    </div>
    <div class=" p-4 bg-white ">
      <div class=" grid grid-cols-1 gap-2">
        <div>

        </div>
        <div class="  text-red-600">
          <div class=" p-1">
            <p>Daftar Ploting Kelas :</p>
            <p>1. Nilai Kurang dari 600 dari akumulasi 6 mapel</p>
          </div>
        </div>
      </div>
    </div>
    <div class=" px-4 py-1 bg-white ">
      <table class=" w-full">
        <thead>
          <tr>
            <th class="border-green-700 border">Kelas</th>
            <th class="border-green-700 border">No</th>
            <th class="border-green-700 border">Nama Siswa</th>
            <th class="border-green-700 border">Jenis Kelamin</th>
            <th class="border-green-700 border">Nama Kelas</th>
            <th class="border-green-700 border">Total Nilai</th>

          </tr>
        </thead>
        <tbody>
          @foreach($dataPlotting->groupBy('kelas') as $kelas => $siswas_by_kelas)
          @foreach($siswas_by_kelas->groupBy('jenis_kelamin') as $jenis_kelamin => $siswas_by_jenis_kelamin)
          @foreach($siswas_by_jenis_kelamin->chunk(35) as $siswas)
          <tr class="border-green-700 border">
            <td class="border-green-700 border" colspan="7">{{ $kelas }}</td>
          </tr>
          <tr class="border-green-700 border">
            <td class="border-green-700 border" colspan="7">{{ $jenis_kelamin }}</td>
          </tr>
          @foreach($siswas as $data)
          <tr class="border-green-700 border">
            <td class="border-green-700 border px-1 text-center">{{ $data->kelas }}</td>
            <td class="border-green-700 border px-1 text-center">{{ $loop->iteration }}</td>
            <td class="border-green-700 border px-1 text-left capitalize">{{ strtolower($data->nama_siswa) }}</td>
            <td class="border-green-700 border px-1 text-center">{{ $data->jenis_kelamin }}</td>
            <td class="border-green-700 border px-1 text-center">{{ $data->nama_kelas }}</td>
            <td class="border-green-700 border px-1 text-center">{{ $data->total_harian +  $data->total_ujian  }}</td>

          </tr>
          @if($loop->iteration == 31)

          <tr class="border-green-700 border">
            <td class="border-green-700 border" colspan="6">{{ $kelas }}</td>
          </tr>
          <tr class="border-green-700 border">
            <td class="border-green-700 border" colspan="6">{{ $jenis_kelamin }}</td>
          </tr>
          @endif
          @endforeach
          @endforeach
          @endforeach
          @endforeach



        </tbody>
      </table>



    </div>

  </div>
</x-app-layout>