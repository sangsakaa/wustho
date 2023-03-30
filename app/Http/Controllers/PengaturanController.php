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
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftjoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->select(
            [
                'pesertakelas.id',
                'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                'kelas.kelas',
                'periode.periode',
                'semester.semester',
                'semester.ket_semester',
            ]
        )
            ->orderby('kelas')
            ->orderby('nama_kelas')
            ->orderby('nama_siswa');
        if (request('cari')) {
            $raport->where('nama_siswa', 'like', '%' . request('cari') . '%');
        }
        return view(
            'pengaturan/pengaturan',
            [
                'raport' => $raport->paginate(10)
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
        ->where('kelasmi.periode_id', session('periode_id'));
        if (request('cari')) {
            $peserta->where('nama_kelas', 'like', '%' . request('cari') . '%');
        }
        return view(
            'pengaturan/semester',
            [
                'peserta' => $peserta->get()
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

    //    
    }
    public function sap(Request $request)
    {
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

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
            ->join('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
        ->select('nilaimapel.id', 'nama_guru', 'mapel')
        ->where('nilaimapel.kelasmi_id', $kelasmi->id);
        
        
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
        if (request('cari')) {
            $dataMapel->where('nama_siswa', 'like', '%' . request('cari') . '%');
        }
        return view('pengaturan.sap', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'dataMapel' => $dataMapel->get(),
        ]);
    }

    public function plotingkelas(Request $request)
    {

        return view('pengaturan.plotingkelas');
    }
}