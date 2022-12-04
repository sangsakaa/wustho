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

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        $dataAbsensiKelas = Presensiasrama::query()
            ->join('sesiasrama', 'sesiasrama.id', '=', 'presensiasrama.sesiasrama_id')
            ->join('pesertaasrama', 'pesertaasrama.id', '=', 'presensiasrama.pesertaasrama_id')
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->joinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->select('peserta_asrama.nama_asrama',  'siswa.nama_siswa', 'presensiasrama.keterangan')
            ->where('sesiasrama.tanggal', $tgl->toDateString())
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('presensiasrama.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->get();

        $absensiGrup = $dataAbsensiKelas
            ->where('keterangan', '!=', 'hadir')
            ->groupBy('nama_asrama')
            ->map(function ($item, $key) {
                return $item
                    ->groupBy('nama_kelas');
            });

        $rekapAbsensi = $dataAbsensiKelas
            ->groupBy('nama_asrama')
            ->map(function ($item, $nama_asrama) use ($absensiGrup) {
                return $item
                    ->groupBy('nama_kelas')
                    ->map(function ($item, $nama_kelas) use ($absensiGrup, $nama_asrama) {
                        $nullAbsensi =  new Absensikelas([
                            'nama_asrama' => $nama_asrama,
                            'nama_kelas' => $nama_kelas,
                            'nama_siswa' => '-',
                            'keterangan' => '-'
                        ]);
                        $total = $item->count();
                        $hadir = $item->where('keterangan', 'hadir')->count();
                        $tidakHadir = $total - $hadir;
                        $absensi = $tidakHadir === 0 ? collect([$nullAbsensi]) : $absensiGrup[$nama_asrama][$nama_kelas];
                        return [
                            'hadir' => $hadir,
                            'tidakHadir' => $tidakHadir,
                            'total' => $total,
                            'persentase' => $hadir / $total * 100,
                            'absensi' => $absensi,
                            'row' => $absensi->count(),
                        ];
                    })
                    ->filter();
            });

        // dd($absensiGrup, $rekapAbsensi);

        return view('presensi.asrama.rekapitulasi', [

            'rekapAbsensi' => $rekapAbsensi,
            'tgl' => $tgl,
        ]); 
    }
}
