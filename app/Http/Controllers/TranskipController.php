<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Lulusan;
use App\Models\Periode;
use App\Models\Transkip;
use App\Models\Jenis_Ujian;
use Illuminate\Http\Request;
use App\Models\Daftar_lulusan;
use App\Models\Nilai_Transkip;

class TranskipController
{
    public function index()
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.periode', 'ket_semester', 'periode.id')
            ->orderby('ket_semester', 'desc')
        ->get();
        $dataMapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->select('kelas.kelas', 'mapel.mapel', 'mapel.id')
            ->where('kelas.kelas', 3)
            ->get();
        $dataJenisUjian = Jenis_Ujian::all();
        $dataTranskip = Transkip::query()
            ->join('periode', 'periode.id', '=', 'transkip.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('jenis_ujian', 'jenis_ujian.id', '=', 'transkip.jenis_ujian_id')
            ->join('mapel', 'mapel.id', '=', 'transkip.mapel_id')
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->select('periode.periode', 'ket_semester', 'nama_ujian', 'mapel', 'kelas', 'transkip.id')
            ->orderby('nama_ujian')
            ->get();
        return view(
            'lulusan.transkip.index',
            [
                'dataPeriode' => $dataPeriode,
                'dataMapel' => $dataMapel,
                'dataJenisUjian' => $dataJenisUjian,
                'dataTranskip' => $dataTranskip,

            ]
        );
    }
    public function store(Request $request)
    {
        $transkip = new Transkip();
        $transkip->periode_id = $request->periode_id;
        $transkip->mapel_id = $request->mapel_id;
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
                    'nis.nis',
                    'data_nilai.nilai_akhir'
                ]
            )

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
    public function NilaiTranskip(Request $request, Transkip $transkip)
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
