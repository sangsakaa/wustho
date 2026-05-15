<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Periode;
use App\Models\Absensikelas;
use App\Models\Pesertaasrama;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiSiswaController extends Controller
{
    public function dataAsrama(Request $request)
    {
        $periode = Periode::select('id')->latest('id')->first();

        if (!$periode) {
            return response()->json([
                'dataAbsensiKelas' => [],
                'tgl' => now()->toDateString(),
            ]);
        }

        $tgl = $request->tgl
            ? Carbon::parse($request->tgl)->toDateString()
            : now()->toDateString();

        $pesertaAsrama = Pesertaasrama::query()
            ->whereHas('asramasiswa', function ($q) use ($periode) {
                $q->where('periode_id', $periode->id);
            })
            ->with([
                'siswa:id,nama_siswa',
            'asramasiswa.asrama:id,nama_asrama',
            ])
            ->get()
            ->keyBy('siswa_id');

        $dataAbsensiKelas = Absensikelas::query()
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
            ->whereDate('absensikelas.tgl', $tgl)
            ->whereIn('absensikelas.keterangan', ['sakit', 'izin', 'alfa', 'hadir'])
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get()
            ->map(function ($item) use ($pesertaAsrama) {
            $asrama = $pesertaAsrama->get($item->siswa_id);
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
        $periode = Periode::select('id')->latest('id')->first();

        if (!$periode) {
            return response()->json([
                'siswa' => [],
            ]);
        }

        $siswa = Siswa::query()
            ->select([
                'nis.nis',
            'nis.madrasah_diniyah',
            'nis.tanggal_masuk',
            'siswa.nama_siswa',
            'siswa.jenis_kelamin',
            'siswa.agama',
            'siswa.tempat_lahir',
            'siswa.tanggal_lahir',
            'siswa.kota_asal',
                'kelasmi.nama_kelas',
            'asrama.nama_asrama',
            'kelasmi.periode_id',
            ])
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->join('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoin('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->leftJoin('asramasiswa', function ($q) use ($periode) {
                $q->on('asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
                    ->where('asramasiswa.periode_id', $periode->id);
            })
            ->leftJoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('kelasmi.periode_id', $periode->id)
            ->distinct()
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get()
            ->map(function ($item) {

            $tanggalMasuk = null;

            if (!empty($item->tanggal_masuk) && strtotime($item->tanggal_masuk)) {
                $tanggalMasuk = date('Y-m-d', strtotime($item->tanggal_masuk));
            }

            return [
                    'nis' => $item->nis,
                    'nama_siswa' => $item->nama_siswa,
                'tanggal_masuk' => $tanggalMasuk,
                'madrasah_diniyah' => $item->madrasah_diniyah,
                'nama_lembaga' => 'Wahidiyah',
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'agama' => $item->agama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'kota_asal' => $item->kota_asal,
                    'nama_asrama' => $item->nama_asrama,
                    'nama_kelas' => $item->nama_kelas,
                    'periode_id' => $item->periode_id,
                ];
            });

        return response()->json([
            'siswa' => $siswa,
        ]);
    }
}
