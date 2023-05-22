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
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->select('periode.id', 'periode.periode', 'semester.ket_semester')
        ->where('periode.id', session('periode_id'))
        ->first();
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
        ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));
        $dataAbsensi = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->selectRaw(
                "pesertakelas.id, peserta_asrama.nama_asrama, siswa.nama_siswa, siswa.jenis_kelamin, COUNT(CASE WHEN keterangan = 'hadir' THEN 1 END) AS hadir, COUNT(CASE WHEN keterangan = 'izin' THEN 1 END) AS izin, COUNT(CASE WHEN keterangan = 'sakit' THEN 1 END) AS sakit, COUNT(CASE WHEN keterangan = 'alfa' THEN 1 END) AS alfa"
            )
            ->groupBy('pesertakelas.id', 'peserta_asrama.nama_asrama',  'siswa.nama_siswa', 'siswa.jenis_kelamin')

        ->orderBy('siswa.nama_siswa');
        if ($kelasmi) {
            $dataAbsensi->where('kelasmi.id', $kelasmi->id);
        } else {
            $dataAbsensi->where('kelasmi.periode_id', session('periode_id'));
        }
        $data = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('absensikelas.keterangan', 'alfa')
            ->groupBy('nama_kelas', 'nama_siswa') // Menambahkan kolom nama_siswa pada grup
            ->select('nama_kelas', 'nama_siswa', DB::raw('count(*) as total_alfa')) // Menambahkan kolom nama_siswa pada select
            ->orderBy('nama_kelas')
            ->orderBy('nama_siswa')
            ->get();
        return view('laporan.kelas.kehadiran', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataAbsensi' => $dataAbsensi->get(),
            'periode' => $periode,
            'data' => $data

        ]);


    }
}
