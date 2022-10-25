<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelas;
use App\Models\Kelasmi;
use App\Models\Pesertaasrama;
use App\Models\Pesertakelas;
use App\Models\Sesikelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensikelasController
{
    public function index(Sesikelas $sesikelas)
    {
        $dataKelas = Kelasmi::query()
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('kelasmi.id', $sesikelas->kelasmi_id)
            ->first();
        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('absensikelas', function ($join) use ($sesikelas) {
                $join->on('absensikelas.pesertakelas_id', '=', 'pesertakelas.id')
                    ->where('absensikelas.sesikelas_id', '=', $sesikelas->id);
            })
            ->where('pesertakelas.kelasmi_id', $sesikelas->kelasmi_id)
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
                'absensikelas.id as absensikelas_id',
                'absensikelas.keterangan',
                'absensikelas.alasan',
                'absensikelas.updated_at as tglsimpan'
            )
            ->orderby('nis.nis')
            ->orderby('siswa.nama_siswa')
            ->get();

        $jumlahAbsensi = $dataSiswa->countBy('keterangan');
        if (!$jumlahAbsensi->has('hadir')) $jumlahAbsensi->put('hadir', 0);
        if (!$jumlahAbsensi->has('izin')) $jumlahAbsensi->put('izin', 0);
        if (!$jumlahAbsensi->has('sakit')) $jumlahAbsensi->put('sakit', 0);
        if (!$jumlahAbsensi->has('alfa')) $jumlahAbsensi->put('alfa', 0);

        $diSimpanPada = $dataSiswa
            ->sortByDesc('tglsimpan')
            ->value('tglsimpan');

        return view(
            'presensi.kelas.absensi',
            [
                'dataSiswa' => $dataSiswa,
                'dataKelas' => $dataKelas,
                'sesikelas' => $sesikelas,
                'jumlahAbsensi' => $jumlahAbsensi,
                'diSimpanPada' => $diSimpanPada,
            ]
        );
    }

    public function store(Request $request)
    {
        foreach ($request->pesertakelas as $peserta) {
            $absensikelas_id = $request->absensikelas[$peserta];
            $absensikelas = $absensikelas_id ? Absensikelas::find($absensikelas_id) : new Absensikelas();
            $absensikelas->pesertakelas_id = $peserta;
            $absensikelas->sesikelas_id = $request->sesikelas;
            $absensikelas->keterangan = $request->keterangan[$peserta];
            $absensikelas->alasan = $request->alasan[$peserta];
            $absensikelas->save();
        }
        return redirect()->back()->with('status', 'Presensi berhasil disimpan pada ' . now());
    }

    public function blanko(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());

        if (!$kelasmi) {
            return view('presensi.kelas.blanko', [
                'dataKelasMi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'dataSiswa' => collect(),
                'periodeBulan' => $periodeBulan,
                'bulan' => $bulan,
            ]);
        }

        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('pesertakelas.kelasmi_id', $kelasmi->id)
            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
            )
            ->orderby('nis.nis')
            ->orderby('siswa.nama_siswa')
            ->get();

        return view('presensi.kelas.blanko', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'periodeBulan' => $periodeBulan,
            'bulan' => $bulan,
        ]);
    }

    public function rekapPerHari(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->joinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->select('peserta_asrama.nama_asrama', 'kelasmi.nama_kelas', 'siswa.nama_siswa', 'absensikelas.keterangan')
            ->where('sesikelas.tgl', $tgl->toDateString())
            ->orderBy('peserta_asrama.nama_asrama')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('absensikelas.keterangan')
            ->orderBy('siswa.nama_siswa')
            ->get();

        $absensiGrup = $dataAbsensiKelas
            ->where('keterangan', '!=', 'hadir')
            ->groupBy('nama_asrama')
            ->map(function ($item, $key) {
                return $item
                    ->groupBy('nama_kelas');
            });

        $rekapAbsensi = $dataAbsensiKelas
            ->groupBy('nama_asrama')
            ->map(function ($item, $nama_asrama) use ($absensiGrup) {
                return $item
                    ->groupBy('nama_kelas')
                    ->map(function ($item, $nama_kelas) use ($absensiGrup, $nama_asrama) {
                        $total = $item->count();
                        $hadir = $item->where('keterangan', 'hadir')->count();
                        return [
                            'hadir' => $hadir,
                            'tidakHadir' => $total - $hadir,
                            'total' => $total,
                            'persentase' => $hadir / $total * 100,
                            'absensi' => $absensiGrup[$nama_asrama][$nama_kelas],
                        ];
                    });
            });

        // dd($rekapAbsensi);s

        return view('presensi.kelas.rekapPerHari', [
            'dataKelasMi' => $datakelasmi,
            'rekapAbsensi' => $rekapAbsensi,
            'tgl' => $tgl,
        ]);
    }
}