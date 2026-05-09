<?php

namespace App\Http\Controllers;

use App\Models\Daftar_lulusan;
use App\Models\Kelasmi;
use App\Models\Nis;
use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $periodeId = session('periode_id');

        /*
        |--------------------------------------------------------------------------
        | STATISTIK SISWA
        |--------------------------------------------------------------------------
        */
        $siswaStats = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN siswa.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as laki,
                SUM(CASE WHEN siswa.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan,
                SUM(CASE WHEN nis.madrasah_diniyah = 'Ula' THEN 1 ELSE 0 END) as ula,
                SUM(CASE WHEN nis.madrasah_diniyah = 'Wustho' THEN 1 ELSE 0 END) as wustho,
                SUM(CASE WHEN nis.madrasah_diniyah = 'Ulya' THEN 1 ELSE 0 END) as ulya
            ")
            ->first();

        /*
        |--------------------------------------------------------------------------
        | SISWA PER KELAS
        |--------------------------------------------------------------------------
        */
        $dataSiswaPerKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->selectRaw('kelas.kelas, COUNT(*) as total')
            ->groupBy('kelas.kelas')
            ->orderBy('kelas.kelas')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | JENIS KELAMIN PER KELAS
        |--------------------------------------------------------------------------
        */
        $jenisKelamin = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->selectRaw("
                kelas.kelas,
                SUM(CASE WHEN siswa.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as laki,
                SUM(CASE WHEN siswa.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan
            ")
            ->groupBy('kelas.kelas')
            ->orderBy('kelas.kelas')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TAHUN MASUK
        |--------------------------------------------------------------------------
        */
        $tahunMasuk = Nis::query()
            ->selectRaw('YEAR(tanggal_masuk) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA MASUK
        |--------------------------------------------------------------------------
        */
        $masukData = Nis::query()
            ->selectRaw('YEAR(tanggal_masuk) as tahun, COUNT(*) as masuk')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        /*
        |--------------------------------------------------------------------------
        | DATA LULUS (PUNYA NOMOR IJAZAH)
        |--------------------------------------------------------------------------
        */
        $lulusData = Daftar_lulusan::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->whereNotNull('daftar_lulusan.nomor_ijazah')
            ->where('daftar_lulusan.nomor_ijazah', '!=', '')
            ->selectRaw('YEAR(nis.tanggal_masuk) as tahun, COUNT(*) as lulus')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        /*
        |--------------------------------------------------------------------------
        | GABUNG DATA MASUK + LULUS + BELUM LULUS
        |--------------------------------------------------------------------------
        */
        $allYears = $masukData->keys()
            ->merge($lulusData->keys())
            ->unique()
            ->sort()
            ->values();

        $grafikMasukLulus = collect();

        foreach ($allYears as $tahun) {
            $masuk = $masukData[$tahun]->masuk ?? 0;
            $lulus = $lulusData[$tahun]->lulus ?? 0;
            $belumLulus = max($masuk - $lulus, 0);

            $grafikMasukLulus->push([
                'tahun' => $tahun,
                'masuk' => $masuk,
                'lulus' => $lulus,
                'belum_lulus' => $belumLulus,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TITLE DASHBOARD
        |--------------------------------------------------------------------------
        */
        $TitleMadrasak = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->select(
                'periode.periode',
                'semester.ket_semester',
                'kelasmi.jenjang'
            )
            ->first();

        return view('dashboard', [
            'siswaStats' => $siswaStats,
            'dataSiswaPerKelas' => $dataSiswaPerKelas,
            'jenisKelamin' => $jenisKelamin,
            'tahunMasuk' => $tahunMasuk,
            'grafikMasukLulus' => $grafikMasukLulus,
            'TitleMadrasak' => $TitleMadrasak,
        ]);
    }
}
