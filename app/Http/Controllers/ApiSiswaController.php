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
    private function getJenjangDomain()
    {
        $host = request()->getHost();

        // LOCAL = semua
        if (
            app()->environment('local') ||
            in_array($host, ['localhost', '127.0.0.1'])
        ) {
            return null;
        }

        if ($host === 'ula.smedi.my.id') {
            return 'SMP';
        }

        if ($host === 'wustho.smedi.my.id') {
            return 'SMA';
        }

        return null;
    }
    public function view(Request $request)
    {
        $query = CalonSiswa::query();

        $jenjangDomain = $this->getJenjangDomain();

        // Filter domain
        if ($jenjangDomain) {
            $query->where('jenjang', $jenjangDomain);
        }

        // Search
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query
            ->orderBy('nama')
            ->paginate(20)
            ->withQueryString();

        $statQuery = CalonSiswa::query();

        if ($jenjangDomain) {
            $statQuery->where('jenjang', $jenjangDomain);
        }

        $stats = [
            'all'      => (clone $statQuery)->count(),
            'calon'    => (clone $statQuery)->where('status', 'calon-siswa')->count(),
            'dipindah' => (clone $statQuery)->where('status', 'dipindah_ke_siswa')->count(),
            'briva'    => (clone $statQuery)->where('status', 'done-briva')->count(),
        ];

        return view('calon_siswa.index', compact('data', 'stats'));
    }
    public function liveSync(Request $request)
    {
        try {

            $jenjangDomain = $this->getJenjangDomain();

            $response = Http::withHeaders([
                'X-API-KEY' => 'sPbM_SMeDi-8Vq3N-xK7pL-2dR9t-U6aH4mZ1',
                'Accept'    => 'application/json',
            ])->timeout(60)->get(
                'https://spmb.kedunglo.com/api/public/siswa'
            );

            if (!$response->ok()) {
                return back()->with(
                    'error',
                    'API gagal diakses: ' . $response->status()
                );
            }

            $dataSiswa = $response->json();

            $total = 0;

            foreach ($dataSiswa as $siswa) {

                $jenjangName = strtoupper(
                    trim($siswa['jenjang']['name'] ?? '')
                );

                // Tolak selain SMP/SMA
                if (!in_array($jenjangName, ['SMP', 'SMA'])) {
                    continue;
                }

                // Domain filter
                if (
                    $jenjangDomain &&
                    $jenjangName !== $jenjangDomain
                ) {
                    continue;
                }

                $tanggalLahir = $this->parseTanggal(
                    $siswa['tanggal_lahir'] ?? null
                );

                CalonSiswa::updateOrCreate(
                    [
                        'api_id' => $siswa['id'] ?? null,
                    ],
                    [
                        'jenjang_id'    => $siswa['jenjang']['id'] ?? null,
                        'jenjang'       => $jenjangName,
                        'jenjang_title' => $siswa['jenjang']['title'] ?? null,

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

            return back()->with(
                'success',
                "Live Sync berhasil : {$total} data"
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
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
        $jenjangDomain = $this->getJenjangDomain();

        if (
            $jenjangDomain &&
            strtoupper($calon->jenjang) !== $jenjangDomain
        ) {
            return back()->with(
                'warning',
                'Data tidak sesuai dengan domain aktif.'
            );
        }

        // =========================
        // CEGAH PUSH DUA KALI
        // =========================
        if ($calon->status === 'dipindah_ke_siswa') {
            return back()->with('warning', 'Data sudah pernah dipindahkan.');
        }

        // =========================
        // VALIDASI MINIMAL
        // =========================
        $missing = [];

        if (!$calon->nama) $missing[] = 'nama';
        if (!$calon->jenis_kelamin) $missing[] = 'jenis_kelamin';
        if (!$calon->tempat_lahir) $missing[] = 'tempat_lahir';
        if (!$calon->tanggal_lahir) $missing[] = 'tanggal_lahir';

        if (!empty($missing)) {
            return back()->with(
                'warning',
                'Data belum lengkap: ' . implode(', ', $missing)
            );
        }

        // =========================
        // CEK SUDAH ADA SISWA?
        // =========================
        $existingSiswa = Siswa::where('nama_siswa', $calon->nama)
            ->whereDate('tanggal_lahir', $calon->tanggal_lahir)
            ->first();

        if ($existingSiswa) {
            return back()->with(
                'warning',
                'Siswa dengan nama dan tanggal lahir yang sama sudah ada.'
            );
        }

        // =========================
        // SIMPAN SISWA
        // =========================
        $siswa = Siswa::create([
            'nama_siswa'    => $calon->nama,
            'jenis_kelamin' => $calon->jenis_kelamin,
            'agama'         => $calon->agama,
            'tempat_lahir'  => $calon->tempat_lahir,
            'tanggal_lahir' => $calon->tanggal_lahir,
            'kota_asal'     => $calon->alamat_jalan,
        ]);

        // =========================
        // NORMALISASI JENJANG
        // =========================
        $rawJenjang = strtoupper(trim($calon->jenjang ?? ''));

        if (str_contains($rawJenjang, 'SMP')) {

            $jenjang = 'Ula';
            $kodeJenjang = '03';
        } elseif (str_contains($rawJenjang, 'SMA')) {

            $jenjang = 'Wustho';
            $kodeJenjang = '02';
        } else {

            return back()->with(
                'warning',
                'Jenjang tidak dikenali: ' . ($calon->jenjang ?? '-')
            );
        }

        // =========================
        // GENERATE NIS
        // FORMAT:
        // YYYY + KK + NNNNN
        // 2026 + 01 + 00001
        // =========================
        $tahun = date('Y');

        $prefix = $tahun . $kodeJenjang;

        $lastNis = Nis::where('nis', 'like', $prefix . '%')
            ->orderBy('nis', 'desc')
            ->first();

        if ($lastNis) {

            $lastNumber = (int) substr(
                $lastNis->nis,
                strlen($prefix)
            );

            $nextNumber = $lastNumber + 1;
        } else {

            $nextNumber = 1;
        }

        $nisBaru = $prefix .
            str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );

        // =========================
        // SIMPAN NIS
        // =========================
        Nis::create([
            'siswa_id'         => $siswa->id,
            'nis'              => $nisBaru,
            'nama_lembaga'     => 'Wahidiyah',
            'madrasah_diniyah' => $jenjang,
            'tanggal_masuk'    => $this->getTanggalMasukSemester()['ganjil'],
        ]);

        // =========================
        // STATUS PENGAMAL
        // =========================
        Statuspengamal::create([
            'siswa_id'        => $siswa->id,
            'status_pengamal' => 'Pengamal',
        ]);

        // =========================
        // STATUS ANAK
        // =========================
        Statusanak::create([
            'siswa_id'       => $siswa->id,
            'status_anak'    => null,
            'anak_ke'        => $calon->anak_ke,
            'jumlah_saudara' => $calon->jumlah_saudara_kandung,
        ]);

        // =========================
        // UPDATE STATUS CALON SISWA
        // =========================
        $calon->update([
            'status' => 'dipindah_ke_siswa',
        ]);

        return back()->with(
            'success',
            "Berhasil dipindahkan ke siswa. NIS: {$nisBaru}"
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
