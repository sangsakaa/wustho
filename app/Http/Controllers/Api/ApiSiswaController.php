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
            // ->join('pesertaasrama', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            // ->join('asramasiswa', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            // ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select([
                'nis.nis',
                'siswa.nama_siswa',
                'nis.tanggal_masuk',
                'nis.madrasah_diniyah',
                'nis.nama_lembaga',
                'siswa.jenis_kelamin',
                'siswa.agama',
                'siswa.tempat_lahir',
                'siswa.tanggal_lahir',
                'siswa.kota_asal',
                // 'asrama.nama_asrama'
            ])
            // ->groupBy('nis.nis') // Mengelompokkan data berdasarkan NIS
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
        

        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
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
            ->select('kelasmi.jenjang', 'peserta_asrama.nama_asrama', 'absensikelas.id', 'siswa.nama_siswa', 'absensikelas.keterangan', 'nama_kelas', 'tgl')
            ->where('sesikelas.tgl', $tgl->toDateString())
            
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('absensikelas.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->groupby('nama_siswa', 'jenjang', 'keterangan', 'nama_kelas', 'tgl', 'absensikelas.id')
        ->get();
        

        return response()->json(
            [

                'dataAbsensiKelas' => $dataAbsensiKelas,
                'tgl' => $tgl,
            ]
        );
        
    }
}
