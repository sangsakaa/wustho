<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Statusanak;
use App\Models\Statuspengamal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Log;

class ApiSiswaController extends Controller
{
    /* ================= CONFIG ================= */
    private const API_URL = 'https://spmb.kedunglo.com/api/public/siswa';
    private const API_KEY = 'sPbM_SMeDi-8Vq3N-xK7pL-2dR9t-U6aH4mZ1';

    private const JENJANG_MAP = [
        'SMP' => ['kode' => '03', 'madrasah' => 'Ula'],
        'SMA' => ['kode' => '02', 'madrasah' => 'Wustho'],
    ];

    /* ================= INDEX ================= */
    public function index(Request $request)
    {
        return $this->view($request);
    }

    /* ================= PARSE TANGGAL ================= */
    private function parseTanggal($tgl)
    {
        if (!$tgl) return null;

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
            return $tgl;
        }

        $bulan = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        $tgl = str_replace(array_keys($bulan), array_values($bulan), $tgl);
        $tgl = preg_replace('/\s+/', ' ', trim($tgl));

        try {
            return Carbon::createFromFormat('d m Y', $tgl)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    /* ================= DOMAIN ================= */
    private function getJenjangDomain()
    {
        $host = request()->getHost();

        if (app()->environment('local')) return null;

        return match ($host) {
            'ula.smedi.my.id' => 'SMP',
            'wustho.smedi.my.id' => 'SMA',
            default => null,
        };
    }

    /* ================= VIEW ================= */
    public function view(Request $request)
    {
        $domain = $this->getJenjangDomain();

        $query = CalonSiswa::query();

        // FILTER DOMAIN
        if ($domain) {
            $query->where('jenjang', $domain);
        }

        // FILTER JENJANG
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // STATUS FILTER
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // RENCANA PENDIDIKAN FILTER (JSON)
        if ($request->filled('rencana_pendidikan')) {
            $query->whereRaw("
            JSON_UNQUOTE(JSON_EXTRACT(data_api, '$.rencana_pendidikan')) = ?
        ", [$request->rencana_pendidikan]);
        }

        $data = $query->latest()->paginate(20)->withQueryString();

        // ================= BASE STAT QUERY =================
        $base = CalonSiswa::query();

        if ($domain) {
            $base->where('jenjang', $domain);
        }

        // helper function json count
        $countRencana = function ($value, $jenjang = null, $status = null) use ($base) {
            $q = (clone $base);

            if ($jenjang) {
                $q->where('jenjang', $jenjang);
            }

            if ($status) {
                $q->where('status', $status);
            }

            return $q->whereRaw("
            JSON_UNQUOTE(JSON_EXTRACT(data_api, '$.rencana_pendidikan')) = ?
        ", [$value])->count();
        };

        $stats = [
            // umum
            'all'   => (clone $base)->count(),
            'SMP'   => (clone $base)->where('jenjang', 'SMP')->count(),
            'SMA'   => (clone $base)->where('jenjang', 'SMA')->count(),

            // status
            'calon' => (clone $base)->where('status', 'calon-siswa')->count(),
            'dipindah' => (clone $base)->where('status', 'dipindah_ke_siswa')->count(),

            // rencana global
            'mondok' => $countRencana('Mondok'),
            'tidak_mondok' => $countRencana('Tidak Mondok'),

            // per jenjang SMP
            'smp_mondok' => $countRencana('Mondok', 'SMP'),
            'smp_tidak_mondok' => $countRencana('Tidak Mondok', 'SMP'),
            'smp_calon' => (clone $base)->where('jenjang', 'SMP')->where('status', 'calon-siswa')->count(),
            'smp_dipindah' => (clone $base)->where('jenjang', 'SMP')->where('status', 'dipindah_ke_siswa')->count(),

            // per jenjang SMA
            'sma_mondok' => $countRencana('Mondok', 'SMA'),
            'sma_tidak_mondok' => $countRencana('Tidak Mondok', 'SMA'),
            'sma_calon' => (clone $base)->where('jenjang', 'SMA')->where('status', 'calon-siswa')->count(),
            'sma_dipindah' => (clone $base)->where('jenjang', 'SMA')->where('status', 'dipindah_ke_siswa')->count(),
        ];

        return view('calon_siswa.index', compact('data', 'stats', 'domain'));
    }
    /* ================= LIVE SYNC ================= */
    public function liveSync()
    {
        try {

            $response = Http::withHeaders([
                'X-API-KEY' => self::API_KEY,
                'Accept'    => 'application/json',
            ])->timeout(60)->get(self::API_URL);


            // DEBUG FULL RESPONSE
            // dd([
            //     'status'  => $response->status(),
            //     'headers' => $response->headers(),
            //     'body'    => $response->body(),
            //     'json'    => $response->json(),
            // ]);
            // 

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API gagal : ' . $response->status(),
                ], 500);
            }


            // DEBUG FULL RESPONSE

            $students = $response->json();

            $domain = $this->getJenjangDomain();

            $total = 0;

            foreach ($students as $item) {

                $jenjang = strtoupper(
                    trim(data_get($item, 'jenjang.name'))
                );

                // hanya SMP atau SMA
                if (!isset(self::JENJANG_MAP[$jenjang])) {
                    continue;
                }

                // filter domain
                if ($domain && $domain !== $jenjang) {
                    continue;
                }

                $existing = CalonSiswa::where('api_id', data_get($item, 'id'))->first();

                $status = $existing?->status === 'dipindah_ke_siswa'
                    ? 'dipindah_ke_siswa'
                    : 'calon-siswa';

                CalonSiswa::updateOrCreate(
                    [
                        'api_id' => data_get($item, 'id'),
                    ],
                    [
                        'jenjang'        => $jenjang,
                        'jenjang_id'     => data_get($item, 'jenjang.id'),
                        'nama'           => data_get($item, 'nama_lengkap'),
                        'jenis_kelamin'  => data_get($item, 'jenis_kelamin'),
                        'rencana_pendidikan'  => data_get($item, 'rencana_pendidikan'),
                        'jumlah_saudara_kandung'  => data_get($item, 'jumlah_saudara_kandung'),
                        'anak_ke'  => data_get($item, 'anak_ke'),
                        'nisn'           => data_get($item, 'nisn'),
                        'nis'            => data_get($item, 'nis'),
                        'nik'            => data_get($item, 'nik'),
                        'tempat_lahir'   => data_get($item, 'tempat_lahir'),
                        'tanggal_lahir'  => $this->parseTanggal(data_get($item, 'tanggal_lahir')),
                        'agama'          => data_get($item, 'agama'),
                        'alamat_jalan'   => data_get($item, 'alamat_jalan'),
                        'tapel_id'   => data_get($item, 'tapel_id'),
                        'status'         => $status,
                        'data_api'       => $item,
                    ]
                );

                $total++;
            }

            return response()->json([
                'success' => true,
                'message' => "Sync berhasil {$total} data {$domain}",
            ]);
        } catch (\Throwable $e) {

            \Log::error('SYNC ERROR', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function debugSync()
    {
        try {

            $response = Http::withHeaders([
                'X-API-KEY' => self::API_KEY,
                'Accept'    => 'application/json',
            ])->timeout(60)->get(self::API_URL);

            return response()->json([
                'success'    => $response->successful(),
                'status'     => $response->status(),
                'headers'    => $response->headers(),
                'total_data' => count($response->json() ?? []),
                'sample'     => collect($response->json())->take(3),
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }
    /* ================= GENERATE NIS ================= */
    private function generateNis($kode)
    {
        $prefix = date('Y') . $kode;

        $last = Nis::where('nis', 'like', $prefix . '%')
            ->orderByDesc('nis')
            ->first();

        $next = $last
            ? ((int) substr($last->nis, strlen($prefix))) + 1
            : 1;

        return $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    /* ================= PUSH TO SISWA ================= */
    /* ================= PUSH TO SISWA ================= */
    public function pushToSiswa($id)
    {
        try {

            DB::beginTransaction();

            $calon = CalonSiswa::lockForUpdate()->findOrFail($id);

            // Sudah dipindahkan
            if ($calon->status === 'dipindah_ke_siswa') {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sudah dipindahkan'
                ], 422);
            }

            // Ambil jenjang dari data calon siswa
            $jenjang = strtoupper(trim($calon->jenjang));

            $map = [
                'SMP' => [
                    'kode' => '03',
                    'madrasah' => 'Ula',
                ],
                'SMA' => [
                    'kode' => '02',
                    'madrasah' => 'Wustho',
                ],
            ];

            if (!isset($map[$jenjang])) {
                throw new \Exception("Jenjang {$jenjang} tidak dikenali");
            }

            // Generate NIS sesuai jenjang
            $nis = $this->generateNis($map[$jenjang]['kode']);

            // Simpan siswa
            $siswa = Siswa::create([
                'nama_siswa'     => $calon->nama,
                'jenis_kelamin'  => $calon->jenis_kelamin,
                'agama'          => $calon->agama ?: 'Islam',
                'tempat_lahir'   => $calon->tempat_lahir,
                'tanggal_lahir'  => $calon->tanggal_lahir,
                'kota_asal'      => $calon->alamat_jalan ?: 'Tidak diketahui',
            ]);

            // Simpan NIS
            Nis::create([
                'siswa_id'         => $siswa->id,
                'nis'              => $nis,
                'nama_lembaga'     => 'Wahidiyah',
                'madrasah_diniyah' => $map[$jenjang]['madrasah'],
                'tanggal_masuk'    => now()->toDateString(),
            ]);

            // Status Pengamal
            Statuspengamal::create([
                'siswa_id' => $siswa->id,
                'status_pengamal' => 'Pengamal',
            ]);

            // Status Anak
            Statusanak::create([
                'siswa_id'       => $siswa->id,
                'anak_ke'        => $calon->anak_ke,
                'jumlah_saudara' => $calon->jumlah_saudara_kandung,
            ]);

            // Update status calon
            $calon->update([
                'status' => 'dipindah_ke_siswa'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dipindahkan ke siswa',
                'data' => [
                    'siswa_id' => $siswa->id,
                    'nis'      => $nis,
                    'jenjang'  => $jenjang,
                    'status'   => 'dipindah_ke_siswa',
                ]
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error('PUSH SISWA ERROR', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }
    /* ================= RESET ================= */
    public function resetStatus(CalonSiswa $calon)
    {
        $calon->update(['status' => 'calon-siswa']);

        return response()->json([
            'success' => true,
            'message' => 'Reset berhasil',
            'data' => [
                'status' => 'calon-siswa'
            ]
        ]);
    }
}
