<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Statusanak;
use App\Models\Statuspengamal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiSiswaController extends Controller
{
    /**
     * =========================
     * PARSE TANGGAL (AMAN)
     * =========================
     */
    private function parseTanggal($tgl)
    {
        if (!$tgl) return null;

        // kalau sudah format Y-m-d
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

        foreach ($bulan as $indo => $num) {
            if (str_contains($tgl, $indo)) {
                $tgl = str_replace($indo, $num, $tgl);
                break;
            }
        }

        // sekarang format jadi: 24 04 2021
        $tgl = preg_replace('/\s+/', ' ', trim($tgl));

        try {
            return Carbon::createFromFormat('d m Y', $tgl)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
    /**
     * =========================
     * SYNC DATA API → DATABASE
     * =========================
     */
    public function sinkron()
    {
        $response = Http::withHeaders([
            'X-API-KEY' => 'sPbM_SMeDi-8Vq3N-xK7pL-2dR9t-U6aH4mZ1',
            'Accept'    => 'application/json',
        ])->timeout(60)
            ->get('https://spmb.kedunglo.com/api/public/siswa');
            

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data API',
                'status'  => $response->status(),
            ], 400);
        }

        $dataSiswa = $response->json();
        $total = 0;

        foreach ($dataSiswa as $siswa) {

            CalonSiswa::updateOrCreate(
                [
                    'api_id' => $siswa['id'] ?? null,
                ],
                [
                    // JENJANG
                    'jenjang_id'    => $siswa['jenjang']['id'] ?? null,
                    'jenjang'       => $siswa['jenjang']['name'] ?? null,
                    'jenjang_title' => $siswa['jenjang']['title'] ?? null,

                    // DATA DASAR
                    'nomor_pendaftaran' => $siswa['nomorPendaftaran'] ?? null,
                    'nama'              => $siswa['nama_lengkap'] ?? null,
                    'jenis_kelamin'     => $siswa['jenis_kelamin'] ?? null,

                    // KELUARGA
                    'anak_ke'                 => $siswa['anak_ke'] ?? null,
                    'jumlah_saudara_kandung'  => $siswa['jumlah_saudara_kandung'] ?? null,

                    // IDENTITAS
                    'nisn'      => $siswa['nisn'] ?? null,
                    'nis'       => $siswa['nis'] ?? null,
                    'nik'       => $siswa['nik'] ?? null,
                    'nomor_kk'  => $siswa['nomor_kk'] ?? null,
                    'no_kip'    => $siswa['no_kip'] ?? null,
                    'npsn'      => $siswa['npsn'] ?? null,

                    // LAHIR
                    'tempat_lahir'  => $siswa['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $this->parseTanggal($siswa['tanggal_lahir'] ?? null),

                    // AGAMA & NEGARA
                    'agama'           => $siswa['agama'] ?? null,
                    'kewarganegaraan' => $siswa['kewarganegaraan'] ?? null,

                    // PENDIDIKAN
                    'rencana_pendidikan' => $siswa['rencana_pendidikan'] ?? null,

                    // ALAMAT
                    'alamat_jalan' => $siswa['alamat_jalan'] ?? null,
                    'nama_dusun'   => $siswa['nama_dusun'] ?? null,
                    'rt'           => $siswa['rt'] ?? null,
                    'rw'           => $siswa['rw'] ?? null,
                    'kode_pos'     => $siswa['kode_pos'] ?? null,

                    // FISIK
                    'tinggi_badan'   => $siswa['tinggi_badan'] ?? null,
                    'berat_badan'    => $siswa['berat_badan'] ?? null,
                    'lingkar_kepala' => $siswa['lingkar_kepala'] ?? null,

                    // STATUS
                    'status' => $siswa['status'] ?? null,
                    'no_registrasi_akta' => $siswa['no_registrasi_akta'] ?? null,

                    // RELASI
                    'user_id'  => $siswa['user'] ?? null,
                    'tapel_id' => $siswa['tapel'] ?? null,

                    'kelurahan_desa'    => $siswa['kelurahan_desa'] ?? null,
                    'riwayat_kesehatan' => $siswa['riwayatKesehatan'] ?? null,
                    'kebutuhan_khusus'  => $siswa['kebutuhanKhusus'] ?? null,

                    'asal_sekolah' => $siswa['sekolah_asal'] ?? null,

                    // META
                    'ip'         => $siswa['ip'] ?? null,
                    'user_agent' => $siswa['user_agent'] ?? null,

                    // RAW
                    'data_api' => $siswa,
                ]
            );

            $total++;
        }

        return redirect('/calon-siswa')
            ->with('success', "Sinkron berhasil: {$total} data");
    }

    /**
     * =========================
     * VIEW + FILTER
     * =========================
     */
    public function view(Request $request)
{
    $query = CalonSiswa::query();

    // SEARCH
    if ($request->search) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // JENJANG
    if ($request->jenjang) {
        $query->where('jenjang', $request->jenjang);
    }

    // STATUS FILTER
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $data = $query->latest()->paginate(20)->withQueryString();

    // ================= DASHBOARD STAT =================
    $stats = [
        'all' => CalonSiswa::count(),
        'calon' => CalonSiswa::where('status', 'calon-siswa')->count(),
        'dipindah' => CalonSiswa::where('status', 'dipindah_ke_siswa')->count(),
        'briva' => CalonSiswa::where('status', 'done-briva')->count(),
    ];

    return view('calon_siswa.index', compact('data', 'stats'));
}
    public function liveSync(Request $request)
    {
        try {
            $host = $request->getHost();
            $path = $request->path(); // calon-siswa

            // default
            $jenjangFilter = null;
            $lembagaName   = null;

            // LOCALHOST
            if (app()->environment('local') || in_array($host, ['127.0.0.1', 'localhost'])) {
                $jenjangFilter = 'SMA';
                $lembagaName   = 'LOCAL';
            }

            // DOMAIN WUSTHO (SMA)
            elseif ($host === 'wustho.smedi.my.id') {
                $jenjangFilter = 'SMA';
                $lembagaName   = 'Wustho';
            }

            // DOMAIN ULA (SMP)
            elseif ($host === 'ula.smedi.my.id') {
                $jenjangFilter = 'SMP';
                $lembagaName   = 'Ula';
            }

            $response = Http::withHeaders([
                'X-API-KEY' => 'sPbM_SMeDi-8Vq3N-xK7pL-2dR9t-U6aH4mZ1',
                'Accept'    => 'application/json',
            ])->timeout(60)->get('https://spmb.kedunglo.com/api/public/siswa');

            if (!$response->ok()) {
                return back()->with('error', 'API gagal diakses: ' . $response->status());
            }

            $dataSiswa = $response->json();
            $total = 0;

            foreach ($dataSiswa as $siswa) {

                $jenjangName = $siswa['jenjang']['name'] ?? null;

                // filter jenjang sesuai domain
                if ($jenjangFilter && $jenjangName !== $jenjangFilter) {
                    continue;
                }

                $tanggalLahir = $this->parseTanggal($siswa['tanggal_lahir'] ?? null);

                CalonSiswa::updateOrCreate(
                    [
                        'api_id' => $siswa['id'] ?? null,
                    ],
                    [
                        'jenjang_id'    => $siswa['jenjang']['id'] ?? null,
                        'jenjang'       => $jenjangName,
                        'jenjang_title' => $siswa['jenjang']['title'] ?? null,

                        'lembaga'       => $lembagaName, // 🔥 penting (Ula / Wustho)

                        'nomor_pendaftaran' => $siswa['nomorPendaftaran'] ?? null,
                        'nama'              => $siswa['nama_lengkap'] ?? null,
                        'jenis_kelamin'     => $siswa['jenis_kelamin'] ?? null,

                        'anak_ke' => $siswa['anak_ke'] ?? null,
                        'jumlah_saudara_kandung' => $siswa['jumlah_saudara_kandung'] ?? null,

                        'nisn' => $siswa['nisn'] ?? null,
                        'nis'  => $siswa['nis'] ?? null,
                        'nik'  => $siswa['nik'] ?? null,

                        'nomor_kk' => $siswa['nomor_kk'] ?? null,
                        'no_kip'   => $siswa['no_kip'] ?? null,

                        'tempat_lahir'  => $siswa['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $tanggalLahir,

                        'agama'           => $siswa['agama'] ?? null,
                        'kewarganegaraan' => $siswa['kewarganegaraan'] ?? null,

                        'rencana_pendidikan' => $siswa['rencana_pendidikan'] ?? null,

                        'alamat_jalan' => $siswa['alamat_jalan'] ?? null,
                        'rt'           => $siswa['rt'] ?? null,
                        'rw'           => $siswa['rw'] ?? null,
                        'kode_pos'     => $siswa['kode_pos'] ?? null,

                        'status' => 'calon-siswa',
                        'tapel_id' => $siswa['tapel'] ?? null,
                        'user_id'  => $siswa['user'] ?? null,

                        'asal_sekolah' => $siswa['sekolah_asal'] ?? null,

                        'ip'         => $siswa['ip'] ?? null,
                        'user_agent' => $siswa['user_agent'] ?? null,

                        'data_api' => $siswa,
                    ]
                );

                $total++;
            }

            return redirect('/calon-siswa')
                ->with('success', "Live sync {$lembagaName} berhasil: $total data");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    private function getTanggalMasukSemester()
    {
        $year = now()->year;

        return [
            'ganjil' => $year . '-07-01',
            'genap'  => $year . '-01-01',
        ];
    }
    public function pushToSiswa($calonSiswaId)
    {
        $calon = CalonSiswa::findOrFail($calonSiswaId);

        // =========================
        // CEGAH PUSH DUA KALI
        // =========================
        if ($calon->status === 'dipindah_ke_siswa') {
            return back()->with(
                'warning',
                'Data calon siswa sudah pernah dipindahkan.'
            );
        }

        // =========================
        // VALIDASI DATA MINIMAL
        // =========================
        $missing = [];

        if (!$calon->nama) $missing[] = 'nama';
        if (!$calon->jenis_kelamin) $missing[] = 'jenis_kelamin';
        if (!$calon->tempat_lahir) $missing[] = 'tempat_lahir';
        if (!$calon->tanggal_lahir) $missing[] = 'tanggal_lahir';

        if (count($missing)) {
            return back()->with(
                'warning',
                'Data belum lengkap: ' . implode(', ', $missing)
            );
        }

        // =========================
        // SIMPAN KE TABEL SISWA
        // =========================
        $siswa = Siswa::create([
            'nama_siswa'     => $calon->nama,
            'jenis_kelamin'  => $calon->jenis_kelamin,
            'agama'          => $calon->agama,
            'tempat_lahir'   => $calon->tempat_lahir,
            'tanggal_lahir'  => $calon->tanggal_lahir,
            'kota_asal'      => $calon->alamat_jalan,
        ]);

        // =========================
        // SIMPAN NIS
        // =========================
        if ($calon->nis) {

            // Jenjang dari API
            $jenjangApi = strtoupper(trim($calon->jenjang));

            // Konversi ke Madrasah Diniyah
            $mappingJenjang = [
                'SMP' => 'Ula',
                'SMA' => 'Wustho',
            ];

            $jenjang = $mappingJenjang[$jenjangApi] ?? null;

            // Kode Jenjang NIS
            $kodeJenjang = [
                'Ula'    => '01',
                'Wustho' => '02',
                'Ulya'   => '03',
            ];

            $kode = $kodeJenjang[$jenjang] ?? '00';

            $tahun = date('Y');

            // Ambil NIS terakhir
            // Cari NIS terakhir berdasarkan tahun + jenjang
            $prefix = $tahun . $kode;

            $last = Nis::where('nis', 'like', $prefix . '%')
                ->orderByDesc('nis')
                ->first();

            if ($last) {

                // Ambil nomor urut setelah prefix YYYYKK
                $lastNumber = (int) substr($last->nis, strlen($prefix));

                $nextNumber = $lastNumber + 1;
            } else {

                // Jika tahun + jenjang belum ada data
                $nextNumber = 1;
            }

            $nisBaru = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $nisBaru = $tahun . $kode . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            Nis::create([
                'siswa_id'          => $siswa->id,
                'nis'               => $nisBaru,
                'nama_lembaga'      => 'Wahidiyah',
                'madrasah_diniyah'  => $jenjang,
                'tanggal_masuk'     => $this->getTanggalMasukSemester()['ganjil'],
            ]);
        }

        // =========================
        // STATUS PENGAMAL
        // =========================
        Statuspengamal::create([
            'siswa_id'        => $siswa->id,
            'status_pengamal' => 'Pengamal'
        ]);

        // =========================
        // STATUS ANAK
        // =========================
        Statusanak::create([
            'siswa_id'        => $siswa->id,
            'status_anak'     => null,
            'anak_ke'         => $calon->anak_ke,
            'jumlah_saudara'  => $calon->jumlah_saudara_kandung,
            'nama_ayah'       => null,
            'nama_ibu'        => null,
            'pekerjaan_ayah'  => null,
            'pekerjaan_ibu'   => null,
            'nomor_hp_ayah'   => null,
            'nomor_hp_ibu'    => null,
        ]);

        // =========================
        // UPDATE STATUS CALON SISWA
        // =========================
        $calon->update([
            'status' => 'dipindah_ke_siswa'
        ]);

        return back()->with(
            'success',
            'Data berhasil dipindahkan ke tabel siswa'
        );
    }
    public function resetStatus(CalonSiswa $calonSiswa)
    {
        try {

            $calonSiswa->update([
                'status' => 'calon-siswa'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil dikembalikan menjadi calon siswa.',
                'data' => [
                    'id' => $calonSiswa->id,
                    'status' => $calonSiswa->status
                ]
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
