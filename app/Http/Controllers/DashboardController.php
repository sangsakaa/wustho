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
                SUM(CASE WHEN siswa.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan
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
        | JENIS KELAMIN
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
        | MASUK VS LULUS
        |--------------------------------------------------------------------------
        */
        $masukData = Nis::query()
            ->selectRaw('YEAR(tanggal_masuk) as tahun, COUNT(*) as masuk')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        $lulusData = Daftar_lulusan::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->whereNotNull('nomor_ijazah')
            ->where('nomor_ijazah', '!=', '')
            ->selectRaw('YEAR(nis.tanggal_masuk) as tahun, COUNT(*) as lulus')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        $allYears = $masukData->keys()
            ->merge($lulusData->keys())
            ->unique()
            ->sort();

        $grafikMasukLulus = collect();

        foreach ($allYears as $tahun) {
            $masuk = $masukData[$tahun]->masuk ?? 0;
            $lulus = $lulusData[$tahun]->lulus ?? 0;

            $grafikMasukLulus->push([
                'tahun' => $tahun,
                'masuk' => $masuk,
                'lulus' => $lulus,
                'belum_lulus' => max($masuk - $lulus, 0),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TIMELINE AKADEMIK
        |--------------------------------------------------------------------------
        */
        $totalSiswa = Siswa::count();
        $totalPeserta = Pesertakelas::count();
        $totalLulus = Daftar_lulusan::whereNotNull('nomor_ijazah')->count();

        $timeline = [
            [
                'icon' => '👤',
                'title' => 'Registrasi',
                'count' => $totalSiswa,
                'progress' => 100,
                'color' => 'blue',
            ],
            [
                'icon' => '📚',
                'title' => 'Kelas Aktif',
                'count' => $totalPeserta,
                'progress' => round(($totalPeserta / max($totalSiswa, 1)) * 100),
                'color' => 'violet',
            ],
            [
                'icon' => '🎓',
                'title' => 'Kelulusan',
                'count' => $totalLulus,
                'progress' => round(($totalLulus / max($totalSiswa, 1)) * 100),
                'color' => 'emerald',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */
        $TitleMadrasak = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->select('periode.periode', 'semester.ket_semester', 'kelasmi.jenjang')
            ->first();

        return view('dashboard', compact(
            'siswaStats',
            'dataSiswaPerKelas',
            'jenisKelamin',
            'tahunMasuk',
            'grafikMasukLulus',
            'timeline',
            'TitleMadrasak'
        ));
    }
}
