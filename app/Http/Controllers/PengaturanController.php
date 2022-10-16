<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Periode;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengaturanController extends Controller
{
    public function pengaturan()
    {

        $raport = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->select('pesertakelas.id', 'siswa.nama_siswa', 'kelas.kelas', 'kelasmi.nama_kelas');
        if (request('cari')) {
            $raport->where('nama_siswa', 'like', '%' . request('cari') . '%');
        }
        return view(
            'pengaturan/pengaturan',
            [
                'raport' => $raport->paginate(5)
            ]
        );
    }
    // Controller Periode
    public function periode()
    {
        $semester = Semester::query()
            ->get();
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->get();
        return view(
            'pengaturan/periode',
            [
                'periode' => $periode,
                'semester' => $semester
            ]
        );
    }
    public function storeperiode(Request $request)
    {
        $periode = new Periode();
        $periode->periode = $request->periode;
        $periode->semester_id = $request->semester_id;
        $periode->save();
        return redirect()->back();
    }
    public function deleteperiode(Periode $periode)
    {
        Periode::destroy($periode->id);
        return redirect()->back();
    }

    public function semester()
    {
        $peserta = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('kelas', 'kelasmi.id', '=', 'kelasmi.kelas_id')
            ->select('siswa.nama_siswa', 'kelasmi.nama_kelas', 'nis.nis')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get();
        return view(
            'pengaturan/semester',
            [
                'peserta' => $peserta
            ]
        );
    }
}
