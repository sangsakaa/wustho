<x-app-layout>
  <x-slot name="header">
    @section('title', ' | PLOTING KELAS' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('PLOTING KELAS') }}
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
        <form action="/plotingkelas" method="get" class=" flex gap-1">
          <select name="cari" id="" class=" uppercase py-1 px-2 w-1/2">
            @foreach($datakelas as $item)
            <option value="{{ $item->kelas }}" {{ $item->kelas == request('cari') ? 'selected' : '' }}>Kelas {{ $item->kelas }}</option>
            @endforeach
          </select>
          <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
            Ploting </button>
        </form>
      </div>
      <div class=" w-full flex justify-end  grid-cols-1 gap-1">
        <div>
          <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
            Cetak
          </button>
        </div>
        <div class=" py-1 ">
          <a href="/ploting-kelas-jenis-kelamin" class="bg-green-800 px-2 py-1 text-white">Jenis Kelamin</a>
        </div>
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
          <table class=" w-full">
            <thead>
              <tr class="border text-center border-green-800">
                <th class="border text-center border-green-800">Jumlah Perkelas</th>
                <th class="border text-center border-green-800"> MIN : {{$min}}</th>
                <th class="border text-center border-green-800"> MAX : {{$max}}</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border text-center border-green-800">
                <td class="border text-center border-green-800">{{ $data }}</td>
                <td class="border text-center border-green-800">
                  @if($data >= $min)
                  {{ceil($data/$min)}}
                  @else
                  1
                  @endif
                </td>
                <td class="border text-center border-green-800">
                  @if($data >= $max)
                  {{ceil($data/$max)}}
                  @else "tidak memenuhi syarat" @endif
                </td>
              </tr>
            </tbody>
          </table>
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
          <tr class="border border-green-700 px-1 capitalize text-center">
            <th class="border border-green-700 px-1 capitalize text-center">No</th>
            <th class="border border-green-700 px-1 capitalize text-center">Nama Siswa</th>
            <th class="border border-green-700 px-1 capitalize text-center">Kelas</th>
            <th class="border border-green-700 px-1 capitalize text-center">Kelas</th>

            <th class="border border-green-700 px-1 capitalize text-center">Total Nilai</th>
          </tr>
        </thead>
        <tbody>
          @php
          $currentNamaKelas = ''; // initialize the current class name
          $counter = 0; // initialize the row counter
          @endphp

          @foreach ($dataPlotting as $key => $nilai)
          @php
          $kelasIndex = floor($key/30); // menghitung indeks kelas A, B, C, dst.
          $namaKelas = chr(65+$kelasIndex); // mengubah indeks ke huruf, dimulai dari A
          $isMultipleOf30 = ($key+1) % 30 === 0;
          $isLastRow = ($key+1) === count($dataPlotting);
          @endphp

          @if ($namaKelas !== $currentNamaKelas) {{-- if the class name changes, reset the counter and display the class name --}}
          @php
          $currentNamaKelas = $namaKelas;
          $counter = 1;
          @endphp
          <tr class="border border-green-700 px-1 capitalize text-center {{ strtolower($namaKelas) }}">
            <td class="border border-green-700 px-1  text-left uppercase text-2xl" colspan="7">Kelas : {{ $namaKelas }}</td>
          </tr>
          @endif

          <tr class="border border-green-700 px-1 capitalize text-center {{ $isMultipleOf30 ? strtolower($namaKelas) : '' }}">
            <td class="border border-green-700 px-1 capitalize text-center">{{ $counter }}</td> {{-- display the counter instead of $key + 1 --}}
            <td class="border border-green-700 px-1 capitalize text-left">{{ strtolower($nilai->nama_siswa) }}</td>
            <td class="border border-green-700 px-1 capitalize text-center">{{ $nilai->kelas }}</td>
            <td class="border border-green-700 px-1 capitalize text-center">{{ $nilai->nama_kelas }}</td>

            <td class="border border-green-700 px-1 capitalize text-center">{{ $nilai->total_harian + $nilai->total_ujian }}</td>
          </tr>
          @if ($isMultipleOf30 && !$isLastRow)
          @php
          $nextKelasIndex = floor(($key + 1)/30); // menghitung indeks kelas A, B, C, dst. untuk baris berikutnya
          $nextNamaKelas = chr(65+$nextKelasIndex); // mengubah indeks ke huruf, dimulai dari A, untuk baris berikutnya
          @endphp
          @if ($nextNamaKelas !== $namaKelas) {{-- display the class name only if it changes --}}


          @endif
          @endif

          @php $counter++; @endphp {{-- increment the row counter --}}

          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>