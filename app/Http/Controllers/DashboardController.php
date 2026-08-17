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
        | PERIODE AKTIF
        |--------------------------------------------------------------------------
        */

        $periodeAktif = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->select([
                'periode.id',
                'periode.periode',
                'semester.ket_semester',
                'kelasmi.jenjang',
            ])
            ->first();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK SISWA PERIODE AKTIF
        |--------------------------------------------------------------------------
        */
        $TitleMadrasak = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->select([
                'periode.periode',
                'semester.ket_semester',
                'kelasmi.jenjang',
            ])
            ->first();

        $siswaStats = Pesertakelas::query()
            ->join(
                'siswa',
                'siswa.id',
                '=',
                'pesertakelas.siswa_id'
            )
            ->join(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->where(
                'kelasmi.periode_id',
                $periodeId
            )
            ->selectRaw("
                COUNT(DISTINCT siswa.id) as total,

                COUNT(
                    DISTINCT CASE
                        WHEN siswa.jenis_kelamin = 'L'
                        THEN siswa.id
                    END
                ) as laki,

                COUNT(
                    DISTINCT CASE
                        WHEN siswa.jenis_kelamin = 'P'
                        THEN siswa.id
                    END
                ) as perempuan
            ")
            ->first();

        /*
        |--------------------------------------------------------------------------
        | SISWA PER KELAS
        |--------------------------------------------------------------------------
        */

        $dataSiswaPerKelas = Pesertakelas::query()
            ->join(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->join(
                'kelas',
                'kelas.id',
                '=',
                'kelasmi.kelas_id'
            )
            ->where(
                'kelasmi.periode_id',
                $periodeId
            )
            ->select([
                'kelas.kelas',
            ])
            ->selectRaw(
                'COUNT(DISTINCT pesertakelas.siswa_id) as total'
            )
            ->groupBy('kelas.kelas')
            ->orderBy('kelas.kelas')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | JENIS KELAMIN PER KELAS
        |--------------------------------------------------------------------------
        */

        $jenisKelamin = Pesertakelas::query()
            ->join(
                'siswa',
                'siswa.id',
                '=',
                'pesertakelas.siswa_id'
            )
            ->join(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->join(
                'kelas',
                'kelas.id',
                '=',
                'kelasmi.kelas_id'
            )
            ->where(
                'kelasmi.periode_id',
                $periodeId
            )
            ->select([
                'kelas.kelas',
            ])
            ->selectRaw("
                COUNT(
                    DISTINCT CASE
                        WHEN siswa.jenis_kelamin = 'L'
                        THEN siswa.id
                    END
                ) as laki,

                COUNT(
                    DISTINCT CASE
                        WHEN siswa.jenis_kelamin = 'P'
                        THEN siswa.id
                    END
                ) as perempuan
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
            ->whereNotNull('tanggal_masuk')
            ->selectRaw(
                'YEAR(tanggal_masuk) as tahun'
            )
            ->selectRaw(
                'COUNT(DISTINCT siswa_id) as total'
            )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SISWA MASUK
        |--------------------------------------------------------------------------
        */

        $masukData = Nis::query()
            ->whereNotNull('tanggal_masuk')
            ->selectRaw(
                'YEAR(tanggal_masuk) as tahun'
            )
            ->selectRaw(
                'COUNT(DISTINCT siswa_id) as masuk'
            )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        /*
        |--------------------------------------------------------------------------
        | SISWA LULUS
        |--------------------------------------------------------------------------
        */

        $lulusData = Daftar_lulusan::query()
            ->join(
                'pesertakelas',
                'pesertakelas.id',
                '=',
                'daftar_lulusan.pesertakelas_id'
            )
            ->join(
                'siswa',
                'siswa.id',
                '=',
                'pesertakelas.siswa_id'
            )
            ->join(
                'nis',
                'nis.siswa_id',
                '=',
                'siswa.id'
            )
            ->whereNotNull(
                'daftar_lulusan.nomor_ijazah'
            )
            ->where(
                'daftar_lulusan.nomor_ijazah',
                '!=',
                ''
            )
            ->whereNotNull(
                'nis.tanggal_masuk'
            )
            ->selectRaw(
                'YEAR(nis.tanggal_masuk) as tahun'
            )
            ->selectRaw(
                'COUNT(DISTINCT siswa.id) as lulus'
            )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->keyBy('tahun');

        /*
        |--------------------------------------------------------------------------
        | GRAFIK MASUK VS LULUS
        |--------------------------------------------------------------------------
        */

        $allYears = $masukData
            ->keys()
            ->merge($lulusData->keys())
            ->unique()
            ->sort()
            ->values();

        $grafikMasukLulus = $allYears->map(
            function ($tahun) use (
                $masukData,
                $lulusData
            ) {

                $masuk = $masukData[$tahun]->masuk ?? 0;

                $lulus = $lulusData[$tahun]->lulus ?? 0;

                return [
                    'tahun' => $tahun,
                    'masuk' => $masuk,
                    'lulus' => $lulus,
                    'belum_lulus' => max(
                        $masuk - $lulus,
                        0
                    ),
                ];
            }
        );

        /*
        |--------------------------------------------------------------------------
        | TIMELINE AKADEMIK
        |--------------------------------------------------------------------------
        */

        $totalSiswa = (int) (
            $siswaStats->total ?? 0
        );

        $totalPeserta = Pesertakelas::query()
            ->join(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->where(
                'kelasmi.periode_id',
                $periodeId
            )
            ->distinct('pesertakelas.siswa_id')
            ->count('pesertakelas.siswa_id');

        $totalLulus = Daftar_lulusan::query()
            ->join(
                'pesertakelas',
                'pesertakelas.id',
                '=',
                'daftar_lulusan.pesertakelas_id'
            )
            ->join(
                'kelasmi',
                'kelasmi.id',
                '=',
                'pesertakelas.kelasmi_id'
            )
            ->where(
                'kelasmi.periode_id',
                $periodeId
            )
            ->whereNotNull(
                'daftar_lulusan.nomor_ijazah'
            )
            ->where(
                'daftar_lulusan.nomor_ijazah',
                '!=',
                ''
            )
            ->distinct(
                'pesertakelas.siswa_id'
            )
            ->count(
                'pesertakelas.siswa_id'
            );

        $timeline = [

            [
                'title' => 'Siswa Terdaftar',
                'count' => $totalSiswa,
                'progress' => 100,
                'color' => 'blue',
            ],

            [
                'title' => 'Siswa Aktif',
                'count' => $totalPeserta,
                'progress' => $totalSiswa > 0
                    ? round(
                        ($totalPeserta / $totalSiswa) * 100
                    )
                    : 0,
                'color' => 'violet',
            ],

            [
                'title' => 'Siswa Lulus',
                'count' => $totalLulus,
                'progress' => $totalSiswa > 0
                    ? round(
                        ($totalLulus / $totalSiswa) * 100
                    )
                    : 0,
                'color' => 'emerald',
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'siswaStats',
                'dataSiswaPerKelas',
                'jenisKelamin',
                'tahunMasuk',
                'grafikMasukLulus',
                'timeline',
                'periodeAktif',
                'TitleMadrasak'

            )
        );
    }
}
