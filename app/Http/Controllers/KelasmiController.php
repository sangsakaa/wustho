<?php

namespace App\Http\Controllers;


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


    public function index()
    {
        // 🔹 Subquery jumlah peserta
        $dataJumlahPeserta = DB::table('pesertakelas')
            ->select('kelasmi_id', DB::raw('COUNT(*) as jumlah_peserta'))
            ->groupBy('kelasmi_id');

        // 🔹 Data Kelas MI
        $kelasMI = DB::table('kelasmi')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftJoinSub($dataJumlahPeserta, 'jp', function ($join) {
                $join->on('kelasmi.id', '=', 'jp.kelasmi_id');
            })
            ->select(
                'kelasmi.id',
                'kelasmi.nama_kelas',
                'kelasmi.jenjang',
                'kelas.kelas',
                'periode.periode',
                'semester.ket_semester',
                'kelasmi.kuota',
                DB::raw('COALESCE(jp.jumlah_peserta,0) as jumlah_peserta')
        )
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('periode')
            ->orderBy('ket_semester')
            ->orderBy('nama_kelas')
            ->get();

        // 🔹 Data tambahan
        $dataKelas = Kelas::select('id', 'kelas')->get();

        $dataPeriode = Periode::join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderBy('periode')
            ->get();

        // 🔥 Dashboard Data
        $totalKelas = $kelasMI->count();
        $totalSiswa = DB::table('pesertakelas')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->count();
        $totalGuru  = DB::table('guru')->count(); // pastikan tabel ada

        return view('kelas_mi.kelas_mi', compact(
            'kelasMI',
            'dataKelas',
            'dataPeriode',
            'totalKelas',
            'totalSiswa',
            'totalGuru'
        ));
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
        $request->validate([
            'siswa_id'   => 'required',
            'kelasmi_id' => 'required',
        ]);

        $pesertakelas->update([
            'siswa_id'   => $request->siswa_id,
            'kelasmi_id' => $request->kelasmi_id,
        ]);

        return redirect('/pesertakelas/' . $request->kelasmi_id)
            ->with('success', 'Data peserta kelas berhasil diperbarui');
    }


    public function edit(Kelasmi $kelasmi)
    {
        return view('kelas_mi/editkelasmi', [
            'kelasmi' => $kelasmi
        ]);
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