<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
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

        $dataAngkatan = Nis::select('madrasah_diniyah', 'tanggal_masuk')->get()->groupBy('madrasah_diniyah')->map(function ($item) {
            return $item->groupBy('tanggal_masuk')->count();
        });

        $tglAwal = Sesikelas::query()
            ->join('absensikelas', 'absensikelas.sesikelas_id', '=', 'sesikelas.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->selectRaw('DISTINCT(tgl)')
            ->orderByDesc('tgl')
            ->take(15)
            ->get()
            ->last();
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
                "peserta_asrama.nama_asrama, sesikelas.tgl, COUNT(CASE WHEN keterangan = 'izin' OR keterangan = 'sakit' OR keterangan = 'alfa' THEN 1 END) / COUNT(absensikelas.id) * 100 AS tidak_hadir"
            )
            ->groupBy('peserta_asrama.nama_asrama', 'sesikelas.tgl')
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('sesikelas.tgl')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$tglAwal?->tgl ?? now()->toDateString(), now()->toDateString()])
            ->get();
        $dataAbsensi = $dataAbsensi->groupBy(function ($item) {
                return $item->nama_asrama == null ? "1" : $item->nama_asrama;
            });
        $datasetsAbsensi = $dataAbsensi->map(function ($data, $nama_asrama) {
            return [
                'label' => $nama_asrama,
                'data' => $data,
                'borderColor' => fake()->rgbCssColor(),
            ];
        })->values();
        $dataSiswa = DB::table('siswa')
            ->select(DB::raw('count(*) as jumlah'), 'jenis_kelamin',)
            ->groupBy('jenis_kelamin')
            
        ->get()
        ->toArray();
        // dd($dataSiswa);
        $data = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            // ->whereNot('madrasah_diniyah', "Ula")
            // ->whereNot('madrasah_diniyah', "Wustho")
            ->get();
        $countLakiLaki = 0;
        $countPerempuan = 0;
        foreach ($data as $item) {
            if ($item->jenis_kelamin == 'L') {
                $countLakiLaki++;
            } elseif ($item->jenis_kelamin == 'P') {
                $countPerempuan++;
            }
        }
        $ula = 0;
        $wustho = 0;
        $ulya = 0;
        foreach ($data as $item) {
            if ($item->madrasah_diniyah == 'Ula') {
                $ula++;
            } elseif ($item->madrasah_diniyah == 'Wustho') {
                $wustho++;
            } elseif ($item->madrasah_diniyah == 'Ulya') {
                $ulya++;
            }

        }
        $dataSiswaPeriode = Pesertakelas::query()
        ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('nis.madrasah_diniyah', 'wustho')
        ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy('kelasmi.periode_id', 'semester.semester', 'periode.periode', 'semester.ket_semester')
            ->selectRaw('kelasmi.periode_id, semester.semester, semester.ket_semester,periode.periode, count(*) as total_siswa')
        ->first();
        $dataSiswaPerKelas = Pesertakelas::query()
        ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('nis.madrasah_diniyah', 'wustho')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->groupBy('kelasmi.kelas_id', 'kelas.kelas', 'semester.semester', 'periode.periode', 'semester.ket_semester')
        ->selectRaw('kelasmi.kelas_id,kelas.kelas,semester.semester,semester.ket_semester,periode.periode, count(*) as total_siswa')
        ->get();
        $TitleKelas = Pesertakelas::query()
        ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('nis.madrasah_diniyah', 'wustho')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->groupBy('kelasmi.kelas_id', 'kelas.kelas', 'semester.semester', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->selectRaw('kelasmi.kelas_id,semester.semester,kelasmi.nama_kelas,semester.ket_semester,periode.periode, count(*) as total_siswa')
        ->get();
        $jenisKelamin = Pesertakelas::query()
        ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('nis.madrasah_diniyah', 'wustho')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->groupBy('kelasmi.kelas_id', 'kelas.kelas', 'semester.semester', 'siswa.jenis_kelamin', 'periode.periode', 'semester.ket_semester')
        ->selectRaw('kelasmi.kelas_id,semester.semester,kelas.kelas,siswa.jenis_kelamin,semester.ket_semester,periode.periode, count(*) as total_siswa')
        ->get();
        $tahunMasuk = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            // ->where('nis.madrasah_diniyah', 'Wustho')
            ->groupBy(DB::raw('YEAR(nis.tanggal_masuk)'))
        ->selectRaw('YEAR(nis.tanggal_masuk) as tahun_masuk, count(*) as total_siswa')
        ->get();

        // dd($tahunMasuk);



        return view('dashboard', compact(
            [
                'datasetsAbsensi',
                'dataSiswa',
                'countLakiLaki',
                'countPerempuan',
                'ula', 'wustho', 'ulya',
                'data',
                'dataAngkatan',
                'dataSiswaPeriode',
                'dataSiswaPerKelas',
                'TitleKelas',
                'jenisKelamin',
                'tahunMasuk'
            ]
        ));
    }
}
