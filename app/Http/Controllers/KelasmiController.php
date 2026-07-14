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
        $kelas = Kelas::orderBy('kelas')->get();

        $periode = Periode::orderBy('periode', 'desc')
            ->orderBy('semester_id')
            ->get();

        return view('kelas_mi.editkelasmi', [
            'kelasmi' => $kelasmi,
            'kelas'   => $kelas,
            'periode' => $periode,
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
    public function generatePeriodeBerikutnya(Request $request)
    {
        try {

            $totalKelas = 0;
            $totalPeserta = 0;
            $totalSudahAda = 0;
            $totalLulus = 0;

            $periodeTujuan = null;

            DB::transaction(function () use (
                $request,
                &$periodeTujuan,
                &$totalKelas,
                &$totalPeserta,
                &$totalSudahAda,
                &$totalLulus
            ) {

                /*
            |--------------------------------------------------------------------------
            | PERIODE AKTIF
            |--------------------------------------------------------------------------
            */
                $periodeAktif = Periode::where('is_active', 1)->first();

                if (!$periodeAktif) {
                    throw new \Exception('Periode aktif tidak ditemukan.');
                }

                /*
            |--------------------------------------------------------------------------
            | MODE GENERATE
            |--------------------------------------------------------------------------
            */
                $mode = $request->mode ?? 'auto';

                if ($mode === 'custom') {

                    $periodeTujuan = Periode::find($request->periode_tujuan);
                } else {

                    /*
                |--------------------------------------------------------------------------
                | AUTO MODE
                |--------------------------------------------------------------------------
                */
                    if ($periodeAktif->semester_id == 1) {

                        $periodeTujuan = Periode::where('periode', $periodeAktif->periode)
                            ->where('semester_id', 2)
                            ->first();
                    } else {

                        [$tahunAwal, $tahunAkhir] = explode('/', $periodeAktif->periode);

                        $periodeBaru =
                            ((int)$tahunAwal + 1) .
                            '/' .
                            ((int)$tahunAkhir + 1);

                        $periodeTujuan = Periode::where('periode', $periodeBaru)
                            ->where('semester_id', 1)
                            ->first();
                    }
                }

                /*
            |--------------------------------------------------------------------------
            | VALIDASI PERIODE
            |--------------------------------------------------------------------------
            */
                if (!$periodeTujuan) {
                    throw new \Exception('Periode tujuan tidak ditemukan.');
                }

                if ($periodeAktif->id == $periodeTujuan->id) {
                    throw new \Exception('Periode tujuan tidak boleh sama.');
                }

                /*
            |--------------------------------------------------------------------------
            | CEK GENERATE
            |--------------------------------------------------------------------------
            */
                $kelasSudahAda = Kelasmi::where(
                    'periode_id',
                    $periodeTujuan->id
                )->exists();

                if ($kelasSudahAda) {
                    throw new \Exception(
                        'Generate sudah pernah dilakukan pada periode tujuan.'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | DATA KELAS LAMA
            |--------------------------------------------------------------------------
            */
                $kelasLamaList = Kelasmi::with([
                    'pesertakelas',
                    'kelas'
                ])
                    ->where('periode_id', $periodeAktif->id)
                    ->get();

                if ($kelasLamaList->isEmpty()) {
                    throw new \Exception(
                        'Data kelas periode aktif kosong.'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | MAP KENAIKAN KELAS
            |--------------------------------------------------------------------------
            */
                $mapKelas = [
                    '1' => '2',
                    '2' => '3',
                    '3' => null,
                ];

                /*
            |--------------------------------------------------------------------------
            | LOOP KELAS
            |--------------------------------------------------------------------------
            */
                foreach ($kelasLamaList as $kelasLama) {

                    /*
                |--------------------------------------------------------------------------
                | VALIDASI RELASI KELAS
                |--------------------------------------------------------------------------
                */
                    if (!$kelasLama->kelas) {
                        continue;
                    }

                    $kelasSekarang = (string) $kelasLama->kelas->kelas;

                    $kelasNaik = $mapKelas[$kelasSekarang] ?? null;

                    /*
                |--------------------------------------------------------------------------
                | KELAS AKHIR = LULUS
                |--------------------------------------------------------------------------
                */
                    if (!$kelasNaik) {

                        $totalLulus += $kelasLama->pesertakelas->count();

                        continue;
                    }

                    /*
                |--------------------------------------------------------------------------
                | MASTER KELAS TUJUAN
                |--------------------------------------------------------------------------
                */
                    $kelasBaruMaster = Kelas::where(
                        'kelas',
                        $kelasNaik
                    )->first();

                    if (!$kelasBaruMaster) {
                        continue;
                    }

                    /*
                |--------------------------------------------------------------------------
                | AMBIL ROMBEL
                |--------------------------------------------------------------------------
                */
                    preg_match('/[A-Z]+$/', $kelasLama->nama_kelas, $match);

                    $rombel = $match[0] ?? '';

                    /*
                |--------------------------------------------------------------------------
                | NAMA KELAS BARU
                |--------------------------------------------------------------------------
                */
                    $namaKelasBaru = $kelasNaik . $rombel;

                    /*
                |--------------------------------------------------------------------------
                | CREATE KELAS BARU
                |--------------------------------------------------------------------------
                */
                    $kelasBaru = Kelasmi::create([
                        'kelas_id'   => $kelasBaruMaster->id,
                        'nama_kelas' => $namaKelasBaru,
                        'jenjang'    => $kelasLama->jenjang,
                        'kuota'      => $kelasLama->kuota,
                        'periode_id' => $periodeTujuan->id,
                    ]);

                    $totalKelas++;

                    /*
                |--------------------------------------------------------------------------
                | COPY PESERTA
                |--------------------------------------------------------------------------
                */
                    foreach ($kelasLama->pesertakelas as $peserta) {

                        /*
                    |--------------------------------------------------------------------------
                    | CEK DUPLIKAT SISWA
                    |--------------------------------------------------------------------------
                    */
                        $sudahAda = Pesertakelas::where(
                            'siswa_id',
                            $peserta->siswa_id
                        )
                            ->whereHas('kelasmi', function ($q) use ($periodeTujuan) {

                                $q->where(
                                    'periode_id',
                                    $periodeTujuan->id
                                );
                            })
                            ->exists();

                        if ($sudahAda) {

                            $totalSudahAda++;

                            continue;
                        }

                        /*
                    |--------------------------------------------------------------------------
                    | INSERT PESERTA
                    |--------------------------------------------------------------------------
                    */
                        Pesertakelas::create([
                            'siswa_id'   => $peserta->siswa_id,
                            'kelasmi_id' => $kelasBaru->id,
                        ]);

                        $totalPeserta++;
                    }
                }
            });

            /*
        |--------------------------------------------------------------------------
        | SUCCESS MESSAGE
        |--------------------------------------------------------------------------
        */
            return back()->with(
                'success',
                'Generate berhasil ke periode ' . $periodeTujuan->periode .
                    '. Kelas dibuat: ' . $totalKelas .
                    ', Peserta dipindahkan: ' . $totalPeserta .
                    ', Sudah ada: ' . $totalSudahAda .
                    ', Lulus: ' . $totalLulus
            );
        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function generateKelasSatu(Request $request)
    {
        try {

            $totalKelas = 0;

            $periodeTujuan = null;

            DB::transaction(function () use (
                $request,
                &$periodeTujuan,
                &$totalKelas
            ) {

                /*
            |--------------------------------------------------------------------------
            | PERIODE AKTIF
            |--------------------------------------------------------------------------
            */
                $periodeAktif = Periode::where('is_active', 1)->first();

                if (!$periodeAktif) {
                    throw new \Exception('Periode aktif tidak ditemukan.');
                }

                /*
            |--------------------------------------------------------------------------
            | MODE GENERATE
            |--------------------------------------------------------------------------
            */
                $mode = $request->mode ?? 'auto';

                if ($mode === 'custom') {

                    $periodeTujuan = Periode::find($request->periode_tujuan);
                } else {

                    /*
                |--------------------------------------------------------------------------
                | AUTO MODE
                |--------------------------------------------------------------------------
                */
                    if ($periodeAktif->semester_id == 1) {

                        $periodeTujuan = Periode::where('periode', $periodeAktif->periode)
                            ->where('semester_id', 2)
                            ->first();
                    } else {

                        [$tahunAwal, $tahunAkhir] = explode('/', $periodeAktif->periode);

                        $periodeBaru =
                            ((int)$tahunAwal + 1) .
                            '/' .
                            ((int)$tahunAkhir + 1);

                        $periodeTujuan = Periode::where('periode', $periodeBaru)
                            ->where('semester_id', 1)
                            ->first();
                    }
                }

                /*
            |--------------------------------------------------------------------------
            | VALIDASI PERIODE
            |--------------------------------------------------------------------------
            */
                if (!$periodeTujuan) {
                    throw new \Exception('Periode tujuan tidak ditemukan.');
                }

                if ($periodeAktif->id == $periodeTujuan->id) {
                    throw new \Exception('Periode tujuan tidak boleh sama.');
                }

                /*
            |--------------------------------------------------------------------------
            | AMBIL MASTER KELAS 1
            |--------------------------------------------------------------------------
            */
                $kelasSatuMaster = Kelas::where('kelas', '1')->first();

                if (!$kelasSatuMaster) {
                    throw new \Exception('Master kelas 1 tidak ditemukan.');
                }

                /*
            |--------------------------------------------------------------------------
            | AMBIL KELAS 1 PERIODE LAMA
            |--------------------------------------------------------------------------
            */
                $kelasSatuLama = Kelasmi::with('kelas')
                    ->where('periode_id', $periodeAktif->id)
                    ->whereHas('kelas', function ($q) {
                        $q->where('kelas', '1');
                    })
                    ->get();

                if ($kelasSatuLama->isEmpty()) {
                    throw new \Exception('Kelas 1 periode aktif tidak ditemukan.');
                }

                /*
            |--------------------------------------------------------------------------
            | LOOP KELAS
            |--------------------------------------------------------------------------
            */
                foreach ($kelasSatuLama as $kelasLama) {

                    /*
                |--------------------------------------------------------------------------
                | CEK DUPLIKAT KELAS
                |--------------------------------------------------------------------------
                */
                    $sudahAdaKelas = Kelasmi::where(
                        'periode_id',
                        $periodeTujuan->id
                    )
                        ->where('nama_kelas', $kelasLama->nama_kelas)
                        ->exists();

                    if ($sudahAdaKelas) {
                        continue;
                    }

                    /*
                |--------------------------------------------------------------------------
                | CREATE KELAS BARU TANPA PESERTA
                |--------------------------------------------------------------------------
                */
                    Kelasmi::create([
                        'kelas_id'   => $kelasSatuMaster->id,
                        'nama_kelas' => $kelasLama->nama_kelas,
                        'jenjang'    => $kelasLama->jenjang,
                        'kuota'      => $kelasLama->kuota,
                        'periode_id' => $periodeTujuan->id,
                    ]);

                    $totalKelas++;
                }
            });

            /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */
            return back()->with(
                'success',
                'Generate kelas 1 berhasil. Total kelas dibuat: ' .
                    $totalKelas
            );
        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}