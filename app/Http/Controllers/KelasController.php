<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dataKelas = Kelas::query()
            ->get();
        return view('kelas/kelas', ['DataKelas' => $dataKelas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periode = Periode::all();
        return view(
            'kelas/addkelas',
            [
                'periode' => $periode
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $kelas = new Kelas();
        $kelas->kelas = $request->kelas;
        $kelas->save();
        return redirect()->back();
    }
    
    public function edit(Kelas $kelas)
    {
        return view('kelas/editkelas', ['kelas' => $kelas]);
    }
    
    public function destroy(Kelas $kelas)
    {
        Kelas::destroy($kelas->id);
        return redirect()->back();
    }
    public function pesertakolektif(Kelasmi $kelasmi)
    {
        $kelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', $kelasmi->periode_id)
            ->select('kelasmi.id', 'nama_kelas', 'kelas.kelas', 'kelasmi.kuota', 'periode.periode', 'semester.ket_semester')
        ->get();
        $pesertaKelasPeriodeTerpilih = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', $kelasmi->periode_id)
            ->select('pesertakelas.siswa_id');
        $Datasiswa = Siswa::query()
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftJoinSub($pesertaKelasPeriodeTerpilih, 'peserta_kelas_periode_terpilih', function ($join) {
                $join->on('peserta_kelas_periode_terpilih.siswa_id', '=', 'siswa.id');
            })
            ->where('peserta_kelas_periode_terpilih.siswa_id', null)
            ->orderBy('jenis_kelamin')
            ->select('siswa.*', 'nis.nis', 'nis.tanggal_masuk', 'asrama.nama_asrama')
            ->orderBy('nis');
        if (request('cari')) {
            $Datasiswa->where(
                'nama_asrama',
                'like',
                '%' . request('cari') . '%'
            );
        };
        return view(
            'kelas_mi/pesertakolektif',
            [
                'Datasiswa' => $Datasiswa->get(),
                'kelas' => $kelas,
                'kelasmi' => $kelasmi
            ]
        );
    }
    public function StoreKolektif(Request $request)
    {
        foreach ($request->siswa as $siswa) {
            $peserta = new Pesertakelas();
            $peserta->siswa_id = $siswa;
            $peserta->kelasmi_id = $request->kelasmi_id;
            $peserta->save();
        }
        return redirect()->back();
    }
}