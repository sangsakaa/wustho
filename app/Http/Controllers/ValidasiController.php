<?php

namespace App\Http\Controllers;


use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Transkip;
use App\Models\Pesertakelas;
use App\Models\Daftar_lulusan;
use App\Models\Lulusan;
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
                'kelasmi' => $kelasmi,

            ]
        );
    }
    public function blangkoijazah(Siswa $siswa, Lulusan $lulusan)
    {
        $DataIjaza = $lulusan::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
        ->select('kelasmi.nama_kelas')
        ->where('kelasmi.id', $lulusan->kelasmi_id)->first();
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', 3)
            ->select('kelasmi.id', 'nama_kelas')
            ->orderby('nama_kelas')
            ->get();
        $daftarLulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('daftar_nominasi', 'daftar_nominasi.pesertakelas_id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->where('lulusan.kelasmi_id', $lulusan->kelasmi_id)
            
            ->select(
                [
                    'nis.nis',
                'kelas.kelas',
                'kelasmi.id',
                'kelasmi.nama_kelas',
                    'siswa.nama_siswa',
                    'siswa.tempat_lahir',
                    'statusanak.nama_ayah',
                    'siswa.tanggal_lahir',
                    'lulusan.tanggal_mulai',
                    'lulusan.tanggal_selesai',
                    'lulusan.tanggal_kelulusan',
                'lulusan.tanggal_lulus_hijriyah',
                    'daftar_lulusan.nomor_ijazah',
                'daftar_nominasi.nomor_ujian',


                ]
        );
        if (request('cari')) {
            $daftarLulusan->where('kelasmi.id', 'like', '%' . request('cari') . '%');
        }
        

        return view(
            'validasi.blangkoijazah',
            [
                'siswa' => $siswa,
                'data' => $daftarLulusan->get(),
                'dataKelas' => $dataKelas,
                'kelasmi' => $lulusan,
                'DataIjaza' => $DataIjaza
                

            ]
        );
    }
    public function blangkoTranskip(Lulusan $lulusan)
    {
        $dataLulusan = Lulusan::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'lulusan.kelasmi_id')
            ->select(
                [
                    'lulusan.id',
                    'nama_kelas',
                    'tanggal_kelulusan',
                    'tanggal_lulus_hijriyah'
                ]
            )
            ->where('lulusan.id', $lulusan->id)->first();
    
        $data_lulusan = Daftar_lulusan::query()
            ->join('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->join('nilai_transkip', 'nilai_transkip.daftar_lulusan_id', '=', 'daftar_lulusan.id')
            ->join('transkip', 'transkip.id', '=', 'nilai_transkip.transkip_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select(
                [
                    'daftar_lulusan.id',
                'daftar_lulusan.lulusan_id',
                    'nama_siswa',
                'nis',  
                    'tanggal_kelulusan',
                    'tanggal_selesai',
                    'tanggal_mulai'
                ]
            )
            ->where('daftar_lulusan.lulusan_id', $lulusan->id)
            ->get();
        // dd($lulusan->id);
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
        
        foreach ($data_lulusan as $lulusan) {
            $data[$lulusan->id] =
                [
                    'lulusan' => $lulusan,
                    'nilai_tulis' => $data_nilai_tulis->where('daftar_lulusan_id', $lulusan->id),
                'nilai_praktek' => $data_nilai_praktek->where('daftar_lulusan_id', $lulusan->id),
                'tulis' => $data_nilai_tulis->where('daftar_lulusan_id', $lulusan->id)->count('nilai_akhir'),
                'praktik' => $data_nilai_praktek->where('daftar_lulusan_id', $lulusan->id)->count('nilai_akhir'),
                ];
            
        }
        
        return view(
            'validasi.blangko-transkip',
            [
                'data' => $data,
                'lulusan' => $lulusan,
                'data_lulusan' => $data_lulusan,
                'dataLulusan' => $dataLulusan,
            ]
        );
    }
}
