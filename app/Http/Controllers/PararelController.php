<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PararelController
{
    public function index()
    {
        // $nilaiPerPesertaKelas = Nilai::query()
        //     ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
        //     ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        //     ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        //     ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        //     ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
        //     ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
        //     ->select('siswa.nama_siswa', 'kelas.kelas', 'mapel.mapel', 'nilai.nilai_harian', 'nilai.nilai_ujian', 'nilai.pesertakelas_id')
        //     ->where('kelasmi.periode_id', session('periode_id'))
        //     ->where('kelas.kelas', 3)
        //     ->get()
        // ->groupBy('pesertakelas_id');
        // $nilaiPesertaKelasMap = collect();
        
        // $nilaiPerPesertaKelas->each(function ($items, $pesertaKelasId) use ($nilaiPesertaKelasMap) {
        //     $nilaiPesertaKelas = ['pesertakelas_id' => $pesertaKelasId];
        //     $items->each(function ($item) use (&$nilaiPesertaKelas) {
        //         $namaSiswa = $item->nama_siswa;
        //         $mapel = $item->mapel;
        //         $nilaiHarian = $item->nilai_harian;
        //         $nilaiUjian = $item->nilai_ujian;
        //         if (!isset($nilaiPesertaKelas[$namaSiswa])) {
        //             $nilaiPesertaKelas[$namaSiswa] = [];
        //         }
        //         if (!isset($nilaiPesertaKelas[$namaSiswa][$mapel])) {
        //             $nilaiPesertaKelas[$namaSiswa][$mapel] = [];
        //         }
        //         $nilaiPesertaKelas[$namaSiswa][$mapel]['nilaiHarian'] = $nilaiHarian;
        //         $nilaiPesertaKelas[$namaSiswa][$mapel]['nilaiUjian'] = $nilaiUjian;
        //     });
        //     $nilaiPesertaKelasMap->push($nilaiPesertaKelas);
            
        // });

        // $siswa = Pesertakelas::query()
        // ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        // ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        //     ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        // ->where('kelasmi.periode_id', session('periode_id'))
        //     ->select('pesertakelas.id', 'nama_siswa', 'kelas', 'nama_kelas')
        // ->orderby('kelasmi.nama_kelas')
        // ->orderby('siswa.nama_siswa')
        //     ->where('kelas', 3)
        // ->get();
        // $mapel = Mapel::query()
        // ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
        // ->select('mapel.id', 'mapel', 'kelas')
        //     ->where('kelas', 3)
        // ->orderbY('kelas.kelas')
        // ->get();
        // return view('seleksi.nominasi.index', [
        //     'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
        //     'siswa' => $siswa,
        //     'mapel' => $mapel,
        // ]);
        $nilaiPerPesertaKelas = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select('siswa.nama_siswa', 'kelas.kelas', 'mapel.mapel', 'nilai.nilai_harian', 'nilai.nilai_ujian', 'nilai.pesertakelas_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', 3)
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

                $nilaiPesertaKelas[$namaSiswa][$mapel]['nilaiHarian'] = $nilaiHarian;
                $nilaiPesertaKelas[$namaSiswa][$mapel]['nilaiUjian'] = $nilaiUjian;
            });

            $nilaiPesertaKelasMap->push($nilaiPesertaKelas);
        });

        $siswa = Pesertakelas::query()
        ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelas.kelas', 3)
            ->select('pesertakelas.id', 'nama_siswa', 'kelas', 'nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
        ->get();

        $mapel = Mapel::query()
        ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->where('kelas', 3)
        ->select('mapel.id', 'mapel', 'kelas')
            ->orderBy('kelas.kelas')
        ->get();

        return view('seleksi.nominasi.index', [
            'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
            'siswa' => $siswa,
            'mapel' => $mapel,
        ]);
   


    }
}
