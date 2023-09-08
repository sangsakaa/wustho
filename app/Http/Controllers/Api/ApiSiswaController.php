<?php

namespace App\Http\Controllers\Api;

use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Asramasiswa;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Pesertaasrama;

class ApiSiswaController
{
    public function index()

    {
        $siswa = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            // ->select(
            //     [
            //         'nis',
            //         'nama_siswa',
            //         'madrasah_diniyah',
            //         'jenis_kelamin',
            //         'agama',
            //         'tanggal_masuk',
            //         'nama_lembaga',
            //         'tempat_lahir',
            //         'tanggal_lahir',
            //         'kota_asal',
            //         'nama_asrama'
            //     ]
            // )
            // ->where('asramasiswa.periode_id', session('periode_id'))
            ->get();
        // dd($siswa);
        return response()->json(['siswa' => $siswa]);
    }
    public function show(Siswa $siswa)
    {
        $siswa = Siswa::find($siswa);
        return response()->json(['siswa' => $siswa]);
    }
    public function dataAsrama(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'periode.periode', 'semester.ket_semester', 'jenjang')
            // ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();

        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama', 'jenjang')
            // ->where('asramasiswa.periode_id', session('periode_id'))
        ;

        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->joinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->select('kelasmi.jenjang', 'peserta_asrama.nama_asrama',  'siswa.nama_siswa', 'absensikelas.keterangan')
            ->where('sesikelas.tgl', $tgl->toDateString())
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('absensikelas.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->get();

        $absensiGrup = $dataAbsensiKelas
            ->where('keterangan', '!=', 'hadir')
            ->groupBy('nama_asrama')
            ->map(function ($item, $key) {
                return $item
                    ->groupBy('nama_kelas');
            });

        $rekapAbsensi = $dataAbsensiKelas
            ->groupBy('nama_asrama',)
            ->map(function ($item, $nama_asrama) use ($absensiGrup) {
                return $item
                    ->groupBy('nama_kelas')
                    ->map(function ($item, $nama_kelas) use ($absensiGrup, $nama_asrama) {
                        $nullAbsensi =  new Absensikelas([
                            'nama_asrama' => $nama_asrama,
                            'nama_siswa' => '-',
                            'keterangan' => '-'
                        ]);
                        $total = $item->count();
                        $hadir = $item->where('keterangan', 'hadir')->count();
                        $tidakHadir = $total - $hadir;
                        $absensi = $tidakHadir === 0 ? collect([$nullAbsensi]) : $absensiGrup[$nama_asrama][$nama_kelas];
                        // 

                    })
                    ->filter();
            });

        return response()->json(
            [
                'dataKelasMi' => $tgl->toDateString(),
                'rekapAbsensi' => $rekapAbsensi,
                'tgl' => $tgl,
            ]
        );
        
    }
}
