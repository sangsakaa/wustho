@php
use Carbon\Carbon;

$tahun = $tahun ?? date('Y');

function kodeKategori($kategori)
{
return match ($kategori) {
'Pembelajaran' => 'P',
'Ujian' => 'U',
'Libur' => 'L',
'Hari Besar Nasional' => 'HN',
'Hari Besar Keagamaan' => 'HK',
'Peringatan Internasional' => 'PI',
'Rapat' => 'R',
'Kegiatan Sekolah' => 'K',
'Ekstrakurikuler' => 'E',
'PPDB' => 'PPDB',
'Kelulusan' => 'KL',
'Asesmen' => 'A',
default => 'X',
};
}



/*
|--------------------------------------------------------------------------
| Prioritas Event
|--------------------------------------------------------------------------
| Libur > Ujian > Rapat > Kegiatan > Pembelajaran
*/
$prioritasKategori = [
'Pembelajaran' => 1,
'Kegiatan Sekolah' => 2,
'Rapat' => 3,
'Ujian' => 4,
'Libur' => 5,
];

$kalenderEvent = [];
$catatan = collect();

foreach ($events as $event) {

$catatan->push([
'kode' => $event->kode_kegiatan,
'nama' => $event->nama_kegiatan,
'kategori' => $event->kode_kategori,
'mulai' => $event->start,
'selesai' => $event->end,
]);

$mulai = $event->start->copy()->startOfDay();
$selesai = $event->end->copy()->startOfDay();

while ($mulai->lte($selesai)) {

$tanggalKey = $mulai->format('Y-m-d');

$dataEvent = [
'kode' => $event->kode_kegiatan,
'nama' => $event->nama_kegiatan,
'kategori' => $event->kode_kategori,
'prioritas' => $prioritasKategori[$event->kategori] ?? 0,
];

if (
!isset($kalenderEvent[$tanggalKey]) ||
$dataEvent['prioritas'] > ($kalenderEvent[$tanggalKey]['prioritas'] ?? 0)
) {
$kalenderEvent[$tanggalKey] = $dataEvent;
}

$mulai->addDay();
}
}
@endphp

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Kalender Pendidikan</title>

  <style>
    @page {
      margin: 12px;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 6px;
      margin: 12px 12px 12px;
    }



    .box {
      display: inline-flex;
      align-items: center;
      justify-content: center;

      padding: 2px 6px;
      margin: 2px 3px;

      font-size: 9px;
      font-weight: 600;

      border-radius: 999px;
      /* full pill */
      border: 1px solid rgba(0, 0, 0, 0.15);

      background: #f8fafc;
      /* soft white */
      color: #111;

      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);

      letter-spacing: 0.2px;
      line-height: 1;
    }

    .month {
      width: 24%;
      display: inline-block;
      vertical-align: top;
      margin: 0.3%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    th,
    td {
      border: 0.5px solid #000;
      text-align: center;
      font-size: 12px;
    }

    td {
      height: 21px;

      padding: 0;
      vertical-align: middle;
    }

    .tanggal {
      display: block;
      text-align: center;
      font-size: 12px;
      font-weight: bold;
      line-height: 1;
    }

    .kode {
      display: block;
      text-align: center;
      font-size: 4px;
      line-height: 1;
    }

    .clearfix {
      clear: both;
    }

    .legend {
      text-align: left;
      margin: 2px 0 5px;


    }

    .notes {
      margin-top: 4px;
      border-top: 1px solid #000;
      padding-top: 2px;
      font-size: 12px;
    }

    .note-item {
      display: inline-block;
      width: 32%;
      vertical-align: top;
      margin-bottom: 2px;
    }

    .badge {
      display: inline-block;
      width: 12px;
      text-align: center;
      border: 1px solid #000;
      font-size: 8px;
      font-weight: bold;
    }



    .P {
      background-color: #7ee8a3;
      /* Pembelajaran - hijau lebih tegas */
    }

    .U {
      background-color: #ffd84d;
      /* Ujian - kuning kuat */
    }

    .L {
      background-color: #ff6b6b;
      /* Libur - merah jelas */
    }

    .R {
      background-color: #4da3ff;
      /* Rapat - biru kuat */
    }

    .K {
      background-color: #8b7bff;
      /* Kegiatan - ungu tegas */
    }

    .X {
      background-color: #9aa3ad;
      color: white;
      /* Lainnya - abu solid */
    }

    .HN {
      background-color: #ffb000;
      color: white;
      /* Hari Nasional - emas kuat */
    }

    .HK {
      background-color: #ff4fa3;
      color: white;
      /* Keagamaan - pink kuat */
    }

    .PI {
      background-color: #2f80ff;
      color: white;
      /* Internasional - biru pekat */
    }

    .E {
      background-color: #5b6cff;
      color: white;
      /* Ekstrakurikuler - biru-ungu kuat */
    }

    .PPDB {
      background-color: #ff7a1a;
      color: white;
      /* PPDB - oranye kuat */
    }

    .KL {
      background-color: #2ecc71;
      color: white;
      /* Kelulusan - hijau fresh kuat */
    }

    .A {
      background-color: #e53935;
      color: white;
      /* Asesmen - merah tegas */
    }

    .name-label {
      display: inline-block;
      margin-left: 4px;
      font-size: 10px;
      line-height: 1.2;
    }

    .note-item {
      margin-bottom: 2px;
      line-height: 1.2;
    }

    /* FOOTER (dipisah, jangan di dalam loop notes) */
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      font-size: 6px;
      color: #111;
    }

    .footer-line {
      border-top: 1px solid #000;
      margin-bottom: 2px;
    }

    .footer-content {
      text-align: center;
      font-weight: 600;
    }

    .bg-bulan {
      background-color: #2ecc71;
      height: 21px;
    }
  </style>
</head>

<body>

  @php
  $jenjang = 'Wustho'; // Wustho | Ula | Ulya

  $jenjangData = [
  'Wustho' => [
  'nama' => 'Madrasah Diniyah Wustho Wahidiyah',
  'logo' => public_path('asset/images/logo_wustho.png'),
  ],
  'Ula' => [
  'nama' => 'Madrasah Diniyah Ula Wahidiyah',
  'logo' => public_path('asset/images/logoUla.png'),
  ],
  'Ulya' => [
  'nama' => 'Madrasah Diniyah Ulya Wahidiyah',
  'logo' => public_path('asset/images/logo_ulya.jpeg'),
  ],
  ];

  $dataJenjang = $jenjangData[$jenjang] ?? null;
  @endphp

  {{-- WATERMARK --}}
  @if($dataJenjang)
  <img src="{{ $dataJenjang['logo'] }}"
    style="
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            opacity: 0.08;
            z-index: -1000;
        ">
  @endif
  <style>
    @page {
      margin: 5px;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 10px;
      position: relative;
    }
  </style>
  {{-- KOP SURAT --}}
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0;">
    <tr>
      <td width="15%" align="center" valign="middle" style="border:none; padding:0; margin:0;">
        @if($dataJenjang)
        <img src="{{ $dataJenjang['logo'] }}"
          style="width:70px; height:auto; display:block; margin:0 auto;">
        @endif
      </td>

      <td width="70%" align="center" valign="middle" style="border:none; padding:0; margin:0;">
        <div style="font-size:14px; font-weight:bold; line-height:1.2; margin:0;">
          DEPARTEMEN PENDIDIKAN DINIYAH WAHIDIYAH
        </div>

        <div style="font-size:18px; font-weight:bold; line-height:1.2; margin:0;">
          {{ strtoupper($dataJenjang['nama'] ?? 'MADRASAH DINIYAH WAHIDIYAH') }}
        </div>
      </td>

      <td width="15%" style="border:none; padding:0; margin:0;">
        &nbsp;
      </td>
    </tr>
  </table>
  <div style="border-top:1px solid #000;"></div>
  <div style="border-top:3px solid #000; margin-top:2px; margin-bottom:1px;"></div>

  {{-- JUDUL --}}
  <div style="text-align:center; margin-bottom:1px;">
    <div style="font-size:18px; font-weight:bold;">
      KALENDER PENDIDIKAN
    </div>
    <div style="font-size:12px; font-weight:bold;">
      Tahun Pelajaran {{ $periodeAktif->periode ?? '-' }}
    </div>
  </div>
  <div style="width:100%;">

    @for ($bulan = 1; $bulan <= 12; $bulan++)

      @php
      $start=Carbon::create($tahun, $bulan, 1);
      $days=$start->daysInMonth;
      $startDay = $start->dayOfWeek;
      @endphp

      <div class="month">

        <table>

          <tr>
            <th colspan="7" class="bg-bulan">
              {{ strtoupper($start->translatedFormat('F')) }}
            </th>
          </tr>

          <tr>
            <th>Min</th>
            <th>Sen</th>
            <th>Sel</th>
            <th>Rab</th>
            <th>Kam</th>
            <th>Jum</th>
            <th>Sab</th>
          </tr>

          @for($row = 0; $row < 6; $row++)
            <tr>

            @for($col = 0; $col < 7; $col++)

              @php
              $cell=($row * 7) + $col;
              $tanggal=$cell - $startDay + 1;
              @endphp

              @if($tanggal < 1 || $tanggal> $days)

              <td></td>

              @else

              @php
              $tanggalAktif = Carbon::create($tahun, $bulan, $tanggal);
              $keyTanggal = $tanggalAktif->format('Y-m-d');

              $eventHari = $kalenderEvent[$keyTanggal] ?? null;
              @endphp

              <td class="{{ $eventHari['kategori'] ?? '' }}">

                <div class="tanggal">
                  {{ $tanggal }}
                </div>

                @if($eventHari)
                <div class="kode">
                  {{ $eventHari['kode'] }}
                </div>
                @endif

              </td>

              @endif

              @endfor

              </tr>
              @endfor

        </table>

      </div>

      @endfor

  </div>

  <div class="clearfix"></div>
  <div class="notes">
    <div class="legend">
      <span class="box P">P = Pembelajaran</span>
      <span class="box U">U = Ujian</span>
      <span class="box L">L = Libur</span>
      <span class="box R">R = Rapat</span>
      <span class="box K">K = Kegiatan</span>
      <span class="box X">X = Lainnya</span>
      <span class="box HN">HN = Nasional</span>
      <span class="box HK">HK = Keagamaan</span>
      <span class="box PI">PI = Internasional</span>
      <span class="box E">E = Ekskul</span>
      <span class="box PPDB">PPDB</span>
      <span class="box KL">KL = Kelulusan</span>
      <span class="box A">A = Asesmen</span>
    </div>
    <strong>Keterangan Kode Kegiatan:</strong>
    <br> <br>

    @foreach($catatan->sortBy('mulai') as $item)
    <div class="note-item">

      <span class="badge {{ $item['kategori'] }}">
        {{ $item['kode'] }}
      </span><span class="name-label">
        (
        {{ $item['mulai']->translatedFormat('d M Y') }}

        @if($item['mulai']->toDateString() != $item['selesai']->toDateString())
        s/d {{ $item['selesai']->translatedFormat('d M Y') }}
        @endif
        ) -
        {{ $item['nama'] }}
      </span>



    </div>
    @endforeach

  </div>


  <div class="footer">
    <div class="footer-line"></div>

    <div class="footer-content">
      <div class="footer-text">
        &copy; {{ date('Y') }} {{ config('app.name') }} - Sistem Manajemen Madrasah Diniyah
        <span class="footer-made">| Created by Izulula</span>
        <span class="footer-user">
          | User: {{ auth()->user()->name ?? 'Guest' }}
        </span>
      </div>
    </div>
  </div>

</body>


</html>