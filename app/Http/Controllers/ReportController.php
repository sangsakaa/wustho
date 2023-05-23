<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function LapKehadiran()
    {
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'periode.id')
        ->first();
        // dd($kelasmi->id);
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->whereIn('absensikelas.keterangan', ['alfa', 'sakit'])
            ->groupBy('nama_kelas', 'nama_siswa', 'periode_id')
            ->select(
                'nama_kelas',
                'nama_siswa',
                'periode_id',
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 ELSE 0 END) as total_alfa'),
                DB::raw('SUM(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 ELSE 0 END) as total_sakit'),
                DB::raw('COUNT(pesertakelas.id) as total_data'),

            )
            ->orderBy('nama_kelas')
            ->orderBy('nama_siswa')
            ->where('kelasmi.periode_id', session('periode_id'))
        ->get();


        
        return view('laporan.kelas.kehadiran', [
           
            'kelasmi' => $kelasmi,
            
            'data' => $data

        ]);


    }
}
