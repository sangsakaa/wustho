<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Presensikelas;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function LapKehadiran()
    {
        $lapKehadiran = Absensikelas::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            // ->where('kelasmi.periode_id', session('periode_id'))
            ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.semester', DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 END) as hadir_count'), DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 END) as alfa_count'), DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "izin" THEN 1 END) as izin_count'), DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 END) as sakit_count'))
            ->groupBy('kelasmi.nama_kelas', 'periode.periode', 'semester.semester')
            ->get();


        return view('laporan.kelas.kehadiran', compact(
            [
                'lapKehadiran'

            ]
        ));
    }
}
