<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use App\Models\Presensiasrama;
use Illuminate\Support\Carbon;




class RekapAsamaController
{
    public function RekapHarian(Request $request)
    {

        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();

        $pesertaAsramaPeriodeTerpilih = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('pesertaasrama.id as pesertaasrama_id','asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        $dataPresensiAsrama = Presensiasrama::query()
            ->join('sesiasrama', 'sesiasrama.id', '=', 'presensiasrama.sesiasrama_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('pesertaasrama', 'pesertaasrama.id', '=', 'presensiasrama.pesertaasrama_id')
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->joinSub($pesertaAsramaPeriodeTerpilih, 't', function ($join) {
                $join->on('t.pesertaasrama_id', '=', 'pesertaasrama.id');
            })
            ->select('t.nama_asrama',  'siswa.nama_siswa', 'presensiasrama.keterangan', 'kegiatan.kegiatan')
            ->where('sesiasrama.tanggal', $tgl->toDateString())
            ->orderBy('kegiatan.kegiatan')
            ->orderBy('t.nama_asrama')
            ->orderBy('presensiasrama.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->get();

        $rekapAbsensi = $dataPresensiAsrama
            ->groupBy('kegiatan')
            ->map(function ($item) {
                return $item
                    ->groupBy('nama_asrama')
                    ->map(function ($data) {
                        $absensi = $data->where('keterangan', '!=', 'hadir');
                        $tidakHadir = $absensi->count();
                        $total = $data->count();
                        $hadir = $total - $tidakHadir;
                        $absensi = $tidakHadir === 0 ? collect() : $absensi;

                        return [
                            'hadir' => $hadir,
                            'tidakHadir' => $tidakHadir,
                            'total' => $total,
                            'persentase' => $hadir / $total * 100,
                            'absensi' => $absensi,
                            'row' => $tidakHadir ? $tidakHadir : 1,
                        ];
                    });
            });

        return view('presensi.asrama.rekapitulasi', [
            'rekapAbsensi' => $rekapAbsensi,
            'tgl' => $tgl,
        ]);
    }
}
