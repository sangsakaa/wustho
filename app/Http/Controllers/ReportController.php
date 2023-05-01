<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Presensikelas;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf;

class ReportController
{
    public function LapKehadiran()
    {


        $lapKehadiranAsrama = Absensikelas::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select(
            'asrama.nama_asrama',
            
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 END) as hadir_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 END) as alfa_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "izin" THEN 1 END) as izin_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 END) as sakit_count'),
                DB::raw('COUNT(absensikelas.id) as total_count')
            )
            ->groupBy('asrama.nama_asrama',)
            ->get();
        // dd($lapKehadiranAsrama);
        $titlePeriode =
        Absensikelas::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('periode.periode', 'semester.ket_semester')
        ->first();
        $laporan = [];
        foreach ($lapKehadiranAsrama as $data) {
            $laporan[] = [
                'asrama' => $data->nama_asrama,
                'periode' => $data->periode,
                'semester' => $data->semester,
                'hadir' => $data->hadir_count / $data->total_count * 100,
                'alfa' => $data->alfa_count / $data->total_count * 100,
                'izin' => $data->izin_count / $data->total_count * 100,
                'sakit' => $data->sakit_count / $data->total_count * 100,
            ];
        }
        $lapKehadiranKelas = Absensikelas::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select(
                'kelasmi.nama_kelas',
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "hadir" THEN 1 END) as hadir_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "alfa" THEN 1 END) as alfa_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "izin" THEN 1 END) as izin_count'),
                DB::raw('COUNT(CASE WHEN absensikelas.keterangan = "sakit" THEN 1 END) as sakit_count'),
                DB::raw('COUNT(absensikelas.id) as total_count')
            )
            ->groupBy('kelasmi.nama_kelas')
            ->get();

        $laporanKelas = [];
        foreach ($lapKehadiranKelas as $data) {
            $laporanKelas[] = [
                'kelasmi' => $data->nama_kelas,
                'periode' => $data->periode,
                'semester' => $data->semester,
                'hadir' => $data->hadir_count / $data->total_count * 100,
                'alfa' => $data->alfa_count / $data->total_count * 100,
                'izin' => $data->izin_count / $data->total_count * 100,
                'sakit' => $data->sakit_count / $data->total_count * 100,
            ];
        }
        return view('laporan.kelas.kehadiran', compact(
            [


                'laporan',
                'laporanKelas',
                'titlePeriode'



            ]
        ));
    }
}
