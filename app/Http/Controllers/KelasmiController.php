<?php

namespace App\Http\Controllers;

use App\Models\Absensiguru;
use App\Models\Kelas;
use App\Models\Siswa;
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
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
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
            ->selectRaw('kelasmi.id,nama_kelas,jenjang,ket_semester,kelas,periode,kuota,count(pesertakelas.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->groupBy(
                'kelasmi.id',
                'nama_kelas',
                'kelas',
                'kuota',
                'ket_semester',
                'periode',
            'jumlah_peserta_asrama',
            'jenjang'
            )
            ->orderBy('periode')
            ->orderBy('ket_semester')
            ->orderBy('nama_kelas')
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
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderBy('periode')->get();
        $dataKelas = Kelas::all();
        return view(
            'kelas_mi/addkelas_mi',
            [
                'dataKelas' => $dataKelas,
                'dataPeriode' => $dataPeriode,
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
        $kelas = new Kelasmi();
        $kelas->kelas_id = $request->kelas_id;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->periode_id = session('periode_id');
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
        
        return view(
            'kelas_mi/pesertakelas',
            [
                'kelasmi' => $kelasmi,     
            ]
        );
    }
    public function editpesertakelas(Pesertakelas $pesertakelas, Kelasmi $kelasmi, Siswa $siswa)
    {

        $siswaKelas = $pesertakelas->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->where('siswa.id', $pesertakelas->siswa_id)->first();
        $DataKelas  = Kelasmi::query()
            ->select('nama_kelas', 'periode_id', 'id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        return view(
            'kelas_mi.editpesertakelas',
            [
                'DataKelas' => $DataKelas,
                'pesertakelas' => $pesertakelas,
                'kelasmi' => $kelasmi,
                'siswaKelas' => $siswaKelas,

            ]
        );
    }
    public function storepesertakelas(Request $request, Pesertakelas $pesertakelas)
    {

        Pesertakelas::where('id', $pesertakelas->id)
            ->update([
                'siswa_id' => $request->siswa_id,
                'kelasmi_id' => $request->kelasmi_id,
            ]);


        return redirect('/pesertakelas/' . $pesertakelas->kelasmi_id);
    }

    
    public function edit(Kelasmi $kelasmi)
    {
        return view(
            'kelas_mi/editkelasmi',
            [
                'kelasmi' => $kelasmi
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelasmi $kelasmi)
    {
        Kelasmi::where('id', $kelasmi->id)
            ->update([
                'kelas_id' => $request->kelas_id,
                'periode_id' => $request->periode_id,
                'kuota' => $request->kuota,
                'nama_kelas' => $request->nama_kelas,


            ]);
        return redirect('/kelas_mi')->with('update', 'pembaharuan data berhasil');
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
        return redirect()->back()->with('delete', 'anda berhasil mengahapus data ini');
    }
    public function hapus(Pesertakelas $pesertakelas)
    {
        Pesertakelas::destroy($pesertakelas->id);
        return redirect()->back();
    }
    public function rekapKelas()
    {
        return view('kelas_mi.rekap_kelas_mi');
    }
}