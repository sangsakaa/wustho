<?php

namespace App\Http\Controllers;

use App\Models\Daftar_lulusan;
use App\Models\Kelasmi;
use App\Models\Transkip;
use App\Models\Nilai_Transkip;
use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class ValidasiController
{
    public function index(Kelasmi $kelasmi)
    {
        $dataKelas = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        $data = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->leftjoin('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->leftjoin('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            // ->select('siswa.nama_siswa')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->orderby('nama_siswa');
        if (request('cari')) {
            $data->where('nama_kelas', 'like', '%' . request('cari') . '%');
        }
        return view(
            'validasi.index',
            [
                'data' => $data->get(),
                'dataKelas' => $dataKelas,
                'kelasmi' => $kelasmi

            ]
        );
    }
    public function blangkoijazah(Siswa $siswa)
    {
        $daftarLulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                    'nis.nis',
                    'siswa.nama_siswa',
                    'siswa.tempat_lahir',
                    'siswa.tanggal_lahir',
                    'lulusan.tanggal_mulai',
                    'lulusan.tanggal_selesai',
                    'lulusan.tanggal_kelulusan',
                    'daftar_lulusan.nomor_ijazah',


                ]
            )
            ->get();

        return view(
            'validasi.blangkoijazah',
            [
                'siswa' => $siswa,
                'data' => $daftarLulusan,

            ]
        );
    }
    public function blangkoTranskip(Transkip $transkip)
    {
        $dataNilaiiaTranskip = Nilai_Transkip::query()
            ->get();




        return view(
            'validasi.blangko-transkip',
            [
                'dataNilaiiaTranskip' => $dataNilaiiaTranskip,
                'transkip' => $transkip,


            ]
        );
    }
}
