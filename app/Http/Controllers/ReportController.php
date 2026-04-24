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

        // ❌ HAPUS daysUntil (tidak perlu)
        $start = $bulan->copy()->startOfMonth()->toDateString();
        $end   = $bulan->copy()->endOfMonth()->toDateString();

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'periode.id', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->first();

        // =====================
        // DATA KELAS (OPTIMIZED)
        // =====================
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')

            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$start, $end])

            ->groupBy('nama_kelas')
            ->select(
            'nama_kelas',
            DB::raw('COUNT(DISTINCT pesertakelas.id) as total_peserta_kelas'),
            DB::raw('COUNT(DISTINCT absensikelas.sesikelas_id) as total_sesikelas'),

            DB::raw('SUM(CASE WHEN keterangan="hadir" THEN 1 ELSE 0 END) as total_kehadiran'),
            DB::raw('SUM(CASE WHEN keterangan="sakit" THEN 1 ELSE 0 END) as total_sakit'),
            DB::raw('SUM(CASE WHEN keterangan="izin" THEN 1 ELSE 0 END) as total_izin'),
            DB::raw('SUM(CASE WHEN keterangan="alfa" THEN 1 ELSE 0 END) as total_alfa'),

            // 🔥 persentase langsung dari DB
            DB::raw('ROUND(
                (SUM(CASE WHEN keterangan="hadir" THEN 1 ELSE 0 END) * 100) /
                NULLIF(COUNT(absensikelas.id),0)
            ,2) as presentase_hadir')
            )
            ->orderByDesc('presentase_hadir')
            ->get();

        // =====================
        // DATA ASRAMA (OPTIMIZED)
        // =====================
        $dataDetail = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')

            ->where('asramasiswa.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$start, $end])

            ->groupBy('nama_asrama')
            ->select(
                'nama_asrama',
            DB::raw('COUNT(DISTINCT pesertaasrama.id) as total_peserta'),

            DB::raw('SUM(CASE WHEN keterangan="hadir" THEN 1 ELSE 0 END) as total_kehadiran'),
            DB::raw('SUM(CASE WHEN keterangan="sakit" THEN 1 ELSE 0 END) as total_sakit'),
            DB::raw('SUM(CASE WHEN keterangan="izin" THEN 1 ELSE 0 END) as total_izin'),
            DB::raw('SUM(CASE WHEN keterangan="alfa" THEN 1 ELSE 0 END) as total_alfa'),

            DB::raw('ROUND(
                (SUM(CASE WHEN keterangan="alfa" THEN 1 ELSE 0 END) * 100) /
                NULLIF(COUNT(absensikelas.id),0)
            ,2) as presentase_alfa')
        )
            ->orderByDesc('presentase_alfa')
            ->get();

        // =====================
        // 🔥 SUMMARY BARU
        // =====================
        $summary = [
            'total_hadir' => $data->sum('total_kehadiran'),
            'total_sakit' => $data->sum('total_sakit'),
            'total_izin'  => $data->sum('total_izin'),
            'total_alfa'  => $data->sum('total_alfa'),

            'rata_kehadiran' => round($data->avg('presentase_hadir'), 2),

            'kelas_terbaik' => $data->first()?->nama_kelas,
            'kelas_terburuk' => $data->last()?->nama_kelas,
        ];

        return view('laporan.kelas.kehadiran', compact(
            'kelasmi',
            'data',
            'dataDetail',
            'bulan',
            'summary'
        ));
    }
}
