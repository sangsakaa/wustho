<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelasmi;
use App\Models\Periode;

use App\Models\Sesikelas;
use App\Models\Absensikelas;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;




class AbsensikelasController
{
    public function index(Sesikelas $sesikelas)
    {
        $prev_url = session('prev_url') ?? url()->previous();
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
            ->leftjoin('asramasiswa', 'asramasiswa.id', '=', 'pesertakelas.siswa_id')
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
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
            'asrama.nama_asrama',
                'absensikelas.updated_at as tglsimpan'
            )
            ->orderBy('siswa.nama_siswa')
            ->get();
        // $a = json_decode($dataSiswa);
        // dd($a);
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
                'prev_url' => $prev_url,
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
        return redirect()->back()->with([
            'status' => 'Presensi berhasil disimpan pada ' . now(),
            'prev_url' => $request->prev_url,
        ]);
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
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
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
            'jenis_kelamin',
                'kelas.kelas',
                'kelasmi.nama_kelas',
            )
            // ->orderby('nis.nis')
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
            ->select('kelasmi.id', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
        ->first();

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
                        $nullAbsensi =  new Absensikelas([
                            'nama_asrama' => $nama_asrama,
                            'nama_kelas' => $nama_kelas,
                            'nama_siswa' => '-',
                            'keterangan' => '-'
                        ]);
                        $total = $item->count();
                        $hadir = $item->where('keterangan', 'hadir')->count();
                        $tidakHadir = $total - $hadir;
                        $absensi = $tidakHadir === 0 ? collect([$nullAbsensi]) : $absensiGrup[$nama_asrama][$nama_kelas];
                        return [
                            'hadir' => $hadir,
                            'tidakHadir' => $tidakHadir,
                            'total' => $total,
                            'persentase' => $hadir / $total * 100,
                            'absensi' => $absensi,
                            'row' => $absensi->count(),
                        ];
                    })
                    ->filter();
            });

        // dd($absensiGrup, $rekapAbsensi);

        return view('presensi.kelas.rekapPerHari', [
            'dataKelasMi' => $datakelasmi,
            'rekapAbsensi' => $rekapAbsensi,
            'tgl' => $tgl,
        ]);
    }

    public function rekapPerBulan(Request $request)
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
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());

        if (!$kelasmi) {
            return view('presensi.kelas.rekapPerBulan', [
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
            ->orderby('siswa.nama_siswa')
            ->get();

        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->select('absensikelas.*', 'sesikelas.tgl')
            ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
            ->where('sesikelas.kelasmi_id', $kelasmi->id)
            ->get();

        $dataAbsensiKelas = $dataAbsensiKelas
            ->groupBy('pesertakelas_id');

        $dataSiswa = $dataSiswa
            ->keyBy('id')
            ->map(function ($siswa, $key) use ($dataAbsensiKelas, $periodeBulan) {
                $absensi = [];
                foreach ($periodeBulan as $hari) {
                    $absensiPerBulan[] = [
                        'hari' => $hari,
                        'data' => $dataAbsensiKelas->count() ? $dataAbsensiKelas[$key]->firstWhere('tgl', $hari->toDateString()) : null
                    ];
                }
                $total = $dataAbsensiKelas->count() ? $dataAbsensiKelas[$key]->countBy(function ($absensiKelas) {
                    return $absensiKelas->keterangan;
                }) : collect();
                return [
                    'siswa' => $siswa,
                    'absensiPerBulan' => $absensiPerBulan,
                    'total' => [
                        'hadir' => $total->get('hadir', '-'),
                        'izin' => $total->get('izin', '-'),
                        'sakit' => $total->get('sakit', '-'),
                        'alfa' => $total->get('alfa', '-'),
                    ]
                ];
            });

        return view('presensi.kelas.rekapPerBulan', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'periodeBulan' => $periodeBulan,
            'bulan' => $bulan,
        ]);
    }

    public function rekapSemester(Request $request)
    {
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->first();

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
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        $dataAbsensi = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->selectRaw(
                "pesertakelas.id, peserta_asrama.nama_asrama, kelasmi.nama_kelas, siswa.nama_siswa, siswa.jenis_kelamin, COUNT(CASE WHEN keterangan = 'hadir' THEN 1 END) AS hadir, COUNT(CASE WHEN keterangan = 'izin' THEN 1 END) AS izin, COUNT(CASE WHEN keterangan = 'sakit' THEN 1 END) AS sakit, COUNT(CASE WHEN keterangan = 'alfa' THEN 1 END) AS alfa"
            )
            ->groupBy('pesertakelas.id', 'peserta_asrama.nama_asrama', 'kelasmi.nama_kelas', 'siswa.nama_siswa', 'siswa.jenis_kelamin')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa');
        if ($kelasmi) {
            $dataAbsensi->where('kelasmi.id', $kelasmi->id);
        } else {
            $dataAbsensi->where('kelasmi.periode_id', session('periode_id'));
        }
        return view('presensi.kelas.rekapSemester', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataAbsensi' => $dataAbsensi->get(),
            'periode' => $periode,
        ]);
    }
    public function blankoLApHarian()
    {
        $bulan = now();
        setlocale(LC_TIME, 'id_ID');

        $bulan = Carbon::now()->locale('id_ID')->isoFormat('MMMM Y');
        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('nama_kelas', 'periode', 'ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))->get();
        return view('presensi.kelas.blankoHarian', compact('kelasmi', 'bulan'));
    }
    public function pernyataan(Request $request)
    {
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->first();

        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        $dataAbsensi = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->join('pesertakelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->leftJoinSub($pesertaasrama, 'peserta_asrama', function ($join) {
                $join->on('peserta_asrama.siswa_id', '=', 'siswa.id');
            })
            ->selectRaw(
                "pesertakelas.id, jenjang,peserta_asrama.nama_asrama, kelasmi.nama_kelas, siswa.nama_siswa, siswa.jenis_kelamin, COUNT(CASE WHEN keterangan = 'hadir' THEN 1 END) AS hadir, COUNT(CASE WHEN keterangan = 'izin' THEN 1 END) AS izin, COUNT(CASE WHEN keterangan = 'sakit' THEN 1 END) AS sakit, COUNT(CASE WHEN keterangan = 'alfa' THEN 1 END) AS alfa"
            )
            ->groupBy('pesertakelas.id', 'jenjang', 'peserta_asrama.nama_asrama', 'kelasmi.nama_kelas', 'siswa.nama_siswa', 'siswa.jenis_kelamin')
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('siswa.nama_siswa');
        if ($kelasmi) {
            $dataAbsensi->where('kelasmi.id', $kelasmi->id);
        } else {
            $dataAbsensi->where('kelasmi.periode_id', session('periode_id'));
        }
        return view('presensi.kelas.pernyataan', [

            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataAbsensi' => $dataAbsensi->get(),
            'periode' => $periode,
        ]);
    }
    public function rekapPerBulanAsrama(Request $request)
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
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
            ->first();

        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());

        if (!$kelasmi) {
            return view('presensi.asrama.rekapPerBulanAsrama', [
                'dataKelasMi' => $datakelasmi,
                'kelasmi' => $kelasmi,
                'dataSiswa' => collect(),
                'periodeBulan' => $periodeBulan,
                'bulan' => $bulan,
            ]);
        }

        $dataSiswa = Pesertakelas::query()
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('pesertaasrama', 'pesertaasrama.siswa_id', 'siswa.id')
            ->join('asramasiswa', 'asramasiswa.id', 'pesertaasrama.asramasiswa_id')
            ->join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->where('pesertakelas.kelasmi_id', $kelasmi->id)

            ->select(
                'pesertakelas.id',
                'siswa.nama_siswa',
                'asramasiswa_id',
                'nis.nis',
                'kelas.kelas',
                'kelasmi.nama_kelas',
            )
            ->orderby('siswa.nama_siswa')
            ->get();

        $dataAbsensiKelas = Absensikelas::query()
            ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
            ->select('absensikelas.*', 'sesikelas.tgl')
            ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
            // ->where('sesikelas.kelasmi_id', $kelasmi->id)

            ->get();

        $dataAbsensiKelas = $dataAbsensiKelas
            ->groupBy('pesertakelas_id');

        $dataSiswa = $dataSiswa
            ->keyBy('id')
            ->map(function ($siswa, $key) use ($dataAbsensiKelas, $periodeBulan) {
                $absensi = [];
                foreach ($periodeBulan as $hari) {
                    $absensiPerBulan[] = [
                        'hari' => $hari,
                        'data' => $dataAbsensiKelas->count() ? $dataAbsensiKelas[$key]->firstWhere('tgl', $hari->toDateString()) : null
                    ];
                }
                $total = $dataAbsensiKelas->count() ? $dataAbsensiKelas[$key]->countBy(function ($absensiKelas) {
                    return $absensiKelas->keterangan;
                }) : collect();
                return [
                    'siswa' => $siswa,
                    'absensiPerBulan' => $absensiPerBulan,
                    'total' => [
                        'hadir' => $total->get('hadir', '-'),
                        'izin' => $total->get('izin', '-'),
                        'sakit' => $total->get('sakit', '-'),
                        'alfa' => $total->get('alfa', '-'),
                    ]
                ];
            });

        return view('presensi.asrama.rekapPerBulanAsrama', [
            'dataKelasMi' => $datakelasmi,
            'kelasmi' => $kelasmi,
            'dataSiswa' => $dataSiswa,
            'periodeBulan' => $periodeBulan,
            'bulan' => $bulan,
        ]);
    }
    public function layoutPDF(Request $request)
    {

        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();

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
                        $nullAbsensi =  new Absensikelas([
                            'nama_asrama' => $nama_asrama,
                            'nama_kelas' => $nama_kelas,
                            'nama_siswa' => '-',
                            'keterangan' => '-'
                        ]);
                        $total = $item->count();
                        $hadir = $item->where('keterangan', 'hadir')->count();
                        $tidakHadir = $total - $hadir;
                        $absensi = $tidakHadir === 0 ? collect([$nullAbsensi]) : $absensiGrup[$nama_asrama][$nama_kelas];
                        return [
                            'hadir' => $hadir,
                            'tidakHadir' => $tidakHadir,
                            'total' => $total,
                            'persentase' => $hadir / $total * 100,
                            'absensi' => $absensi,
                            'row' => $absensi->count(),
                        ];
                    })
                    ->filter();
            });
        return view('presensi.kelas.layoutpdf1', ['datakelasmi' => $datakelasmi, 'tgl' => $tgl, 'rekapAbsensi' => $rekapAbsensi, 'dataKelasMi' => $datakelasmi]);
    }
    public function generatePdf($tgl)
    {
        // Ensure $tgl is parsed as a Carbon instance or use the current date
        $tgl = $tgl ? Carbon::parse($tgl) : now();

        // Retrieve class data based on the current session period
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();

        // Retrieve participants data
        $pesertaasrama = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->join(
                'asramasiswa',
                'asramasiswa.id',
                '=',
                'pesertaasrama.asramasiswa_id'
            )
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('siswa.id as siswa_id', 'asrama.nama_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'));

        // Retrieve attendance data
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

        // Group absences and map results
        $absensiGrup = $dataAbsensiKelas
            ->where('keterangan', '!=', 'hadir')
            ->groupBy('nama_asrama')
            ->map(function ($item, $key) {
                return $item->groupBy('nama_kelas');
            });

        // Create rekap absensi with counts and percentages
        $rekapAbsensi = $dataAbsensiKelas
        ->groupBy('nama_asrama')
        ->map(function ($item, $nama_asrama) use ($absensiGrup) {
            return $item
            ->groupBy('nama_kelas')
                ->map(function ($item, $nama_kelas) use ($absensiGrup, $nama_asrama) {
                    $nullAbsensi = new Absensikelas([
                        'nama_asrama' => $nama_asrama,
                        'nama_kelas' => $nama_kelas,
                        'nama_siswa' => '-',
                        'keterangan' => '-'
                    ]);
                    $total = $item->count();
                    $hadir = $item->where('keterangan', 'hadir')->count();
                    $tidakHadir = $total - $hadir;
                    $absensi = $tidakHadir === 0 ? collect([$nullAbsensi]) : $absensiGrup[$nama_asrama][$nama_kelas];
                    return [
                        'hadir' => $hadir,
                        'tidakHadir' => $tidakHadir,
                        'total' => $total,
                        'persentase' => $total ? ($hadir / $total * 100) : 0,
                        'absensi' => $absensi,
                        'row' => $absensi->count(),
                    ];
                })
                ->filter();
        });

        // Render the view to a string
        $html = view(
            'presensi.kelas.layoutpdf',
            [
            'datakelasmi' => $datakelasmi,
            'tgl' => $tgl,
            'rekapAbsensi' => $rekapAbsensi,
            'dataKelasMi' => $datakelasmi,
            ]
        )->render();


        // Initialize mPDF
        $mpdf = new Mpdf([
            'format' => 'legal',  // Adjust paper size
            'orientation' => 'P',  // Portrait orientation
            'default_font' => 'sans-serif',
        ]);
        // Write the HTML content to the PDF
        // Set margins (left, right, top, bottom) in millimeters
        $mpdf->SetMargins(
            -1,
            -1,
            5,
            1
        ); // Adjust these values as needed

        $mpdf->WriteHTML($html);
        // Output the PDF
        return $mpdf->Output('Laporan Hari ini - ' . $tgl->isoFormat('dddd, D MMMM YYYY') . '.pdf', Destination::INLINE);
    }

}
