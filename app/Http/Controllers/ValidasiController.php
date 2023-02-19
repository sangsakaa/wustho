<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
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
        $data = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->leftjoin('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->leftjoin('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->get();
        return view(
            'validasi.blangkoijazah',
            [
                'siswa' => $siswa,
                'data' => $data,

            ]
        );
    }
    public function blangkoTranskip(Siswa $siswa)
    {
        $data = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->leftjoin('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->leftjoin('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->get();
        return view(
            'validasi.blangko-transkip',
            [
                'siswa' => $siswa,
                'data' => $data,

            ]
        );
    }
}
