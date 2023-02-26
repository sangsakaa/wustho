<?php

namespace App\Http\Controllers;

use App\Models\Lulusan;
use App\Models\Periode;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Daftar_lulusan;
use Illuminate\Support\Facades\DB;

class LulusanCotroller
{
    public function index()
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->get();
        $dataLulusan = Lulusan::query()
            ->join('periode', 'periode.id', '=', 'lulusan.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select(
                [
                    'lulusan.id',
                    'periode',
                    'ket_semester',
                    'lulusan.tanggal_mulai',
                    'lulusan.tanggal_selesai',
                    'lulusan.tanggal_kelulusan',
                ]
            )
            ->get();
        return view(
            'lulusan.index',
            [
                'dataLulusan' => $dataLulusan,
                'dataPeriode' => $dataPeriode
            ]
        );
    }
    public function store(Request $request)
    {
        $lulusan = new Lulusan();
        $lulusan->periode_id = $request->periode_id;
        $lulusan->tanggal_mulai = $request->tanggal_mulai;
        $lulusan->tanggal_selesai = $request->tanggal_selesai;
        $lulusan->tanggal_kelulusan = $request->tanggal_kelulusan;
        $lulusan->save();
        return redirect()->back();
    }
    public function daftarLulusan(Lulusan $lulusan, Daftar_lulusan $daftar_lulusan)
    {
        $daftarLulusan = Daftar_lulusan::query()
            ->leftjoin('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->leftjoin('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                    'daftar_lulusan.id',
                    'daftar_lulusan.nomor_ijazah',
                'siswa.nama_siswa',
                'nis.nis',
                ]
            )
            ->where('daftar_lulusan.lulusan_id', $lulusan->id)
            ->orderby('nama_siswa')
            ->get();
        return view(
            'lulusan.daftar',
            [
                'lulusan' => $lulusan,
                'daftarLulusan' => $daftarLulusan,
                'daftar_lulusan' => $daftar_lulusan,
            ]
        );
    }
    public function kolektifLulusan(Lulusan $lulusan)
    {
        $daftarLulusan = Pesertakelas::query()
            ->leftjoin('daftar_lulusan', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select(
                [
                'pesertakelas.id',
                    'nama_siswa',
                    'nama_kelas'

                ]
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('daftar_lulusan.pesertakelas_id', '=', null)
            ->where('kelas.kelas', 3)
            ->orderby('nama_kelas')
            ->get();

        return view(
            'lulusan.kolektif',
            [
                'daftarLulusan' => $daftarLulusan,
                'lulusan' => $lulusan
            ]
        );
    }
    public function storeLulusan(Request $request)
    {
        $year = 1444;

        // mendapatkan nomor urut terakhir dari database
        $lastNumber = DB::table('daftar_lulusan')->max('id');

        // mengambil 4 digit terakhir dari nomor urut terakhir
        $lastNumber = substr($lastNumber, -4);

        // menambahkan 1 pada nomor urut terakhir
        $newNumber = (int) $lastNumber + 1;

        // menambahkan leading zero pada nomor urut baru jika kurang dari 4 digit
        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // menggabungkan komponen kode menjadi satu string
        $code = 'MD-02-I-' . $year . '-' . $newNumber;
        if ($request->pesertakelas) {
            foreach ($request->pesertakelas as $list) {
                $peserta = new Daftar_lulusan();
                $peserta->pesertakelas_id = $list;
                $peserta->lulusan_id = $request->lulusan_id;
                $peserta->nomor_ijazah = $code;
                $peserta->save();
            }
        } else {
            "tidak ada inputan";
        }
        return redirect()->back();
    }
    public function Destroy(Lulusan $lulusan)
    {
        Lulusan::destroy($lulusan->id);
        Daftar_lulusan::where('lulusan_id', $lulusan->id)->delete();
        return redirect()->back();
    }
    public function DeletePeserta(Daftar_lulusan $daftar_lulusan)
    {
        Daftar_lulusan::destroy($daftar_lulusan->id);
        return redirect()->back();
    }

    public function edit(Daftar_lulusan $daftar_lulusan, Pesertakelas $pesertakelas,)
    {
        return view('lulusan.edit', [
            'daftar_lulusan' => $daftar_lulusan,
            'pesertakelas' => $pesertakelas
        ]);
    }

    public function update(Request $request, Daftar_lulusan $daftar_lulusan,)
    {
        Daftar_lulusan::where('id', $daftar_lulusan->id)
            ->update([

                'nomor_ijazah' => $request->nomor_ijazah,
            ]);
        return redirect('/daftar-lulusan/' . $daftar_lulusan->lulusan_id);
    }
}
