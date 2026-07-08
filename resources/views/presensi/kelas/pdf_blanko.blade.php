<style>
  @page {
    margin: 12mm;
    size: A4 landscape;
  }

  body {
    margin: 0;
    padding: 0;
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #14532d;
  }

  .container {
    width: 100%;
  }

  .header {
    width: 100%;
    margin-bottom: 8px;
  }

  .logo {
    width: 90px;
    text-align: center;
    vertical-align: middle;
  }

  .logo img {
    width: 85px;
  }

  .title {
    text-align: center;
    vertical-align: middle;
  }

  .title h1 {
    margin: 0;
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
  }

  .title h2 {
    margin: 0;
    font-size: 14px;
    text-transform: uppercase;
  }

  .title h3 {
    margin: 4px 0 0;
    font-size: 11px;
    text-transform: uppercase;
  }

  hr {
    border: 0;
    border-top: 2px solid #14532d;
    margin: 2px 0;
  }

  .info {
    width: 100%;
    margin: 8px 0;
  }

  .info td {
    border: none;
    padding: 2px;
    font-weight: bold;
    font-size: 14px;
  }

  .info .center {
    text-align: center;
  }

  .info .right {
    text-align: right;
  }

  .badge {
    display: inline-block;
    padding: 3px 10px;
    border: 1px solid #166534;
    border-radius: 4px;
  }

  .putra {
    background: #d1fae5;
  }

  .putri {
    background: #fce7f3;
  }

  table.presensi {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
  }

  table.presensi th,
  table.presensi td {
    border: 1px solid #166534;
    padding: 3px;
    font-size: 10px;
  }

  table.presensi thead th {
    background: #ecfdf5;
  }

  .no {
    width: 28px;
    text-align: center;
  }

  .nama {
    width: 200px;
  }

  .kelas {
    width: 5px;
    text-align: center;
  }

  .hari {
    width: 18px;
    text-align: center;
  }

  .kamis {
    background: #166534 !important;
    color: white;
    font-weight: bold;
  }

  .text-center {
    text-align: center;
  }

  .uppercase {
    text-transform: uppercase;
  }
</style>

<body>

  <div class="bg-white dark:bg-dark-bg " id="blanko">
    <div class="py-3 px-3">
      <div class="overflow-x-auto ">
        {{-- HEADER --}}
        <table class="header">
          <tr>
            <td class="logo" width="90">
              <img src="file://{{ public_path('asset/images/logo.png') }}">
            </td>

            <td class="title">

              <h2>DEPARTEMEN PENDIDIKAN DINIYAH WAHIDIYAH</h2>

              <h1>
                MADRASAH DINIYAH {{ strtoupper($kelasmi->jenjang) }} WAHIDIYAH
              </h1>

              <h3>
                TAHUN PELAJARAN
                {{ $kelasmi->periode }}
                {{ $kelasmi->ket_semester }}
              </h3>

            </td>
          </tr>
        </table>
        <hr class="border-b-2 border-green-900 mt-2">
        <hr class="mt-0.5 border-b border-green-900">
        {{-- INFO --}}
        <table class="info">

          <tr>

            <td width="30%">
              Bulan : {{ $bulan->monthName }}
            </td>

            <td class="center" width="40%">

              <span class="badge putra">
                Putra :
                {{ $dataSiswa->where('jenis_kelamin','L')->count() }}
              </span>

              &nbsp;

              <span class="badge putri">
                Putri :
                {{ $dataSiswa->where('jenis_kelamin','P')->count() }}
              </span>

            </td>

            <td class="right" width="30%">
              Kelas :
              {{ $kelasmi->nama_kelas }}
            </td>

          </tr>

        </table>

        <hr class="border-b border-green-600">

        {{-- TABEL --}}
        <div class="overflow-x-auto mt-2 rounded-lg border border-green-700">

          <table class="presensi">

            <thead>

              <tr>

                <th class="no" rowspan="2">No</th>

                <th class="nama" rowspan="2">
                  Nama Siswa
                </th>

                <th class="kelas" rowspan="2">
                  Kls
                </th>

                <th colspan="{{ $periodeBulan->count() }}">
                  Tanggal
                </th>

              </tr>

              <tr>

                @foreach($periodeBulan as $hari)

                <th class="hari {{ $hari->isThursday() ? 'kamis' : '' }}">
                  {{ $hari->day }}
                </th>

                @endforeach

              </tr>

            </thead>

            <tbody>

              @foreach($dataSiswa as $siswa)

              <tr>

                <td class="text-center">
                  {{ $loop->iteration }}
                </td>

                <td>
                  {{ ucwords(strtolower($siswa->nama_siswa)) }}
                </td>

                <td class="text-center">
                  {{ $siswa->nama_kelas }}
                </td>

                @foreach($periodeBulan as $hari)

                <td class="{{ $hari->isThursday() ? 'kamis' : '' }}">
                  &nbsp;
                </td>

                @endforeach

              </tr>

              @endforeach

            </tbody>

          </table>

        </div>

      </div>

    </div>

  </div>
</body>