<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Kartu Login Kolektif</title>

  <style>
    @page {
      size: F4 portrait;
      margin: 5mm;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    table.layout {
      width: 100%;
      border-collapse: collapse;
    }

    td.slot {
      width: 50%;
      padding: 1.5mm;
      vertical-align: top;
    }

    .card {
      width: 85.6mm;
      height: 45mm;
      border: 1px solid #111;
      border-radius: 4px;
      box-sizing: border-box;
      padding: 3mm;
      position: relative;
      margin: auto;
    }

    /* HEADER */
    .header {
      text-align: center;
      border-bottom: 1px solid #000;
      padding-bottom: 1.2mm;
      margin-bottom: 2mm;
    }

    .instansi {
      font-size: 8px;
      font-weight: bold;
    }

    .sub {
      font-size: 6px;
    }

    /* CONTENT */
    .content {
      width: 100%;
      height: 24mm;
      border-collapse: collapse;
      margin-top: 2mm;
    }

    .content td {
      vertical-align: middle;
    }

    .qr-box {
      width: 38%;
      text-align: center;
      vertical-align: middle;
    }

    .qr-box img {
      width: 24mm;
      height: 24mm;
      display: block;
      margin: auto;
    }

    .info-box {
      width: 62%;
      padding-left: 3mm;
      vertical-align: middle;
    }

    .nama {
      font-size: 9px;
      font-weight: bold;
      line-height: 1.3;
      margin-bottom: 2mm;
    }

    .nis {
      font-size: 7px;
      color: #333;
    }

    /* FOOTER */
    .footer {
      position: absolute;
      bottom: 1.5mm;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 5px;
      color: #555;
      border-top: 1px solid #ddd;
      padding-top: 1mm;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  @foreach($dataSiswa->chunk(10) as $page)
  <table class="layout">
    @foreach($page->chunk(2) as $row)
    <tr>
      @foreach($row as $item)
      <td class="slot">
        <div class="card">

          <div class="header">
            <div class="instansi">KARTU IDENTITAS SISWA</div>
            <div class="sub">Sistem Presensi Digital Sekolah</div>
          </div>

          <table class="content">
            <tr>
              <td class="qr-box">
                <br>
                <img src="data:image/png;base64,{{ $item['qr'] }}">
              </td>

              <td class="info-box">
                <div class="nama">
                  {{ $item['siswa']->nama_siswa }}
                </div>
                <div class="nis">
                  NIS: {{ $item['nis'] }}
                </div>
              </td>
            </tr>
          </table>

          <div class="footer">
            Kartu resmi login & presensi siswa
          </div>

        </div>
      </td>
      @endforeach

      @if($row->count() == 1)
      <td class="slot"></td>
      @endif
    </tr>
    @endforeach
  </table>

  @if(!$loop->last)
  <div class="page-break"></div>
  @endif
  @endforeach

</body>

</html>