<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Services\SessionService;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(
        protected SessionService $service
    ) {}

    public function today()
    {
        try {

            $periode = Periode::active()->first();

            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode aktif tidak ditemukan'
                ], 404);
            }

            $sessions = Sesikelas::with([
                'kelasmi',
                'kelasmi.pesertakelas'
            ])
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

                    $sudahAbsen = $hadir + $izin + $sakit + $alfa;

                    $totalSiswa = Pesertakelas::where(
                        'kelasmi_id',
                        $session->kelasmi_id
                    )->count();

                    return [

                        'id' => $session->id,

                        'kelas_id' => $session->kelasmi_id,

                        'kelas' => optional($session->kelasmi)->nama_kelas,

                        'tanggal' => $session->tgl,

                        'total_siswa' => $totalSiswa,

                        'sudah_absen' => $sudahAbsen,

                        'belum_absen' => max($totalSiswa - $sudahAbsen, 0),

                        'hadir' => $hadir,

                        'izin' => $izin,

                        'sakit' => $sakit,

                        'alfa' => $alfa,

                        'status' => $sudahAbsen >= $totalSiswa && $totalSiswa > 0
                            ? 'selesai'
                            : 'belum',

                        'selesai' => $sudahAbsen >= $totalSiswa && $totalSiswa > 0,

                        'progress' => $totalSiswa > 0
                            ? round(($sudahAbsen / $totalSiswa) * 100)
                            : 0,
                    ];
                })->values(),
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
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
                    : null,

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

        // Ambil periode aktif
        $periode = Periode::where('is_active', 1)->first();

        if (!$periode) {
            return response()->json([
                'success' => false,
                'message' => 'Periode aktif tidak ditemukan'
            ], 404);
        }

        // Ambil semua kelas pada periode aktif
        $kelas = Kelasmi::where('periode_id', $periode->id)
            ->orderBy('nama_kelas')
            ->get();

        if ($kelas->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kelas pada periode aktif',
                'debug' => [
                    'periode_id' => $periode->id,
                ]
            ]);
        }

        // Cari sesi yang sudah ada
        $existing = Sesikelas::whereDate('tgl', $request->tgl)
            ->whereIn('kelasmi_id', $kelas->pluck('id'))
            ->pluck('kelasmi_id')
            ->toArray();

        $insert = [];

        foreach ($kelas as $item) {

            if (!in_array($item->id, $existing)) {

                $insert[] = [
                    'tgl'         => $request->tgl,
                    'kelasmi_id'  => $item->id,
                    'status'      => 'open',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        if (empty($insert)) {

            return response()->json([
                'success' => false,
                'message' => 'Semua sesi sudah tersedia',
                'debug' => [
                    'periode_id'   => $periode->id,
                    'jumlah_kelas' => $kelas->count(),
                    'jumlah_sesi'  => count($existing),
                ]
            ]);
        }

        Sesikelas::insert($insert);

        return response()->json([
            'success' => true,
            'message' => count($insert) . ' sesi berhasil dibuat',
            'debug' => [
                'periode_id'   => $periode->id,
                'jumlah_kelas' => $kelas->count(),
                'dibuat'       => count($insert),
            ]
        ]);
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'session_id'        => ['required', 'exists:sesikelas,id'],
            'peserta_kelas_id'  => ['required', 'exists:pesertakelas,id'],
            'status'            => ['required', 'in:hadir,izin,sakit,alfa'],
            'alasan'            => ['nullable', 'string'],
        ]);

        try {

            $absen = Absensikelas::updateOrCreate(

                [
                    'sesikelas_id'   => $request->session_id,
                    'pesertakelas_id' => $request->peserta_kelas_id,
                ],

                [
                    'keterangan' => ucfirst(strtolower($request->status)),
                    'alasan'     => $request->alasan,
                ]

            );

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil disimpan',
                'data' => [
                    'id' => $absen->id,
                    'status' => strtolower($absen->keterangan),
                ]
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }
}
