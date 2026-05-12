<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Nis;
use App\Models\Periode;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $siswas = Siswa::with([
            'NisTerakhir',
            'kelasTerakhir.KelasMi.periode'
        ])
            ->whereHas('kelasTerakhir.KelasMi.periode', function ($q) {
                $q->where('is_active', 1);
            })
            ->orderBy('nama_siswa')
            ->paginate(20);

        return view('qr.index', compact('siswas'));
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE PER SISWA
    |--------------------------------------------------------------------------
    */
    public function generate($id)
    {
        $siswa = Siswa::with('NisTerakhir')->findOrFail($id);

        if (!$siswa->NisTerakhir) {
            return back()->with('error', 'NIS siswa tidak ditemukan');
        }

        $folder = public_path('qrcodes');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $filename = $siswa->NisTerakhir->nis . '.png';
        $filepath = $folder . '/' . $filename;

        if (!File::exists($filepath)) {
            $qr = QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->generate($siswa->NisTerakhir->nis);

            File::put($filepath, $qr);
        }

        return back()->with('success', 'QR berhasil dibuat / sudah tersedia');
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE ALL
    |--------------------------------------------------------------------------
    */
    public function generateAll()
    {
        $siswas = Siswa::with([
            'NisTerakhir',
            'kelasTerakhir.KelasMi.periode'
        ])
            ->whereHas('kelasTerakhir.KelasMi.periode', function ($q) {
                $q->where('is_active', 1);
            })
            ->get();

        $folder = public_path('qrcodes');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $generated = 0;
        $skipped = 0;

        foreach ($siswas as $siswa) {
            if (!$siswa->NisTerakhir) continue;

            $filename = $siswa->NisTerakhir->nis . '.png';
            $filepath = $folder . '/' . $filename;

            if (File::exists($filepath)) {
                $skipped++;
                continue;
            }

            $qr = QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->generate($siswa->NisTerakhir->nis);

            File::put($filepath, $qr);
            $generated++;
        }

        return back()->with('success', "Selesai. Baru: {$generated}, Skip: {$skipped}");
    }

    /*
    |--------------------------------------------------------------------------
    | SCAN PAGE
    |--------------------------------------------------------------------------
    */
    public function scan()
    {
        return view('presensi.asrama.Qrsesiasrama');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE SCAN (FINAL FIXED VERSION)
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required|string'
            ]);

            $nis = Nis::with('siswa')->where('nis', $request->nis)->first();

            if (!$nis) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS tidak ditemukan'
                ], 404);
            }

            $siswaId = $nis->siswa_id;

            $periode = Periode::where('is_active', 1)->first();

            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode aktif tidak ditemukan'
                ], 404);
            }

            $sesi = Sesikelas::query()
                ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
                ->where('kelasmi.periode_id', $periode->id)
                ->whereDate('sesikelas.tgl', Carbon::today())
                ->select('sesikelas.*')
                ->latest()
                ->first();

            if (!$sesi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi presensi belum dibuat'
                ], 404);
            }

            if ($sesi->status !== 'open') {
                return response()->json([
                    'success' => false,
                    'message' => 'Presensi sudah ditutup'
                ], 403);
            }

            $peserta = Pesertakelas::query()
                ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
                ->where('pesertakelas.siswa_id', $siswaId)
                ->where('kelasmi.periode_id', $periode->id)
                ->select('pesertakelas.*')
                ->first();

            if (!$peserta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak terdaftar di kelas aktif'
                ], 404);
            }

            /*
        |--------------------------------------------------------------------------
        | CEK SUDAH ABSEN
        |--------------------------------------------------------------------------
        */
            $absen = Absensikelas::where([
                'sesikelas_id' => $sesi->id,
                'pesertakelas_id' => $peserta->id
            ])->first();

            if ($absen) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Sudah absen hari ini',
                    'data' => [
                        'nama' => $nis->siswa->nama_siswa ?? '-',
                        'nis'  => $nis->nis
                    ]
                ], 409);
            }
            /*
        |--------------------------------------------------------------------------
        | SIMPAN ABSEN
        |--------------------------------------------------------------------------
        */
            $new = Absensikelas::create([
                'pesertakelas_id' => $peserta->id,
                'sesikelas_id'    => $sesi->id,
                'keterangan'      => 'hadir',
                'alasan'          => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil dicatat',
                'data' => [
                    'nama' => $nis->siswa->nama_siswa ?? '-',
                    'nis'  => $nis->nis
                ],
                'canUndo' => true,
                'absen_id' => $new->id
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | CREATE SESI HARI INI
    |--------------------------------------------------------------------------
    */
    public function createSessionToday()
    {
        $periode = Periode::where('is_active', 1)->first();

        if (!$periode) {
            return back()->with('error', 'Periode aktif tidak ditemukan');
        }

        $kelasList = \App\Models\Kelasmi::where('periode_id', $periode->id)->get();

        $created = 0;
        $skipped = 0;

        foreach ($kelasList as $kelas) {

            $exists = Sesikelas::where('kelasmi_id', $kelas->id)
                ->whereDate('tgl', now()->toDateString())
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Sesikelas::create([
                'kelasmi_id' => $kelas->id,
                'tgl' => now()->toDateString(),
                'status' => 'open',
            ]);

            $created++;
        }

        return back()->with('success', "Sesi dibuat: {$created}, dilewati: {$skipped}");
    }
    public function todayLog()
    {
        $periode = Periode::where('is_active', 1)->first();

        if (!$periode) {
            return response()->json([]);
        }

        $sesi = Sesikelas::whereHas('kelasmi', function ($q) use ($periode) {
            $q->where('periode_id', $periode->id);
        })
            ->whereDate('tgl', now()->toDateString())
            ->latest()
            ->first();

        if (!$sesi) {
            return response()->json([]);
        }

        $log = Absensikelas::with([
            'pesertakelas.siswa.NisTerakhir',
            'pesertakelas.kelasmi' // penting
        ])
            ->where('sesikelas_id', $sesi->id)
            ->latest()
            ->get()
            ->unique('pesertakelas_id')
            ->values()
            ->map(function ($a) {
                return [
                    'nama'  => $a->pesertakelas->siswa->nama_siswa ?? '-',
                    'nis'   => $a->pesertakelas->siswa->NisTerakhir->nis ?? '-',
                    'kelas' => $a->pesertakelas->kelasmi->nama_kelas ?? '-',
                    'waktu' => $a->created_at->format('H:i:s'),
                ];
            });

        return response()->json($log);
    }
    public function monitor($sesiId)
    {
        $sesi = Sesikelas::with('kelasmi')->findOrFail($sesiId);

        $peserta = Pesertakelas::with('siswa.NisTerakhir')
            ->where('kelasmi_id', $sesi->kelasmi_id)
            ->get();

        $absensi = Absensikelas::where('sesikelas_id', $sesiId)
            ->get()
            ->keyBy('pesertakelas_id');

        $data = $peserta->map(function ($p) use ($absensi) {
            $a = $absensi->get($p->id);

            return [
                'peserta_id' => $p->id,
                'nama' => $p->siswa->nama_siswa ?? '-',
                'nis' => $p->siswa->NisTerakhir->nis ?? '-',
                'status' => $a ? $a->keterangan : 'belum',
                'waktu' => $a ? $a->created_at : null,
            ];
        });

        return view('presensi.monitor', [
            'sesi' => $sesi,
            'data' => $data
        ]);
    }
    public function manualAbsen(Request $request)
    {
        $request->validate([
            'pesertakelas_id' => 'required',
            'sesikelas_id' => 'required',
            'status' => 'required|in:hadir,izin,sakit,alfa'
        ]);

        $exists = Absensikelas::where('pesertakelas_id', $request->pesertakelas_id)
            ->where('sesikelas_id', $request->sesikelas_id)
            ->first();

        if ($exists) {
            $exists->update([
                'keterangan' => $request->status
            ]);
        } else {
            Absensikelas::create([
                'pesertakelas_id' => $request->pesertakelas_id,
                'sesikelas_id' => $request->sesikelas_id,
                'keterangan' => $request->status
            ]);
        }

        return back()->with('success', 'Absensi berhasil diperbarui');
    }
    public function ensureTodaySession()
    {
        $periode = Periode::where('is_active', 1)->first();

        $kelasList = \App\Models\Kelasmi::where('periode_id', $periode->id)->get();

        foreach ($kelasList as $kelas) {
            Sesikelas::firstOrCreate([
                'kelasmi_id' => $kelas->id,
                'tgl' => now()->toDateString(),
            ], [
                'status' => 'open'
            ]);
        }
    }
    public function closeSession($id)
    {

        $sesi = Sesikelas::findOrFail($id);

        if ($sesi->status === 'close') {
            return back()->with('error', 'Sesi sudah ditutup');
        }

        $sesi->update([
            'status' => 'close'
        ]);

        return back()->with('success', 'Sesi berhasil ditutup');
    }
    public function kartuLoginPdf($id)
    {
        $siswa = Siswa::with('NisTerakhir')->findOrFail($id);

        if (!$siswa->NisTerakhir) {
            return back()->with('error', 'NIS tidak ditemukan');
        }

        $nis = $siswa->NisTerakhir->nis;

        // generate QR base64 (tanpa simpan file)
        $qr = base64_encode(
            QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->generate($nis)
        );

        $data = [
            'siswa' => $siswa,
            'nis' => $nis,
            'qr' => $qr,
        ];

        $pdf = Pdf::loadView('kartu.login', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('kartu-login-' . $nis . '.pdf');
    }
    public function bulkCloseSession(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $updated = Sesikelas::whereIn('id', $request->ids)
            ->update([
                'status' => 'close'
            ]);

        return back()->with('success', $updated . ' sesi berhasil ditutup');
    }
}
