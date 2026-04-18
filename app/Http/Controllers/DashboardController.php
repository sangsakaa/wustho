<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Nis;
use App\Models\Pesertaasrama;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Models\Siswa;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodeId = session('periode_id');

        // ======================
        // ANGKATAN
        // ======================
        $dataAngkatan = Nis::query()
            ->selectRaw('madrasah_diniyah, YEAR(tanggal_masuk) as tahun, COUNT(*) as total')
            ->groupBy('madrasah_diniyah', 'tahun')
            ->get()
            ->groupBy('madrasah_diniyah');

        // ======================
        // SISWA (GENDER & MADIN)
        // ======================
        $siswaStats = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) as laki,
            SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan,
            SUM(CASE WHEN madrasah_diniyah = 'Ula' THEN 1 ELSE 0 END) as ula,
            SUM(CASE WHEN madrasah_diniyah = 'Wustho' THEN 1 ELSE 0 END) as wustho,
            SUM(CASE WHEN madrasah_diniyah = 'Ulya' THEN 1 ELSE 0 END) as ulya
        ")
            ->first();

        // ======================
        // SISWA PER PERIODE
        // ======================
        $dataSiswaPeriode = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->selectRaw('periode.periode, semester.ket_semester, COUNT(*) as total')
            ->groupBy('periode.periode', 'semester.ket_semester')
            ->first();

        // ======================
        // SISWA PER KELAS
        // ======================
        $dataSiswaPerKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->selectRaw('kelas.kelas, COUNT(*) as total')
            ->groupBy('kelas.kelas')
            ->get();

        // ======================
        // JENIS KELAMIN PER KELAS
        // ======================
        $jenisKelamin = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->selectRaw("
            kelas.kelas,
            SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) as laki,
            SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan
        ")
            ->groupBy('kelas.kelas')
            ->get();

        // ======================
        // TAHUN MASUK
        // ======================
        $tahunMasuk = Nis::query()
            ->selectRaw('YEAR(tanggal_masuk) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->get();

        // ======================
        // TITLE MADRASAH
        // ======================
        $TitleMadrasak = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->select('periode.periode', 'semester.ket_semester', 'kelasmi.jenjang')
            ->first();

        return view('dashboard', [
            'dataAngkatan' => $dataAngkatan,
            'siswaStats' => $siswaStats,
            'dataSiswaPeriode' => $dataSiswaPeriode,
            'dataSiswaPerKelas' => $dataSiswaPerKelas,
            'jenisKelamin' => $jenisKelamin,
            'tahunMasuk' => $tahunMasuk,
            'TitleMadrasak' => $TitleMadrasak,
        ]);
    }
}
