<?php

namespace App\Http\Controllers\Api;

use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Asramasiswa;
use App\Models\Absensikelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApiSiswaController
{
    public function dataAsrama(Request $request)
    {
        $periode = Periode::select('id')
            ->latest('created_at')
            ->first();

        if (!$periode) {
            return response()->json([
                'dataAbsensiKelas' => [],
                'tgl' => now(),
            ]);
        }

        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();

        // 🔥 PRELOAD PESERTA ASRAMA (lebih ringan)
        $pesertaAsrama = Pesertaasrama::query()
            ->whereHas('asramasiswa', function ($q) use ($periode) {
                $q->where('periode_id', $periode->id);
            })
            ->with([
                'siswa:id,nama_siswa',
                'asramasiswa.asrama:id,nama_asrama'
            ])
            ->get()
            ->keyBy('siswa_id');

        // 🔥 ABSENSI QUERY (MINIMAL JOIN)
        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->select([
                'siswa.id as siswa_id',
                'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                'kelasmi.jenjang',
                'absensikelas.keterangan',
                'absensikelas.tgl',
                'absensikelas.id as absensi_id',
            ])
            ->where('kelasmi.periode_id', $periode->id)
            ->whereIn('absensikelas.keterangan', ['sakit', 'izin', 'alfa', 'hadir'])
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get()
            ->map(function ($item) use ($pesertaAsrama) {
                $asrama = $pesertaAsrama[$item->siswa_id] ?? null;
                $item->nama_asrama = $asrama?->asramasiswa?->asrama?->nama_asrama;
                return $item;
            });

        return response()->json([
            'dataAbsensiKelas' => $dataAbsensiKelas,
            'tgl' => $tgl,
        ]);
    }
    public function getDataSiswa()
    {
        $periode = Periode::select('id')
            ->latest('created_at')
            ->first();

        if (!$periode) {
            return response()->json(['siswa' => []]);
        }

        $siswa = Siswa::query()
            ->select([
            'siswa.id',
                'nis.nis',
            'siswa.nama_siswa',
            'siswa.jenis_kelamin',
                'kelasmi.nama_kelas',
            'asrama.nama_asrama'
            ])
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('pesertakelas', function ($q) use ($periode) {
                $q->on('pesertakelas.siswa_id', '=', 'siswa.id')
                    ->where('pesertakelas.periode_id', $periode->id);
            })
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoin('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->leftJoin('asramasiswa', function ($q) use ($periode) {
                $q->on('asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
                    ->where('asramasiswa.periode_id', $periode->id);
            })
            ->leftJoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('kelasmi.periode_id', $periode->id)
            ->get();

        return response()->json(['siswa' => $siswa]);
    }
}
