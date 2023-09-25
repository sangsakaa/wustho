<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use App\Models\Sesikelas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function LapKehadiran(Request $request)
    {
        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'periode.id', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
        ->first();
        // dd($kelasmi->id);
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            // ->whereIn('absensikelas.keterangan', ['alfa', 'sakit'])
            ->groupBy('nama_kelas', 'periode_id')
            ->select(
                'nama_kelas',
                // 'nama_siswa',
                'periode_id',
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) as total_alfa'),
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) as total_sakit'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "izin" THEN 1 ELSE 0 END) as total_izin'),
            DB::raw('COUNT(DISTINCT pesertakelas.id) as total_peserta_kelas'),
                DB::raw('SUM(CASE WHEN absensikelas.keterangan IN ("hadir") THEN 1 ELSE 0 END) as total_kehadiran'),
                DB::raw('COUNT(DISTINCT absensikelas.sesikelas_id) as total_sesikelas')
            )
            ->orderBy('nama_kelas')
            ->orderBy('nama_siswa')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
        ->get();
        $dataDetail =
        Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
        ->join('asramasiswa', 'asramasiswa.id', 'pesertaasrama.asramasiswa_id')
        ->join('asrama', 'asrama.id', 'asramasiswa.asrama_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->groupBy('nama_asrama', 'kelasmi.periode_id', 'asramasiswa.periode_id')
        ->select(
            'nama_asrama',
            'kelasmi.periode_id',
            'asramasiswa.periode_id',
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) as total_alfa'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) as total_sakit'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan = "izin" THEN 1 ELSE 0 END) as total_izin'),
            DB::raw('COUNT(DISTINCT pesertaasrama.id) as total_peserta_kelas'),
            DB::raw('SUM(CASE WHEN absensikelas.keterangan IN ("hadir") THEN 1 ELSE 0 END) as total_kehadiran'),
            DB::raw('COUNT(DISTINCT absensikelas.sesikelas_id) as total_sesikelas')
        )
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
            ->get();
        
        return view('laporan.kelas.kehadiran', [

            'kelasmi' => $kelasmi, 
            'data' => $data,
            'dataDetail' => $dataDetail,
            'bulan' => $bulan,
            'periodeBulan' => $periodeBulan

        ]);


    }
}
