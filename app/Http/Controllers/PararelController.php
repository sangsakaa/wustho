<?php

namespace App\Http\Controllers;

use App\Models\Kelasmi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pesertakelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class PararelController
{
    public function index(Request $request)
    {
        
        
        $nilaiPerPesertaKelas = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select(
                [
                    'siswa.nama_siswa',
                    'kelas.kelas',
                    'mapel.mapel',
                    'nilai.nilai_harian',
                    'nilai.nilai_ujian',
                    'nilai.pesertakelas_id'
                ]
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            // ->where('kelas.kelas', 3)
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
            ->select('pesertakelas.id', 'kelasmi_id', 'nama_siswa', 'kelas', 'nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
        ->orderBy('siswa.nama_siswa');
        $dataKelasMi = Kelasmi::query()
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->where(
            'kelas',
            3
        )
            ->select('kelasmi.id', 'nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
        ->get();



        $mapel = Mapel::query()
        ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->where('kelas', 3)
            ->whereNotIn('mapel', ['Qiro\'atul Kutub', 'Mengajar'])
        ->select('mapel.id', 'mapel', 'kelas')
            ->orderBy('kelas.kelas')
            ->orderBy('mapel.id')
        ->get();

        $kelasmi = Kelasmi::query()
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join(
            'semester',
            'semester.id',
            '=',
            'periode.semester_id'
        )
        ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->where('kelasmi.id', $request->kelasmi_id)
        ->first();
        if (request('kelasmi_id')) {
            $siswa->where('kelasmi.id', 'like', '%' . request('kelasmi_id') . '%');
        }

        return view('seleksi.nominasi.index', [
            'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
            'siswa' => $siswa->paginate(40),
            'mapel' => $mapel,
            'dataKelasMi' => $dataKelasMi,
            'kelasmi' => $kelasmi
        ]);
    }
    public function indexSiswa(Request $request)
    {


        $nilaiPerPesertaKelas = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select(
                [
                    'siswa.nama_siswa',
                    'kelas.kelas',
                    'mapel.mapel',
                    'nilai.nilai_harian',
                    'nilai.nilai_ujian',
                    'nilai.pesertakelas_id'
                ]
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            // ->where('kelas.kelas', 3)
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
            ->where('kelas', 1)
            ->select('pesertakelas.id', 'kelasmi_id', 'nama_siswa', 'kelas', 'nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa');
        $dataKelasMi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelas', 1) // menambahkan where untuk memfilter kelas 1 dan 2
            ->select('kelasmi.id', 'nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('nama_kelas') // perbaikan pada penulisan orderBy
            ->get();




        $mapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->where('kelas', 1)
            ->whereNotIn('mapel', ['Qiro\'atul Kutub', 'Mengajar'])
            ->where(function ($query) {
                $query->where('kelas', 1)
                    ->orWhere(function ($query2) {
                        $query2->where('kelas', 2)
                            ->whereNotIn('mapel', ['Mengajar']);
                    });
            })
            ->select('mapel.id', 'mapel', 'kelas')
            ->orderBy('kelas.kelas')
            ->orderBy('mapel.id')
            ->get();


        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join(
                'semester',
                'semester.id',
                '=',
                'periode.semester_id'
            )
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        if (request('kelasmi_id')) {
            $siswa->where('kelasmi.id', 'like', '%' . request('kelasmi_id') . '%');
        }

        return view('seleksi.nominasi.indexSiswa', [
            'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
            'siswa' => $siswa->paginate(40),
            'mapel' => $mapel,
            'dataKelasMi' => $dataKelasMi,
            'kelasmi' => $kelasmi
        ]);
    }
    public function RekapNilaiSiswa(Request $request)
    {


        $nilaiPerPesertaKelas = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select(
                [
                    'siswa.nama_siswa',
                    'kelas.kelas',
                    'mapel.mapel',
                    'nilai.nilai_harian',
                    'nilai.nilai_ujian',
                    'nilai.pesertakelas_id'
                ]
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            // ->where('kelas.kelas', 3)
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
            ->where('kelas', 2)
            ->select('pesertakelas.id', 'kelasmi_id', 'nama_siswa', 'kelas', 'nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa');
        $dataKelasMi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('kelas', 2) // menambahkan where untuk memfilter kelas 1 dan 2
            ->select('kelasmi.id', 'nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('nama_kelas') // perbaikan pada penulisan orderBy
            ->get();




        $mapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->where('kelas', 2)
            ->whereNotIn('mapel', ['Qiro\'atul Kutub', 'Mengajar'])
            ->where(function ($query) {
                $query->where('kelas', 2)
                ->orWhere(function ($query2) {
                    $query2->where('kelas', 2)
                    ->whereNotIn('mapel', ['Mengajar']);
                });
            })
            ->select('mapel.id', 'mapel', 'kelas')
            ->orderBy('kelas.kelas')
            ->orderBy('mapel.id')
            ->get();


        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join(
                'semester',
                'semester.id',
                '=',
                'periode.semester_id'
            )
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        if (request('kelasmi_id')) {
            $siswa->where('kelasmi.id', 'like', '%' . request('kelasmi_id') . '%');
        }

        return view('seleksi.nominasi.rekapNilaiSiswa', [
            'nilaiPesertaKelasMap' => $nilaiPesertaKelasMap,
            'siswa' => $siswa->paginate(40),
            'mapel' => $mapel,
            'dataKelasMi' => $dataKelasMi,
            'kelasmi' => $kelasmi
        ]);
    }
}
