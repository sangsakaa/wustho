<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Periode;
use App\Models\Absensikelas;
use App\Models\Pesertaasrama;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="API Manajemen Siswa dan Asrama",
 *     version="1.0.0",
 *     description="Kumpulan endpoint API untuk mengelola data akademik siswa, absensi kelas, dan integrasi data asrama."
 * )
 */
class ApiSiswaController extends Controller
{
    /**
     * Mengambil data absensi kelas beserta informasi asrama siswa pada tanggal tertentu.
     * 
     * Endpoint ini memuat data absensi berdasarkan periode aktif terbaru. Jika tanggal tidak 
     * dikirimkan dalam request, sistem akan menggunakan tanggal hari ini secara default. Data 
     * asrama digabungkan secara dinamis menggunakan mapping berbasis `siswa_id`.
     *
     * @OA\Get(
     *     path="/api/siswa/data-asrama",
     *     summary="Get data absensi kelas dan asrama",
     *     tags={"Siswa"},
     *     @OA\Parameter(
     *         name="tgl",
     *         in="query",
     *         description="Tanggal absensi (Format: YYYY-MM-DD). Default: Hari ini.",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operasi berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="dataAbsensiKelas", type="array", @OA\Items()),
     *             @OA\Property(property="tgl", type="string", example="2026-05-16")
     *         )
     *     )
     * )
     *
     * @param Request $request Object request yang membawa parameter query 'tgl'
     * @return JsonResponse Menghasilkan JSON berisi data absensi dan tanggal aktif
     */
    public function dataAsrama(Request $request): JsonResponse
    {
        // Mendapatkan periode aktif paling terbaru
        $periode = Periode::select('id')->latest('id')->first();

        // Guard clause: jika periode belum dikonfigurasi di database
        if (!$periode) {
            return response()->json([
                'dataAbsensiKelas' => [],
                'tgl' => now()->toDateString(),
            ]);
        }

        // Normalisasi parameter tanggal. Gunakan Form Request di masa depan untuk validasi ini.
        $tgl = $request->tgl
            ? Carbon::parse($request->tgl)->toDateString()
            : now()->toDateString();

        // Eager loading data peserta asrama pada periode aktif untuk menghindari N+1 Problem
        $pesertaAsrama = Pesertaasrama::query()
            ->whereHas('asramasiswa', function ($q) use ($periode) {
                $q->where('periode_id', $periode->id);
            })
            ->with([
                'siswa:id,nama_siswa',
            'asramasiswa.asrama:id,nama_asrama',
            ])
            ->get()
            ->keyBy('siswa_id'); // Indexing menggunakan siswa_id untuk mempercepat pencarian data di memory

        // Mengambil data absensi gabungan dari tabel pesertakelas, siswa, dan kelasmi
        $dataAbsensiKelas = Absensikelas::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->select([
                'siswa.id as siswa_id',
                'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                'kelasmi.jenjang',
                'absensikelas.keterangan',
                'absensikelas.tgl',
                'absensikelas.id as absensi_id',
            ])
            ->where('kelasmi.periode_id', $periode->id)
            ->whereDate('absensikelas.tgl', $tgl)
            ->whereIn('absensikelas.keterangan', ['sakit', 'izin', 'alfa', 'hadir'])
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get()
            ->map(function ($item) use ($pesertaAsrama) {
            // Menyuntikkan nama_asrama secara dinamis dari data koleksi pesertaAsrama yang sudah di-cache di memory
            $asrama = $pesertaAsrama->get($item->siswa_id);
                $item->nama_asrama = $asrama?->asramasiswa?->asrama?->nama_asrama;

            return $item;
            });

        return response()->json([
            'dataAbsensiKelas' => $dataAbsensiKelas,
            'tgl' => $tgl,
        ]);
    }

    /**
     * Mengambil daftar seluruh siswa aktif beserta informasi NIS, Kelas, dan Asrama pada periode terbaru.
     *
     * Method ini melakukan integrasi data lintas tabel (siswa, nis, kelasmi, asrama) menggunakan
     * teknik Raw Joins demi efisiensi performa pada data skala besar, kemudian memformat outputnya.
     *
     * @OA\Get(
     *     path="/api/siswa/biodata",
     *     summary="Get master data biodata siswa aktif",
     *     tags={"Siswa"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar siswa berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="siswa", type="array", @OA\Items())
     *         )
     *     )
     * )
     *
     * @return JsonResponse Menghasilkan JSON berisi array data komprehensif siswa
     */
    public function getDataSiswa(): JsonResponse
    {
        $periode = Periode::latest('id')->first();

        if (!$periode) {
            return response()->json([
                'siswa' => [],
            ]);
        }

        $siswa = Siswa::query()
            ->select([
                'nis.nis',
            'nis.madrasah_diniyah',
            'nis.tanggal_masuk',
            'siswa.nama_siswa',
            'siswa.jenis_kelamin',
            'siswa.agama',
            'siswa.tempat_lahir',
            'siswa.tanggal_lahir',
            'siswa.kota_asal',
                'kelasmi.nama_kelas',
            'kelasmi.periode_id',
            'asrama.nama_asrama',
            ])

            // NIS
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')

            // KELAS AKTIF
            ->join('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->join('kelasmi', function ($join) use ($periode) {
                $join->on('kelasmi.id', '=', 'pesertakelas.kelasmi_id')
                    ->where('kelasmi.periode_id', $periode->id);
            })

            // ASRAMA AKTIF
            ->leftJoin('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->leftJoin('asramasiswa', function ($join) use ($periode) {
                $join->on('asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
                    ->where('asramasiswa.periode_id', $periode->id);
            })
            ->leftJoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')

            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa')
            ->get()
            ->unique('nis')
            ->values()
            ->map(function ($item) {
            return [
                    'nis' => $item->nis,
                    'nama_siswa' => $item->nama_siswa,
                'tanggal_masuk' => !empty($item->tanggal_masuk)
                    ? date('Y-m-d', strtotime($item->tanggal_masuk))
                    : null,
                'madrasah_diniyah' => $item->madrasah_diniyah,
                'nama_lembaga' => 'Wahidiyah',
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'agama' => $item->agama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'kota_asal' => $item->kota_asal,
                    'nama_asrama' => $item->nama_asrama,
                    'nama_kelas' => $item->nama_kelas,
                    'periode_id' => $item->periode_id,
                ];
            });

        return response()->json([
            'siswa' => $siswa,
        ]);
    }
}
