<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Dompdf\Dompdf;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Semester;
use App\Models\Nilaimapel;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengaturanController extends Controller
{
    public function pengaturan()
    {

        $raport = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->select('pesertakelas.id', 'siswa.nama_siswa');
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
    public function cardlogin()
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
            'pengaturan/cardlogin',
            [
                'peserta' => $peserta
            ]
        );
    }
    public function download_file()
    {

        $peserta = Guru::all();
        $data = PDF::loadView($peserta);
        return view(
            'pengaturan/template',
            ['data' => $data]
        );
    }
    public function sap(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        if (!$kelasmi) {
            return view('pengaturan.sap', [
                'dataKelasMi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'dataSiswa' => collect(),
                'dataMapel' => collect(),
            ]);
        }

        $dataMapel = Nilaimapel::query()
            ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->where('nilaimapel.kelasmi_id', $kelasmi->id)
            ->get();

        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('pesertakelas.kelasmi_id', $kelasmi->id)
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
            )
            ->orderby('siswa.nama_siswa')
            ->get();

        return view('pengaturan.sap', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'dataMapel' => $dataMapel,
        ]);
    }

    public function plotingkelas(Request $request)
    {

        return view('pengaturan.plotingkelas');
    }
}