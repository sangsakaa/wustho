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

        $query = CalonSiswa::query()
            ->leftJoin('provinces', function ($join) {
                $join->on(
                    'provinces.code',
                    '=',
                    DB::raw("LEFT(CAST(calon_siswas.kelurahan_desa AS CHAR),2)")
                );
            })
            ->leftJoin('regencies', function ($join) {
                $join->on(
                    'regencies.code',
                    '=',
                    DB::raw("
                    CONCAT(
                        LEFT(CAST(calon_siswas.kelurahan_desa AS CHAR),2),
                        '.',
                        SUBSTRING(CAST(calon_siswas.kelurahan_desa AS CHAR),3,2)
                    )
                ")
                );
            })
            ->select(
                'calon_siswas.*',
                'provinces.name as provinsi',
                'regencies.name as kabupaten'
            );

        // FILTER DOMAIN
        if ($domain) {
            $query->where('calon_siswas.jenjang', $domain);
        }

        // FILTER JENJANG
        if ($request->filled('jenjang')) {
            $query->where('calon_siswas.jenjang', $request->jenjang);
        }

        // SEARCH
        if ($request->filled('search')) {
            $query->where('calon_siswas.nama', 'like', '%' . $request->search . '%');
        }

        // STATUS FILTER
        if ($request->filled('status')) {
            $query->where('calon_siswas.status', $request->status);
        }

        // RENCANA PENDIDIKAN FILTER (JSON)
        if ($request->filled('rencana_pendidikan')) {
            $query->whereRaw("
            JSON_UNQUOTE(JSON_EXTRACT(calon_siswas.data_api, '$.rencana_pendidikan')) = ?
        ", [$request->rencana_pendidikan]);
        }

        $data = $query
            ->orderByDesc('calon_siswas.id')
            ->paginate(20)
            ->withQueryString();

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
        $chartProvinsi = CalonSiswa::query()
            ->leftJoin('provinces', function ($join) {
                $join->on(
                    'provinces.code',
                    '=',
                    DB::raw("LEFT(CAST(calon_siswas.kelurahan_desa AS CHAR),2)")
                );
            })
            ->select(
                'provinces.name',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('provinces.name')
            ->orderByDesc('total')
            ->get();

        $chartKabupaten = CalonSiswa::query()
            ->leftJoin('regencies', function ($join) {
                $join->on(
                    'regencies.code',
                    '=',
                    DB::raw("
                CONCAT(
                    LEFT(CAST(calon_siswas.kelurahan_desa AS CHAR),2),
                    '.',
                    SUBSTRING(CAST(calon_siswas.kelurahan_desa AS CHAR),3,2)
                )
            ")
                );
            })
            ->select(
                'regencies.name',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('regencies.name')
            ->orderByDesc('total')
            ->get();

        return view('calon_siswa.index', compact(
            'data',
            'stats',
            'domain',
            'chartProvinsi',
            'chartKabupaten'
        ));
    }
    /* ================= LIVE SYNC ================= */
    public function liveSync()
    {
        try {

            $response = Http::withHeaders([
                'X-API-KEY' => self::API_KEY,
                'Accept'    => 'application/json',
            ])->timeout(60)->get(self::API_URL);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API gagal : ' . $response->status(),
                ], 500);
            }

            /*
        |--------------------------------------------------------------------------
        | Decode JSON dengan aman untuk BIGINT
        |--------------------------------------------------------------------------
        */

            $students = json_decode(
                $response->body(),
                true,
                512,
                JSON_BIGINT_AS_STRING
            );

            $domain = $this->getJenjangDomain();

            $total = 0;

            foreach ($students as $item) {

                $jenjang = strtoupper(trim(data_get($item, 'jenjang.name')));

                // Hanya SMP dan SMA
                if (!isset(self::JENJANG_MAP[$jenjang])) {
                    continue;
                }

                // Filter domain
                if ($domain && $domain !== $jenjang) {
                    continue;
                }

                $apiId = data_get($item, 'id');

                $calon = CalonSiswa::firstOrNew([
                    'api_id' => $apiId,
                ]);

                /*
            |--------------------------------------------------------------------------
            | Simpan status lama
            |--------------------------------------------------------------------------
            */

                $status = $calon->exists
                    ? $calon->status
                    : 'calon-siswa';

                /*
            |--------------------------------------------------------------------------
            | BIGINT SAFE
            |--------------------------------------------------------------------------
            */

                $kelurahanDesa = data_get($item, 'kelurahan_desa');

                if (is_array($kelurahanDesa)) {
                    $kelurahanDesa = $kelurahanDesa['id']
                        ?? $kelurahanDesa['value']
                        ?? null;
                }

                if ($kelurahanDesa !== null) {
                    $kelurahanDesa = (string) $kelurahanDesa;
                }

                $calon->fill([

                    'jenjang'                  => $jenjang,
                    'jenjang_id'               => data_get($item, 'jenjang.id'),

                    'nama'                     => data_get($item, 'nama_lengkap'),
                    'jenis_kelamin'            => data_get($item, 'jenis_kelamin'),

                    'rencana_pendidikan'       => data_get($item, 'rencana_pendidikan'),

                    'jumlah_saudara_kandung'   => data_get($item, 'jumlah_saudara_kandung'),
                    'anak_ke'                  => data_get($item, 'anak_ke'),

                    'nisn'                     => data_get($item, 'nisn'),
                    'nis'                      => data_get($item, 'nis'),
                    'nik'                      => data_get($item, 'nik'),
                    'nomor_kk'                 => data_get($item, 'nomor_kk'),
                    'no_kip'                   => data_get($item, 'no_kip'),
                    'npsn'                     => data_get($item, 'npsn'),
                    'alumni'                   => data_get($item, 'alumni'),

                    'tempat_lahir'             => data_get($item, 'tempat_lahir'),
                    'tanggal_lahir'            => $this->parseTanggal(
                        data_get($item, 'tanggal_lahir')
                    ),

                    'agama'                    => data_get($item, 'agama'),
                    'kewarganegaraan'          => data_get($item, 'kewarganegaraan'),

                    'alamat_jalan'             => data_get($item, 'alamat_jalan'),
                    'nama_dusun'               => data_get($item, 'nama_dusun'),
                    'rt'                       => data_get($item, 'rt'),
                    'rw'                       => data_get($item, 'rw'),
                    'kode_pos'                 => data_get($item, 'kode_pos'),

                    'tinggi_badan'             => data_get($item, 'tinggi_badan'),
                    'berat_badan'              => data_get($item, 'berat_badan'),
                    'lingkar_kepala'           => data_get($item, 'lingkar_kepala'),

                    'no_registrasi_akta'       => data_get($item, 'no_registrasi_akta'),

                    // Sesuaikan dengan nama field API
                    'user_id'                  => data_get($item, 'user'),
                    'tapel_id'                 => data_get($item, 'tapel'),

                    'kelurahan_desa'           => $kelurahanDesa,

                    'riwayat_kesehatan'        => data_get($item, 'riwayatKesehatan'),
                    'kebutuhan_khusus'         => data_get($item, 'kebutuhanKhusus'),

                    'asal_sekolah'             => data_get($item, 'sekolah_asal'),

                    'user_agent'               => data_get($item, 'user_agent'),
                    'ip'                       => data_get($item, 'ip'),

                    'data_api'                 => $item,
                ]);

                // Status tetap dipertahankan
                $calon->status = $status;

                $calon->save();

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
    public function pushToSiswa($id)
    {
        DB::beginTransaction();

        try {

            $calon = CalonSiswa::lockForUpdate()->findOrFail($id);

            // Cek apakah sudah dipindahkan
            if ($calon->status === 'dipindah_ke_siswa') {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sudah dipindahkan.'
                ], 422);
            }

            $jenjang = strtoupper(trim($calon->jenjang));

            $map = [
                'SMP' => [
                    'kode'      => '03',
                    'madrasah'  => 'Ula',
                ],
                'SMA' => [
                    'kode'      => '02',
                    'madrasah'  => 'Wustho',
                ],
            ];

            if (!isset($map[$jenjang])) {
                throw new \Exception("Jenjang {$jenjang} tidak dikenali.");
            }

            $kode = $map[$jenjang]['kode'];

            /*
        |--------------------------------------------------------------------------
        | Generate NIS
        |--------------------------------------------------------------------------
        */

            $tahun = now()->year;

            if ($kode == '03') {

                // ===========================
                // ULA
                // Format : 2303001
                // ===========================

                $prefix = substr($tahun, -2) . $kode;

                $last = Nis::where('nis', 'like', $prefix . '%')
                    ->lockForUpdate()
                    ->orderByDesc('nis')
                    ->first();

                if ($last) {
                    $urut = (int) substr($last->nis, -3) + 1;
                } else {
                    $urut = 1;
                }

                $nis = $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
            } else {

                // ===========================
                // WUSTHO
                // Format : 20240200001
                // ===========================

                $prefix = $tahun . $kode;

                $last = Nis::where('nis', 'like', $prefix . '%')
                    ->lockForUpdate()
                    ->orderByDesc('nis')
                    ->first();

                if ($last) {
                    $urut = (int) substr($last->nis, -5) + 1;
                } else {
                    $urut = 1;
                }

                $nis = $prefix . str_pad($urut, 5, '0', STR_PAD_LEFT);
            }

            /*
        |--------------------------------------------------------------------------
        | Simpan Siswa
        |--------------------------------------------------------------------------
        */

            $siswa = Siswa::create([

                'nama_siswa'      => $calon->nama,
                'jenis_kelamin'   => $calon->jenis_kelamin,
                'agama'           => $calon->agama ?: 'Islam',
                'tempat_lahir'    => $calon->tempat_lahir,
                'tanggal_lahir'   => $calon->tanggal_lahir,
                'kota_asal'       => $calon->alamat_jalan,

            ]);

            /*
        |--------------------------------------------------------------------------
        | Simpan NIS
        |--------------------------------------------------------------------------
        */

            Nis::create([

                'siswa_id'          => $siswa->id,
                'nis'               => $nis,
                'nama_lembaga'      => 'Wahidiyah',
                'madrasah_diniyah'  => $map[$jenjang]['madrasah'],
                'tanggal_masuk'     => now()->toDateString(),

            ]);

            /*
        |--------------------------------------------------------------------------
        | Status Pengamal
        |--------------------------------------------------------------------------
        */

            Statuspengamal::create([

                'siswa_id'         => $siswa->id,
                'status_pengamal'  => 'Pengamal',

            ]);

            /*
        |--------------------------------------------------------------------------
        | Status Anak
        |--------------------------------------------------------------------------
        */

            Statusanak::create([

                'siswa_id'         => $siswa->id,
                'anak_ke'          => $calon->anak_ke,
                'jumlah_saudara'   => $calon->jumlah_saudara_kandung,

            ]);

            /*
        |--------------------------------------------------------------------------
        | Update Status Calon
        |--------------------------------------------------------------------------
        */

            $calon->update([

                'status' => 'dipindah_ke_siswa',

            ]);

            DB::commit();

            return response()->json([

                'success' => true,
                'message' => 'Calon siswa berhasil dipindahkan.',

                'data' => [

                    'siswa_id' => $siswa->id,
                    'nis'      => $nis,
                    'jenjang'  => $jenjang,

                ]

            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error('PUSH TO SISWA', [

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
    /* ================= RESET ================= */
    public function resetStatus(CalonSiswa $calon)
    {
        DB::transaction(function () use ($calon) {

            // Cari siswa yang berasal dari calon ini
            $siswa = Siswa::where('nama_siswa', $calon->nama)->first();

            if ($siswa) {

                Nis::where('siswa_id', $siswa->id)->delete();
                Statuspengamal::where('siswa_id', $siswa->id)->delete();
                Statusanak::where('siswa_id', $siswa->id)->delete();

                $siswa->delete();
            }

            // Reset status calon
            $calon->update([
                'status' => 'calon-siswa'
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil direset.',
            'data' => [
                'status' => 'calon-siswa'
            ]
        ]);
    }
}
