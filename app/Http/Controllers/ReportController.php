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
    public function LapKehadiran(Request $request)
    {
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
        ->first();
        
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('absensikelas.keterangan', 'alfa')
            ->groupBy('nama_kelas', 'nama_siswa') // Menambahkan kolom nama_siswa pada grup
            ->select('nama_kelas', 'nama_siswa', DB::raw('count(*) as total_alfa'), DB::raw('count(pesertakelas.id) as total_alfa')) // Menambahkan kolom nama_siswa pada select
            ->orderBy('nama_kelas')
            ->orderBy('nama_siswa')
            ->get();
        return view('laporan.kelas.kehadiran', [
           
            'kelasmi' => $kelasmi,
           
            'data' => $data

        ]);


    }
}
