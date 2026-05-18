<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Pesertakelas;
use App\Models\Presensikelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensikelasController
{
    public function index()
    {
        $kelasMI = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')

            ->leftJoin('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->leftJoin('presensikelas', 'presensikelas.pesertakelas_id', '=', 'pesertakelas.id')

            ->selectRaw("
            kelasmi.id,
            nama_kelas,
            ket_semester,
            kelas,
            periode,
            kuota,

            COUNT(DISTINCT pesertakelas.id) as total_peserta,

            COUNT(DISTINCT CASE 
                WHEN presensikelas.id IS NOT NULL THEN pesertakelas.id 
            END) as sudah_diisi,

            COUNT(DISTINCT CASE 
                WHEN presensikelas.id IS NULL THEN pesertakelas.id 
            END) as belum_diisi,

            COALESCE(SUM(presensikelas.izin),0) as total_izin,
            COALESCE(SUM(presensikelas.sakit),0) as total_sakit,
            COALESCE(SUM(presensikelas.alfa),0) as total_alfa
        ")

            ->where('kelasmi.periode_id', session('periode_id'))

            ->groupBy(
                'kelasmi.id',
            'nama_kelas',
                'ket_semester',
            'kelas',
                'periode',
            'kuota'
            )

            ->orderBy('periode')
            ->orderBy('ket_semester')
            ->orderBy('nama_kelas')
            ->get();

        return view('presensi.kelas.kelas', compact('kelasMI'));
    }
    public function create()
    {
    }

    public function store(Request $request)
    {
        foreach ($request->pesertakelas as $peserta) {
            $presensikelas_id = $request->presensikelas_id[$peserta];
            $presensikelas = $presensikelas_id ? Presensikelas::find($presensikelas_id) : new Presensikelas();
            $presensikelas->pesertakelas_id = $peserta;
            $presensikelas->izin = $request->izin[$peserta] ?? 0;
            $presensikelas->sakit = $request->sakit[$peserta] ?? 0;
            $presensikelas->alfa = $request->alfa[$peserta] ?? 0;
            $presensikelas->save();
        }
        return redirect()->back()->with('status', 'Presensi berhasil disimpan pada ' . now());
    }

    public function show(Kelasmi $kelasmi)
    {
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.id', $kelasmi->id)
            ->first();
        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('presensikelas', 'presensikelas.pesertakelas_id', '=', 'pesertakelas.id')
            ->where('pesertakelas.kelasmi_id', $kelasmi->id)
            
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
                'presensikelas.id as presensikelas_id',
                'presensikelas.izin',
                'presensikelas.sakit',
                'presensikelas.alfa'
        )
            ->orderby('siswa.nama_siswa')
            
            ->get();
        return view(
            'presensi.kelas.presensi',
            [
                'dataSiswa' => $dataSiswa,
                'dataKelas' => $dataKelas,
            ]
        );
    }
}