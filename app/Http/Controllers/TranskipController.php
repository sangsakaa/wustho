<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Kelasmi;
use App\Models\Lulusan;
use App\Models\Periode;
use App\Models\Transkip;
use App\Models\Jenis_Ujian;
use Illuminate\Http\Request;
use App\Models\Daftar_lulusan;
use App\Models\Nilai_Transkip;

class TranskipController
{
    public function index(Request $request)
    {
        $periodeId = session('periode_id');

        // =========================================================
        // FILTER
        // =========================================================
        $search = $request->input('search');
        $kelasmiId = $request->input('kelasmi_id');
        $jenisUjianId = $request->input('jenis_ujian_id');
        $mapelId = $request->input('mapel_id');


        // =========================================================
        // PERIODE AKTIF
        // =========================================================
        $periodeAktif = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('periode.id', $periodeId)
            ->select([
                'periode.id',
                'periode.periode',
                'semester.ket_semester',
            ])
            ->first();

        $isGenap = strtolower(
            $periodeAktif?->ket_semester ?? ''
        ) === 'genap';


        // =========================================================
        // DATA KELAS
        // =========================================================
        $kelasMi = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->where('kelasmi.periode_id', $periodeId)
            ->where('kelas.kelas', 3)

            ->select([
                'kelasmi.id',
                'kelasmi.nama_kelas',
                'kelas.kelas as tingkat',
                'periode.periode',
                'semester.ket_semester',
            ])

            ->orderBy('kelasmi.nama_kelas')
            ->get();


        // =========================================================
        // DATA PERIODE
        // =========================================================
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->where('periode.id', $periodeId)

            ->select([
                'periode.id',
                'periode.periode',
                'semester.ket_semester',
            ])

            ->get();


        // =========================================================
        // DATA MAPEL
        // =========================================================
        $dataMapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->join('periode', 'periode.id', '=', 'mapel.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->where('mapel.periode_id', $periodeId)
            ->where('kelas.kelas', 3)

            ->select([
                'mapel.id',
                'mapel.mapel',
            'kelas.kelas as tingkat',
                'periode.periode',
                'semester.ket_semester',
            ])

            ->orderBy('mapel.mapel')
            ->get();


        // =========================================================
        // JENIS UJIAN
        // =========================================================
        $dataJenisUjian = Jenis_Ujian::query()
            ->orderBy('nama_ujian')
            ->get();


        // =========================================================
        // DATA TRANSKIP
        // =========================================================
        $dataTranskip = Transkip::query()

            ->join(
                'periode',
                'periode.id',
                '=',
                'transkip.periode_id'
            )

            ->join(
                'semester',
                'semester.id',
                '=',
                'periode.semester_id'
            )

            ->join(
                'jenis_ujian',
                'jenis_ujian.id',
                '=',
                'transkip.jenis_ujian_id'
            )

            ->join(
                'mapel',
                'mapel.id',
                '=',
                'transkip.mapel_id'
            )

            ->join(
            'kelas',
                'kelas.id',
                '=',
                'mapel.kelas_id'
            )

            ->leftJoin(
                'kelasmi',
                'kelasmi.id',
                '=',
                'transkip.kelasmi_id'
            )

            // =====================================================
            // PERIODE AKTIF
            // =====================================================
            ->where(
                'transkip.periode_id',
                $periodeId
            )


            // =====================================================
            // FILTER KELAS
            // =====================================================
            ->when($kelasmiId, function ($query) use ($kelasmiId) {

                $query->where(
                    'transkip.kelasmi_id',
                    $kelasmiId
                );
            })


            // =====================================================
            // FILTER JENIS UJIAN
            // =====================================================
            ->when($jenisUjianId, function ($query) use ($jenisUjianId) {

                $query->where(
                    'transkip.jenis_ujian_id',
                    $jenisUjianId
                );
            })


            // =====================================================
            // FILTER MAPEL
            // =====================================================
            ->when($mapelId, function ($query) use ($mapelId) {

                $query->where(
                    'transkip.mapel_id',
                    $mapelId
                );
            })


            // =====================================================
            // PENCARIAN
            // =====================================================
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'mapel.mapel',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'kelasmi.nama_kelas',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'jenis_ujian.nama_ujian',
                            'like',
                            "%{$search}%"
                        );
                });
            })


            // =====================================================
            // SELECT
            // =====================================================
            ->select([
            'transkip.id',
            'transkip.kelasmi_id',
            'transkip.periode_id',
            'transkip.mapel_id',
            'transkip.jenis_ujian_id',

            'periode.periode',
            'semester.ket_semester',

            'kelasmi.nama_kelas',

            'kelas.kelas as tingkat',

            'jenis_ujian.nama_ujian',

            'mapel.mapel',
        ])


            // =====================================================
            // JUMLAH PESERTA
            // =====================================================
            ->withCount('nilaiTranskip')


            // =====================================================
            // SORTING
            // =====================================================
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('jenis_ujian.nama_ujian')
            ->orderBy('mapel.mapel')


            // =====================================================
            // PAGINATION
            // =====================================================
            ->paginate(8)

            ->withQueryString();


        // =========================================================
        // VIEW
        // =========================================================
        return view(
            'lulusan.transkip.index',
            compact(
                'periodeAktif',
                'dataPeriode',
                'dataMapel',
                'dataJenisUjian',
                'dataTranskip',
                'kelasMi',
                'isGenap',

                // FILTER
                'search',
                'kelasmiId',
                'jenisUjianId',
                'mapelId'
            )
        );
    }
    public function store(Request $request)
    {
        $transkip = new Transkip();
        $transkip->periode_id = $request->periode_id;
        $transkip->mapel_id = $request->mapel_id;
        $transkip->kelasmi_id = $request->kelasmi_id;
        $transkip->jenis_ujian_id = $request->jenis_ujian_id;
        $transkip->save();
        return redirect()->back();
    }
    public function daftarTranskip(Transkip $transkip)
    {
        $dataTranskip = Transkip::query()
            ->leftJoin('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->leftJoin('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
        ->find($transkip->id);
        $dataNilaiTranskip = Nilai_Transkip::query()
            ->where('transkip_id', $transkip->id);
        $daftarLulusan = Daftar_lulusan::query()
            ->leftjoin('pesertakelas', 'pesertakelas.id', '=', 'daftar_lulusan.pesertakelas_id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftjoin('lulusan', 'lulusan.id', '=', 'daftar_lulusan.lulusan_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->leftjoinSub($dataNilaiTranskip, 'data_nilai', function ($join) {
                $join->on('data_nilai.daftar_lulusan_id', '=', 'daftar_lulusan.id');
            })
            ->select(
                [
                    'daftar_lulusan.id',
                    'data_nilai.id AS nilai_transkip_id',
                    'daftar_lulusan.nomor_ijazah',
                    'siswa.nama_siswa',
                'kelasmi.nama_kelas',
                    'nis.nis',
                    'data_nilai.nilai_akhir'
                ]
            )
            ->where('pesertakelas.kelasmi_id', $transkip->kelasmi_id)
            ->orderby('nama_kelas')
            ->orderby('nama_siswa')
            ->get();
        return view(
            'lulusan.transkip.daftar',
            [
                'dataLulusan' => $daftarLulusan,
                'transkip' => $transkip,
                'dataTranskip' => $dataTranskip

            ]
        );
    }
    public function NilaiTranskip(Request $request)
    {
        foreach ($request->daftar_lulusan_id as $daftar_lulusan_id) {
            $peserta = Nilai_Transkip::firstOrNew(
                [
                    'id' => $request->nilai_transkip_id[$daftar_lulusan_id],

                ]
            );
            $peserta->transkip_id = $request->transkip_id;
            $peserta->daftar_lulusan_id = $daftar_lulusan_id;
            $peserta->nilai_akhir = $request->nilai_akhir[$daftar_lulusan_id] ?? 0;
            $peserta->save();
        }
        return redirect()->back()->with('message', 'Data telah berhasil disimpan!');
    }
    public function DeleteTraskip(Transkip $transkip)
    {
        Transkip::destroy($transkip->id);
        Nilai_Transkip::where('transkip_id', $transkip->id)->delete();
        return redirect()->back();
    }
}
