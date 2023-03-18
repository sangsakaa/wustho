<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PararelController
{
    public function index()
    {
        $nilaiPerPesertaKelas = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select('siswa.nama_siswa', 'mapel.mapel', 'nilai.nilai_harian', 'nilai.nilai_ujian', 'nilai.pesertakelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->get()
            ->groupBy('pesertakelas_id');

        $nilaiPesertaKelasMap = collect();
        $nilaiPerPesertaKelas->each(function ($items, $pesertaKelasId) use ($nilaiPesertaKelasMap) {
            $nilaiPesertaKelas = ['pesertakelas_id' => $pesertaKelasId];
            $items->each(function ($item) use (&$nilaiPesertaKelas) {
                $namaSiswa = $item->nama_siswa;
                $mapel = $item->mapel;
                $nilaiHarian = $item->nilai_harian;
                $nilaiUjian = $item->nilai_ujian;
                if (!isset($nilaiPesertaKelas[$namaSiswa])) {
                    $nilaiPesertaKelas[$namaSiswa] = [];
                }
                if (!isset($nilaiPesertaKelas[$namaSiswa][$mapel])) {
                    $nilaiPesertaKelas[$namaSiswa][$mapel] = [];
                }
                $nilaiPesertaKelas[$namaSiswa][$mapel] = compact('nilaiHarian', 'nilaiUjian');
            });
            $nilaiPesertaKelasMap->push($nilaiPesertaKelas);
        });

        $siswa = Siswa::select('id', 'nama_siswa')->get();
        $mapel = Mapel::select('id', 'mapel')->get();

        return view('seleksi.nominasi.index', [
            'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
            'siswa' => $siswa,
            'mapel' => $mapel,
        ]);
    }
}
