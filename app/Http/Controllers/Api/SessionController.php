<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensikelas;
use App\Models\Periode;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Services\SessionService;

class SessionController extends Controller
{
    public function __construct(
        protected SessionService $service
    ) {}

    public function today()
    {
        $periode = Periode::active()->first();

        if (!$periode) {
            return response()->json([
                'success' => false,
                'message' => 'Periode aktif tidak ditemukan'
            ], 404);
        }

        $sessions = Sesikelas::with('kelasmi')
            ->whereDate('tgl', today())
            ->whereHas('kelasmi', function ($q) use ($periode) {
                $q->where('periode_id', $periode->id);
            })
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'date'    => today()->toDateString(),
            'total'   => $sessions->count(),
            'data'    => $sessions->map(function ($session) {
                return [
                    'id'       => $session->id,
                    'kelas_id' => $session->kelasmi_id,
                    'kelas'    => optional($session->kelasmi)->nama_kelas,
                    'tanggal'  => $session->tgl,
                ];
            }),
        ]);
    }

    public function students(Sesikelas $session)
    {
        /*
        |--------------------------------------------------------------------------
        | Default semua siswa = Hadir
        |--------------------------------------------------------------------------
        */
        $peserta = Pesertakelas::where('kelasmi_id', $session->kelasmi_id)->get();

        foreach ($peserta as $item) {

            Absensikelas::firstOrCreate(
                [
                    'sesikelas_id'    => $session->id,
                    'pesertakelas_id' => $item->id,
                ],
                [
                    'keterangan' => 'Hadir',
                    'alasan'     => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil daftar siswa beserta status presensinya
        |--------------------------------------------------------------------------
        */
        $students = Pesertakelas::with([
            'siswa.nis',
            'absensikelas' => function ($q) use ($session) {
                $q->where('sesikelas_id', $session->id);
            }
        ])
            ->where('kelasmi_id', $session->kelasmi_id)
            ->orderBy('id')
            ->get()
            ->map(function ($peserta) {

                $absen = $peserta->absensikelas->first();

                return [
                    'pesertakelas_id' => $peserta->id,
                    'siswa_id'        => $peserta->siswa->id,
                    'nis'             => optional($peserta->siswa->nis)->nis,
                    'nama'            => $peserta->siswa->nama_siswa,
                    'status'          => optional($absen)->keterangan,
                    'alasan'          => optional($absen)->alasan,
                ];
            });

        return response()->json([
            'success' => true,
            'session' => [
                'id'      => $session->id,
                'kelas'   => $session->kelasmi->nama_kelas,
                'tanggal' => $session->tgl,
            ],
            'total'    => $students->count(),
            'students' => $students,
        ]);
    }
}
