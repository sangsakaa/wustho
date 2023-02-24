<?php

namespace App\Http\Controllers;


use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Transkip;
use App\Models\Pesertakelas;
use App\Models\Daftar_lulusan;
use App\Models\Nilai_Transkip;
use Riskihajar\Terbilang\Facades\Terbilang;


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
            ->join('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->select(
                [
                    'nis.nis',
                    'siswa.nama_siswa',
                    'siswa.tempat_lahir',
                    'statusanak.nama_ayah',
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
    public function blangkoTranskip()
    {

        $data_lulusan = Daftar_lulusan::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('nilai_transkip', 'nilai_transkip.daftar_lulusan_id', '=', 'daftar_lulusan.id')
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select('daftar_lulusan.id', 'nama_siswa', 'nis',)
            ->get();
        $data_nilai_tulis = Nilai_Transkip::query()
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->join('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
            ->select('nilai_transkip.daftar_lulusan_id', 'nama_ujian', 'nilai_transkip.nilai_akhir', 'mapel')
            ->where('jenis_ujian.nama_ujian', 'tulis')
            ->get();
        $data_nilai_praktek = Nilai_Transkip::query()
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->join('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
            ->select('nilai_transkip.daftar_lulusan_id', 'nama_ujian', 'nilai_akhir', 'mapel')
            ->where('jenis_ujian.nama_ujian', 'praktek')
            ->get();
        $data = [];
        // dd($data_lulusan);
        foreach ($data_lulusan as $lulusan) {
            $data[$lulusan->id] =
                [
                    'lulusan' => $lulusan,
                    'nilai_tulis' => $data_nilai_tulis->where('daftar_lulusan_id', $lulusan->id),
                'nilai_praktek' => $data_nilai_praktek->where('daftar_lulusan_id', $lulusan->id),
                ];
        }
        

        

        
        return view(
            'validasi.blangko-transkip',
            [

                'data' => $data,
                
                




            ]
        );
    }
}
