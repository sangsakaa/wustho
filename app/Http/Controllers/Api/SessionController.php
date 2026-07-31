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


        try {

            // isi method

        } catch (\Throwable $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], 500);
        }
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

                $query = Absensikelas::where('sesikelas_id', $session->id);

                $hadir = (clone $query)->whereRaw('LOWER(keterangan)="hadir"')->count();
                $izin  = (clone $query)->whereRaw('LOWER(keterangan)="izin"')->count();
                $sakit = (clone $query)->whereRaw('LOWER(keterangan)="sakit"')->count();
                $alfa  = (clone $query)->whereRaw('LOWER(keterangan)="alfa"')->count();

                return [
                    'id'       => $session->id,
                    'kelas_id' => $session->kelasmi_id,
                    'kelas'    => optional($session->kelasmi)->nama_kelas,
                    'tanggal'  => $session->tgl,

                    'total' => $hadir + $izin + $sakit + $alfa,
                    'hadir' => $hadir,
                    'izin'  => $izin,
                    'sakit' => $sakit,
                    'alfa'  => $alfa,
                ];
            }),
        ]);
    }

    public function students(Sesikelas $session)
    {
        $students = Pesertakelas::with([
            'siswa.nis',
            'absensikelas' => function ($q) use ($session) {
                $q->where('sesikelas_id', $session->id);
            }
        ])
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->where('pesertakelas.kelasmi_id', $session->kelasmi_id)
            ->orderBy('siswa.nama_siswa', 'asc')
            ->select('pesertakelas.*')
            ->get()
            ->map(function ($peserta) {

                $absen = $peserta->absensikelas->first();

                return [
                    'pesertakelas_id' => $peserta->id,
                    'siswa_id'        => $peserta->siswa->id,
                    'nis'             => optional($peserta->siswa->nis)->nis,
                    'nama'            => $peserta->siswa->nama_siswa,

                'status' => $absen
                    ? strtolower($absen->keterangan)
                    : 'hadir',

                'alasan'     => $absen?->alasan,
                'is_saved'   => $absen !== null,
                'updated_at' => optional($absen)->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'session' => [
                'id'      => $session->id,
                'kelas'   => optional($session->kelasmi)->nama_kelas,
                'tanggal' => $session->tgl,
            ],
            'total'    => $students->count(),
            'students' => $students,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tgl' => ['required', 'date'],
        ]);

        // jika periode disimpan di user
        $periodeId = auth()->user()->periode_id;

        // atau jika masih tetap 1
        // $periodeId = 1;

        $kelas = Kelasmi::where('periode_id', $periodeId)
            ->orderBy('nama_kelas')
            ->get();

        $existing = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->whereDate('sesikelas.tgl', $request->tgl)
            ->pluck('sesikelas.kelasmi_id')
            ->toArray();

        $existing = array_flip($existing);

        $insert = [];

        foreach ($kelas as $item) {

            if (!isset($existing[$item->id])) {

                $insert[] = [
                    'tgl' => $request->tgl,
                    'kelasmi_id' => $item->id,
                    'status' => 'open',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (count($insert) == 0) {

            return response()->json([
                'success' => false,
                'message' => 'Semua sesi sudah tersedia'
            ]);
        }

        Sesikelas::insert($insert);

        return response()->json([
            'success' => true,
            'message' => count($insert) . ' sesi berhasil dibuat'
        ]);
    }
}
