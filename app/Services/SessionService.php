<?php

namespace App\Services;

use App\Models\Periode;
use App\Models\Sesikelas;
use Carbon\Carbon;

class SessionService
{
  public function today()
  {
    $periode = Periode::active()->firstOrFail();

    return Sesikelas::query()

      ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')

      ->select([
        'sesikelas.id',
        'sesikelas.tgl',
        'sesikelas.status',
        'sesikelas.kelasmi_id',
        'kelasmi.nama_kelas',
      ])

      // jumlah hadir
      ->selectSub(function ($query) {

        $query->from('absensikelas')
          ->selectRaw('COUNT(DISTINCT pesertakelas_id)')
          ->whereColumn(
            'absensikelas.sesikelas_id',
            'sesikelas.id'
          );
      }, 'hadir')

      // jumlah peserta
      ->selectSub(function ($query) {

        $query->from('pesertakelas')
          ->selectRaw('COUNT(*)')
          ->whereColumn(
            'pesertakelas.kelasmi_id',
            'sesikelas.kelasmi_id'
          );
      }, 'peserta')

      ->where('kelasmi.periode_id', $periode->id)

      ->whereDate('sesikelas.tgl', Carbon::today())

      ->orderBy('kelasmi.nama_kelas')

      ->get()

      ->map(function ($item) {

        $hadir = (int)$item->hadir;
        $peserta = (int)$item->peserta;

        return [

          'id' => $item->id,

          'kelas' => $item->nama_kelas,

          'tanggal' => $item->tgl,

          'status' => $item->status,

          'hadir' => $hadir,

          'peserta' => $peserta,

          'belum_absen' => max($peserta - $hadir, 0),

          'progress' => $peserta
            ? round(($hadir / $peserta) * 100)
            : 0

        ];
      });
  }
}
