<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Nis;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use App\Models\Siswa;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
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

            /*
            |--------------------------------------------------------------------------
            | 1. CEK NIS
            |--------------------------------------------------------------------------
            */
            $nis = Nis::with('siswa')->where('nis', $request->nis)->first();

            if (!$nis) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS tidak ditemukan'
                ], 404);
            }

            $siswaId = $nis->siswa_id;

            /*
            |--------------------------------------------------------------------------
            | 2. PERIODE AKTIF
            |--------------------------------------------------------------------------
            */
            $periode = Periode::where('is_active', 1)->first();

            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periode aktif tidak ditemukan'
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | 3. CEK SESI
            |--------------------------------------------------------------------------
            */
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

            /*
            |--------------------------------------------------------------------------
            | CEK STATUS SESI
            |--------------------------------------------------------------------------
            */
            if ($sesi->status !== 'open') {
                return response()->json([
                    'success' => false,
                    'message' => 'Presensi sudah ditutup'
                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. CEK PESERTA
            |--------------------------------------------------------------------------
            */
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
            | 5. CEK DOUBLE ABSEN
            |--------------------------------------------------------------------------
            */
            $exists = Absensikelas::where('sesikelas_id', $sesi->id)
                ->where('pesertakelas_id', $peserta->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa sudah melakukan presensi'
                ], 409);
            }

            /*
            |--------------------------------------------------------------------------
            | 6. SIMPAN ABSENSI
            |--------------------------------------------------------------------------
            */
            Absensikelas::create([
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
                ]
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
}
