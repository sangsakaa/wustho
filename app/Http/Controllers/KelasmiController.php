<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class KelasmiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Kelasmi $kelasmi)
    {
        $dataJumlahPeserta = Kelasmi::query()
            ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_asrama')])
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->groupBy('kelasmi.id');

        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode')
            ->orderBy('periode')->get();
        $dataKelas = Kelas::query()
            ->select('kelas.kelas', 'kelas.id')
            ->get();
        $kelasMI = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('kelasmi.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('kelasmi.id,nama_kelas,ket_semester,kelas,periode,kuota,count(pesertakelas.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->groupBy(
                'kelasmi.id',
                'nama_kelas',
                'kelas',
                'kuota',
                'ket_semester',
                'periode',
                'jumlah_peserta_asrama'
            )
            ->orderBy('periode')
            ->orderBy('ket_semester')
            ->orderBy('kelas')
            ->get();
        // dd($kelasMI);
        return view(
            'kelas_mi/kelas_mi',
            [
                'kelasMI' => $kelasMI,
                'dataKelas' => $dataKelas,
                'dataPeriode' => $dataPeriode,

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataKelas = Kelas::all();
        return view('kelas_mi/addkelas_mi', ['dataKelas' => $dataKelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelas = new Kelasmi();
        $kelas->kelas_id = $request->kelas_id;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->periode_id = $request->periode_id;
        $kelas->kuota = $request->kuota;
        $kelas->save();
        return redirect('kelas_mi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kelasmi $kelasmi)

    {
        // dd($kelasmi);
        $anggota = Pesertakelas::where('kelasmi_id', $kelasmi->id)->count('kelasmi_id');
        $datakelasmi = $kelasmi->query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'kelasmi.kuota')
            ->find($kelasmi)->first();
        $dataKelas = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->select('siswa.nama_siswa', 'nis.nis', 'siswa.kota_asal', 'pesertakelas.id', 'kelas.kelas', 'kelasmi.nama_kelas')
        ->where('pesertakelas.kelasmi_id', $kelasmi->id);
        if (request('cari')) {
            $dataKelas->where(
                'nama_siswa',
                'like',
                '%' . request('cari') . '%'
            );
        }

        return view(
            'kelas_mi/pesertakelas',
            [
                'dataKelas' => $dataKelas->paginate(10),
                'datakelasmi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'hitung' => $anggota
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelasmi $kelasmi)
    {
        Kelasmi::destroy($kelasmi->id);
        return redirect()->back();
    }
    public function hapus(Pesertakelas $pesertakelas)
    {
        Pesertakelas::destroy($pesertakelas->id);
        return redirect()->back();
    }
}
