<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use Illuminate\Http\Request;

class AbsensikelasController
{
    public function index(Sesikelas $sesikelas)
    {
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.id', $sesikelas->kelasmi_id)
            ->first();
        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('absensikelas', function ($join) use ($sesikelas) {
                $join->on('absensikelas.pesertakelas_id', '=', 'pesertakelas.id')
                    ->where('absensikelas.sesikelas_id', '=', $sesikelas->id);
            })
            ->where('pesertakelas.kelasmi_id', $sesikelas->kelasmi_id)
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
                'absensikelas.id as absensikelas_id',
                'absensikelas.keterangan',
                'absensikelas.alasan',
                'absensikelas.updated_at as tglsimpan'
            )
            ->orderby('nis.nis')
            ->orderby('siswa.nama_siswa')
            ->get();

        $jumlahAbsensi = $dataSiswa->countBy('keterangan');
        if (!$jumlahAbsensi->has('hadir')) $jumlahAbsensi->put('hadir', 0);
        if (!$jumlahAbsensi->has('izin')) $jumlahAbsensi->put('izin', 0);
        if (!$jumlahAbsensi->has('sakit')) $jumlahAbsensi->put('sakit', 0);
        if (!$jumlahAbsensi->has('alfa')) $jumlahAbsensi->put('alfa', 0);

        $diSimpanPada = $dataSiswa
            ->sortByDesc('tglsimpan')
            ->value('tglsimpan');

        return view(
            'presensi.kelas.absensi',
            [
                'dataSiswa' => $dataSiswa,
                'dataKelas' => $dataKelas,
                'sesikelas' => $sesikelas,
                'jumlahAbsensi' => $jumlahAbsensi,
                'diSimpanPada' => $diSimpanPada,
            ]
        );
    }

    public function store(Request $request)
    {
        foreach ($request->pesertakelas as $peserta) {
            $absensikelas_id = $request->absensikelas[$peserta];
            $absensikelas = $absensikelas_id ? Absensikelas::find($absensikelas_id) : new Absensikelas();
            $absensikelas->pesertakelas_id = $peserta;
            $absensikelas->sesikelas_id = $request->sesikelas;
            $absensikelas->keterangan = $request->keterangan[$peserta];
            $absensikelas->alasan = $request->alasan[$peserta];
            $absensikelas->save();
        }
        return redirect()->back()->with('status', 'Presensi berhasil disimpan pada ' . now());
    }
}