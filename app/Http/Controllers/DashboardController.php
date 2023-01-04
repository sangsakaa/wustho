<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Asrama;
use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;
use App\Models\Sesikelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
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
        ->select(DB::raw('count(*) as jumlah'), 'jenis_kelamin')
        ->groupBy('jenis_kelamin')
        ->get()
        ->toArray();
        $data = Siswa::all();
        $countLakiLaki = 0;
        $countPerempuan = 0;
        foreach ($data as $item) {
            if ($item->jenis_kelamin == 'L') {
                $countLakiLaki++;
            } elseif ($item->jenis_kelamin == 'P') {
                $countPerempuan++;
            }
        }
        return view('dashboard', compact('datasetsAbsensi', 'dataSiswa', 'countLakiLaki', 'countPerempuan'));
    }
}
