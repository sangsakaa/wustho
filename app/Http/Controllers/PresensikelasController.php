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
        $dataJumlahPeserta = Kelasmi::query()
            ->select(['kelasmi.id', DB::raw('count(pesertakelas.id) as jumlah_peserta_asrama')])
            ->join('pesertakelas', 'pesertakelas.kelasmi_id', '=', 'kelasmi.id')
            ->groupBy('kelasmi.id');

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
            ->orderBy('nama_kelas')
            ->get();
        // dd($kelasMI);
        return view(
            'presensi.kelas.kelas',
            [
                'kelasMI' => $kelasMI,
            ]
        );
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
            ->orderby('nis.nis')
            ->get();
        return view(
            'presensi.kelas.presensi',
            [
                'dataSiswa' => $dataSiswa,
                'dataKelas' => $dataKelas,
            ]
        );
    }

    public function edit(int $id)
    {
    }

    public function update(Request $request, int $id)
    {
    }

    public function destroy(int $id)
    {
    }
}