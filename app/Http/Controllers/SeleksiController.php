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
            ->join('nominasi', 'nominasi.id', '=', 'daftar_nominasi.nominasi_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->select('daftar_nominasi.id', 'nomor_ujian', 'nama_siswa', 'nama_kelas')
            ->where('daftar_nominasi.nominasi_id', $nominasi->id)
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

        $hijriYear = $hijri;

        // Menggabungkan komponen kode menjadi satu string
        $codePrefix = $hijriYear . '-' . 'II' . '-';
        $newNumber = $lastNumber + 1;

        // Menambahkan leading zero pada nomor urut baru jika kurang dari 4 digit
        $newNumberStr = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Gabungkan prefix dengan nomor urut baru
        $code = $codePrefix . $newNumberStr;

        $pesertakelas = $request->input('pesertakelas', []);
        foreach ($pesertakelas as $peserta) {
            $existingNomination = Daftar_Nominasi::where('nomor_ujian', $code)->first();
            if ($existingNomination) {
                // Jika nomor ujian sudah ada, buat nomor ujian baru dengan nomor urut berikutnya
                $newNumber += 1;
                $newNumberStr = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                $code = $codePrefix . $newNumberStr;
            }

            $nominasi = new Daftar_Nominasi();
            $nominasi->pesertakelas_id = $peserta;
            $nominasi->nominasi_id = $request->nominasi_id;
            $nominasi->nomor_ujian = $code;
            $nominasi->save();
        }
        return redirect()->back();
    }
    public function destroy(Nominasi $nominasi)
    {
        Nominasi::destroy('id', $nominasi->id);
        Daftar_Nominasi::where('nominasi_id', $nominasi->id)->delete();
        return redirect()->back();
    }
    public function destroyNominasi(Daftar_Nominasi $daftar_Nominasi)
    {
        Daftar_Nominasi::destroy('id', $daftar_Nominasi->id);
        return redirect()->back();
    }
}
