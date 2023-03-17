<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Nominasi;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Daftar_Nominasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SeleksiController
{
    public function index()
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderBy('periode')->get();
        $daftarKelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelas.kelas', 3)
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('kelasmi.id', 'nama_kelas', 'kelas.kelas', 'kelasmi.kuota', 'periode.periode', 'semester.ket_semester')
            ->orderBy('nama_kelas')
            ->get();
        $nominasi = Nominasi::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'nominasi.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('nominasi.id', 'periode.periode', 'semester.ket_semester', 'nama_kelas')
            ->get();
        return view(
            'seleksi.index',
            [
                'daftarKelas' => $daftarKelas,
                'dataPeriode' => $dataPeriode,
                'nominasi' => $nominasi
            ]
        );
    }
    public function daftarNominasi(Nominasi $nominasi)
    {
        $title = Nominasi::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'nominasi.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('nominasi.id', 'periode.periode', 'semester.ket_semester', 'nama_kelas')
            ->find($nominasi->id);
        $daftarNominasi = Daftar_Nominasi::query()
            ->leftjoin('pesertakelas', 'pesertakelas.id', '=', 'daftar_nominasi.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->get();
        return view(
            'seleksi.list',
            [
                'nominasi' => $nominasi,
                'title' => $title,
                'daftarNominasi' => $daftarNominasi,
            ]
        );
    }
    public function daftarNominasiKelektif(Nominasi $nominasi)
    {
        $title = Nominasi::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'nominasi.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('nominasi.id', 'periode.periode', 'semester.ket_semester', 'nama_kelas')
            ->find($nominasi->id);
        $daftarNominasi = Pesertakelas::query()
            ->leftjoin('daftar_nominasi', 'pesertakelas.id', '=', 'daftar_nominasi.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelas.kelas', 3)
            ->where('kelasmi.nama_kelas', $title->nama_kelas)
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('daftar_nominasi.pesertakelas_id', '=', null)
            ->select('nama_siswa', 'periode', 'ket_semester', 'nama_kelas', 'kelas', 'pesertakelas.id')
            ->get();

        return view(
            'seleksi.kolektif',
            [
                'nominasi' => $nominasi,
                'title' => $title,
                'daftarNominasi' => $daftarNominasi,
            ]
        );
    }
    public function store(Request $request)
    {

        $nominasi = new Nominasi();
        $nominasi->kelasmi_id = $request->kelasmi_id;
        $nominasi->periode_id = $request->periode_id;
        $nominasi->tanggal_mulai = $request->tanggal_mulai;
        $nominasi->tanggal_selesai = $request->tanggal_selesai;
        $nominasi->save();
        return redirect()->back();
    }
    public function StoreNominasi(Request $request)
    {

        $hijri = 1444;

        // Mendapatkan nomor urut terakhir dari database
        $lastNumber = DB::table('daftar_nominasi')->max('id');

        // Mengkonversi tipe data variabel $lastNumber menjadi integer
        $lastNumber = (int) $lastNumber;

        // Menambahkan 1 pada nomor urut terakhir
        $newNumber = $lastNumber + 1;

        $hijriYear = $hijri;

        // Menambahkan leading zero pada nomor urut baru jika kurang dari 4 digit
        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Menggabungkan komponen kode menjadi satu string
        $code =   $hijriYear . '-' . 'II' . '-' . $newNumber;

        $pesertakelas = $request->input('pesertakelas', []);
        foreach ($request->pesertakelas as $peserta) {
            $pesertakelas = new Daftar_Nominasi();
            $pesertakelas->pesertakelas_id = $peserta;
            $pesertakelas->nominasi_id = $request->nominasi_id;
            $pesertakelas->nomor_ujian = $code;
            $pesertakelas->save();
        }




        return redirect()->back();
    }
}
