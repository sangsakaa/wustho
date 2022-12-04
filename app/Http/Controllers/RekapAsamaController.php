<?php

namespace App\Http\Controllers;


use App\Models\Presensiasrama;

class RekapAsamaController
{
    public function RekapHarian()
    {
        $datarekap = Presensiasrama::query()
            ->join('sesiasrama', 'sesiasrama.id', '=', 'presensiasrama.sesiasrama_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->join('pesertaasrama', 'pesertaasrama.id', '=', 'presensiasrama.pesertaasrama_id')
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->get();
        return view(
            'presensi/asrama/rekapitulasi',
            [
                'DataPresensi' => $datarekap
            ]
        );
    }
}
