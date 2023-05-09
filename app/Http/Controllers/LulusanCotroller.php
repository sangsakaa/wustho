<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lulusan;
use App\Models\Periode;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Daftar_lulusan;
use App\Models\Kelasmi;
use Illuminate\Support\Facades\DB;

class LulusanCotroller
{
    public function index()
    {
        $kelasMi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->select('kelasmi.id', 'kelas', 'nama_kelas', 'ket_semester', 'periode')
            ->where('kelas.kelas', 3)

            ->orderby('nama_kelas')->get();
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester', 'desc')
            ->get();
        $dataLulusan = Lulusan::query()
            ->join('periode', 'periode.id', '=', 'lulusan.periode_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('lulusan.periode_id', session('periode_id'))
            ->select(
                [
                'kelasmi.nama_kelas',
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
                'dataPeriode' => $dataPeriode,
                'kelasMi' => $kelasMi,
            ]
        );
    }
    public function store(Request $request)
    {
        $lulusan = new Lulusan();
        $lulusan->periode_id = $request->periode_id;
        $lulusan->kelasmi_id = $request->kelasmi_id;
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
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                    'daftar_lulusan.id',
                    'daftar_lulusan.nomor_ijazah',
                'kelasmi.nama_kelas',
                'siswa.nama_siswa',
                'nis.nis',
                ]
            )
            ->where('daftar_lulusan.lulusan_id', $lulusan->id)
            ->orderby('nomor_ijazah')
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
    public function kolektifLulusan(Lulusan $lulusan,)
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
            ->where('pesertakelas.kelasmi_id', $lulusan->kelasmi_id)
            ->orderby('nama_kelas')
            ->orderby('nama_siswa')
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
        
        $hijri = 1444;

        // Mendapatkan nomor urut terakhir dari database
        $lastNumber = DB::table('daftar_lulusan')->max('id');

        // Mengkonversi tipe data variabel $lastNumber menjadi integer
        $lastNumber = (int) $lastNumber;

        // Mengambil 4 digit terakhir dari nomor urut terakhir
        $lastNumber = substr($lastNumber, -4);

        // Menambahkan 1 pada nomor urut terakhir
        $newNumber = $lastNumber + 1;
        $hijriYear = $hijri;

        // Menambahkan leading zero pada nomor urut baru jika kurang dari 4 digit
        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Menggabungkan komponen kode menjadi satu string
        $code = 'MD-01-II-' . $hijriYear . '-' . $newNumber;

        $pesertaKelas = $request->input('pesertakelas', []);

        if (count($pesertaKelas) > 0) {
            $daftarLulusan = [];

            foreach ($pesertaKelas as $pesertaKelasId) {
                $daftarLulusan[] = [
                    'pesertakelas_id' => $pesertaKelasId,
                    'lulusan_id' => $request->lulusan_id,
                    'nomor_ijazah' => $code
                ];

                // increment nomor urut untuk setiap peserta kelas
                $newNumber++;
                $code = 'MD-01-II-' . $hijriYear . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            }

            // insert multiple data ke database
            Daftar_lulusan::insert($daftarLulusan);
        } else {
            return "Tidak ada inputan";
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
