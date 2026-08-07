<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Nis;
use App\Models\Periode;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $periode = Periode::where('is_active', 1)->firstOrFail();

        $kelasList = Kelasmi::with('periode')
            ->where('periode_id', $periode->id)
            ->withCount('pesertakelas')
            ->orderBy('nama_kelas')
            ->get();

        return view('qr.index', compact('kelasList'));
    }
    public function monitor($sesiId)
    {
        $sesi = Sesikelas::with('kelasmi')->findOrFail($sesiId);

        // semua peserta di kelas ini
        $peserta = Pesertakelas::with('siswa.NisTerakhir')
            ->where('kelasmi_id', $sesi->kelasmi_id)
            ->orderBy('id')
            ->get();

        // ambil absensi terakhir per peserta untuk sesi ini
        $absensi = Absensikelas::where('sesikelas_id', $sesiId)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->unique('pesertakelas_id')
            ->keyBy('pesertakelas_id');

        $data = $peserta->map(function ($item) use ($absensi) {
            $absen = $absensi->get($item->id);

            return [
                'peserta_id' => $item->id,
                'nama'       => $item->siswa?->nama_siswa ?? '-',
                'nis'        => $item->siswa?->NisTerakhir?->nis ?? '-',
                'status'     => $absen?->keterangan ?? 'belum',
                'waktu'      => $absen?->updated_at?->format('H:i:s'),
            ];
        });

        // urutan: belum -> hadir -> lainnya
        $urutan = [
            'belum' => 1,
            'hadir' => 2,
            'izin'  => 3,
            'sakit' => 4,
            'alfa'  => 5,
        ];

        $data = $data->sortBy(function ($row) use ($urutan) {
            return $urutan[$row['status']] ?? 99;
        })->values();

        return view('presensi.monitor', compact('sesi', 'data'));
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
        $folder = public_path('qrcodes');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $generated = 0;
        $skipped = 0;

        Siswa::with('NisTerakhir')
            ->whereHas('NisTerakhir')
            ->chunk(100, function ($siswas) use (
                $folder,
                &$generated,
                &$skipped
            ) {
            foreach ($siswas as $siswa) {
                $nis = $siswa->NisTerakhir->nis;
                $filepath = "{$folder}/{$nis}.png";

                if (File::exists($filepath)) {
                    $skipped++;
                    continue;
                }

                File::put(
                    $filepath,
                    QrCode::format('png')
                        ->size(300)
                        ->margin(2)
                        ->generate($nis)
                );

                $generated++;
            }
            });

        return back()->with(
            'success',
            "Selesai. Baru: {$generated}, Skip: {$skipped}"
        );
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

            // ambil NIS + siswa
            $nis = Nis::with('siswa')->where('nis', $request->nis)->first();

            if (!$nis || !$nis->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS tidak ditemukan'
                ], 404);
            }

            $siswaId = $nis->siswa_id;

            // periode aktif
            $periode = Periode::where('is_active', 1)->first();
            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode aktif tidak ditemukan'
                ], 404);
            }

            // peserta kelas (WAJIB join periode benar)
            $peserta = Pesertakelas::where('siswa_id', $siswaId)
                ->whereHas('kelasmi', function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id);
                })
                ->first();

            if (!$peserta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak terdaftar di kelas aktif'
                ], 404);
            }

            // sesi hari ini berdasarkan kelas siswa
            $sesi = Sesikelas::where('kelasmi_id', $peserta->kelasmi_id)
                ->whereDate('tgl', now()->toDateString())
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

            // cek sudah absen
            $exists = Absensikelas::where('sesikelas_id', $sesi->id)
                ->where('pesertakelas_id', $peserta->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Sudah absen hari ini',
                    'data' => [
                        'nama' => $nis->siswa->nama_siswa,
                        'nis'  => $nis->nis
                    ]
                ], 409);
            }

            // simpan absen default HADIR
            $absen = Absensikelas::create([
                'pesertakelas_id' => $peserta->id,
                'sesikelas_id'    => $sesi->id,
                'keterangan'      => 'hadir',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil dicatat',
                'data' => [
                    'nama' => $nis->siswa->nama_siswa,
                    'nis'  => $nis->nis
                ],
                'absen_id' => $absen->id
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

    public function scanAttendance(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
        ]);

        try {

            // Cari NIS
            $nis = Nis::with('siswa')
                ->where('nis', $request->nis)
                ->first();

            if (!$nis || !$nis->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR / NIS tidak ditemukan',
                ], 404);
            }

            // Periode aktif
            $periode = Periode::where('is_active', 1)->first();

            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode aktif tidak ditemukan',
                ], 404);
            }

            // Peserta kelas
            $peserta = Pesertakelas::where('siswa_id', $nis->siswa_id)
                ->whereHas('kelasmi', function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id);
                })
                ->first();

            if (!$peserta) {

                return response()->json([
                    'success' => false,
                    'debug' => [
                        'nis' => $request->nis,
                        'siswa_id' => $nis->siswa_id,
                        'periode_aktif' => $periode->id,
                        'jumlah_peserta_siswa' => Pesertakelas::where('siswa_id', $nis->siswa_id)->count(),
                        'data_peserta' => Pesertakelas::where('siswa_id', $nis->siswa_id)->get(),
                    ],
                    'message' => 'Siswa tidak terdaftar pada kelas aktif',
                ], 404);
            }

            // Cari sesi hari ini
            $sesi = Sesikelas::where('kelasmi_id', $peserta->kelasmi_id)
                ->whereDate('tgl', today())
                ->latest()
                ->first();

            if (!$sesi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi presensi hari ini belum dibuat',
                ], 404);
            }

            if ($sesi->status != 'open') {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi presensi sudah ditutup',
                ], 403);
            }

            // Sudah absen?
            $exists = Absensikelas::where('sesikelas_id', $sesi->id)
                ->where('pesertakelas_id', $peserta->id)
                ->first();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa sudah melakukan presensi',
                    'data' => [
                        'nama' => $nis->siswa->nama_siswa,
                        'nis'  => $nis->nis,
                        'status' => $exists->keterangan,
                    ],
                ], 409);
            }

            // Simpan hadir
            $absen = Absensikelas::create([
                'pesertakelas_id' => $peserta->id,
                'sesikelas_id'    => $sesi->id,
                'keterangan'      => 'hadir',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil',
                'data' => [
                    'id' => $absen->id,
                    'nama' => $nis->siswa->nama_siswa,
                    'nis' => $nis->nis,
                    'kelas' => optional($peserta->kelasmi)->nama_kelas,
                    'status' => 'Hadir',
                    'jam' => now()->format('H:i:s'),
                ],
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
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

        // ambil semua sesi hari ini (jangan hanya 1)
        $sesiIds = Sesikelas::whereHas('kelasmi', function ($q) use ($periode) {
            $q->where('periode_id', $periode->id);
        })
            ->whereDate('tgl', now()->toDateString())
            ->pluck('id');

        if ($sesiIds->isEmpty()) {
            return response()->json([]);
        }

        $log = Absensikelas::with([
            'pesertakelas.siswa.NisTerakhir',
            'pesertakelas.kelasmi'
        ])
            ->whereIn('sesikelas_id', $sesiIds)
            ->latest()
            ->get()
            ->groupBy('pesertakelas_id') // pakai groupBy biar aman
            ->map(function ($items) {
                $a = $items->first(); // ambil absen terakhir

                return [
                    'nama'  => $a->pesertakelas->siswa->nama_siswa ?? '-',
                    'nis'   => $a->pesertakelas->siswa->NisTerakhir->nis ?? '-',
                'kelas' => optional(optional($a->pesertakelas)->kelasmi)->nama_kelas ?? '-',
                    'waktu' => $a->created_at->format('H:i:s'),
                ];
            })
            ->values();

        return response()->json($log);
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
    public function kartuLoginPdfAll()
    {
        $siswas = Siswa::with('NisTerakhir')
            ->whereHas('kelasTerakhir.KelasMi.periode', function ($q) {
                $q->where('is_active', 1);
            })
            ->whereHas('NisTerakhir')
            ->get();
    }
    public function kartuLoginPdfKelas($kelasId)
    {
        $kelas = Kelasmi::with('periode')->findOrFail($kelasId);

        $peserta = Pesertakelas::with([
            'siswa.NisTerakhir'
        ])
            ->where('kelasmi_id', $kelasId)
            ->orderBy('id')
            ->get();

        if ($peserta->isEmpty()) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        $dataSiswa = $peserta->map(function ($item) {

            $siswa = $item->siswa;

            if (!$siswa || !$siswa->NisTerakhir) {
                return null;
            }

            $nis = $siswa->NisTerakhir->nis;

            $qr = base64_encode(
                QrCode::format('svg')
                    ->size(120)
                    ->margin(1)
                    ->generate($nis)
            );

            return [
                'siswa' => $siswa,
                'nis'   => $nis,
                'qr'    => $qr,
            ];
        })->filter()->values();

        $pdf = Pdf::loadView('kartu.login-kolektif', [
            'dataSiswa' => $dataSiswa,
            'kelas'     => $kelas->nama_kelas,
            'periode'   => $kelas->periode->periode,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream(
            'kartu-login-' . $kelas->nama_kelas . '.pdf'
        );
    }

    public function manualAbsen(Request $request)
    {
        $request->validate([
            'pesertakelas_id' => 'required',
            'sesikelas_id'    => 'required',
            'status'          => 'required|in:hadir,izin,sakit,alfa',
        ]);

        // cek apakah sudah ada absensi
        $absen = Absensikelas::where('pesertakelas_id', $request->pesertakelas_id)
            ->where('sesikelas_id', $request->sesikelas_id)
            ->first();

        if ($absen) {

            // update status
            $absen->update([
                'keterangan' => $request->status,
            ]);
        } else {

            // create baru
            Absensikelas::create([
                'pesertakelas_id' => $request->pesertakelas_id,
                'sesikelas_id'    => $request->sesikelas_id,
                'keterangan'      => $request->status,
            ]);
        }

        return back()->with('success', 'Absensi berhasil diperbarui');
    }
    public function statistic()
    {
        $periode = Periode::where('is_active', 1)->first();

        if (!$periode) {
            return response()->json([
                'success' => false,
                'message' => 'Periode aktif tidak ditemukan',
            ]);
        }

        // Semua kelas periode aktif
        $kelasIds = Kelasmi::where('periode_id', $periode->id)
            ->pluck('id');

        // Total peserta
        $total = Pesertakelas::whereIn('kelasmi_id', $kelasIds)
            ->count();

        // Semua sesi hari ini
        $sesi = Sesikelas::whereIn('kelasmi_id', $kelasIds)
            ->whereDate('tgl', today())
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'close',
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alfa' => 0,
                    'belum' => $total,
                    'total' => $total,
                ]
            ]);
        }

        $sesiIds = Sesikelas::whereIn('kelasmi_id', $kelasIds)
            ->whereDate('tgl', today())
            ->pluck('id');

        // Hadir
        $hadir = Absensikelas::whereIn('sesikelas_id', $sesiIds)
            ->whereRaw('LOWER(keterangan)="hadir"')
            ->distinct('pesertakelas_id')
            ->count('pesertakelas_id');

        // Izin
        $izin = Absensikelas::whereIn('sesikelas_id', $sesiIds)
            ->whereRaw('LOWER(keterangan)="izin"')
            ->distinct('pesertakelas_id')
            ->count('pesertakelas_id');

        // Sakit
        $sakit = Absensikelas::whereIn('sesikelas_id', $sesiIds)
            ->whereRaw('LOWER(keterangan)="sakit"')
            ->distinct('pesertakelas_id')
            ->count('pesertakelas_id');

        // Alfa
        $alfa = Absensikelas::whereIn('sesikelas_id', $sesiIds)
            ->whereRaw('LOWER(keterangan)="alfa"')
            ->distinct('pesertakelas_id')
            ->count('pesertakelas_id');

        // Belum presensi
        $belum = max($total - ($hadir + $izin + $sakit + $alfa), 0);

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $sesi->status,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alfa' => $alfa,
                'belum' => $belum,
                'total' => $total,
            ]
        ]);
    }
}
