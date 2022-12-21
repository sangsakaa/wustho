<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Asrama;
use App\Models\Asramasiswa;
use App\Models\Pesertaasrama;
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
                "peserta_asrama.nama_asrama, sesikelas.tgl, COUNT(CASE WHEN keterangan = 'izin' OR keterangan = 'sakit' OR keterangan = 'alfa' THEN 1 END) AS tidak_hadir"
            )
            ->groupBy('peserta_asrama.nama_asrama', 'sesikelas.tgl')
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('sesikelas.tgl')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [now()->subDays(15)->toDateString(), now()->toDateString()])
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
        return view('dashboard', compact('datasetsAbsensi'));
    }
}
