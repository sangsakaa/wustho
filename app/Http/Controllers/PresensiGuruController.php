<?php

namespace App\Http\Controllers;

use App\Models\Absensiguru;
use App\Models\Daftar_Jadwal;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Sesi_Kelas_Guru;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Exceptions\InvalidFormatException;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use IntlDateFormatter;

class PresensiGuruController
{


    public function index(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }

        // ✅ DATA SESI + REKAP PER SESI
        $sesikelas = Sesi_Kelas_Guru::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'sesi_kelas_guru.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->leftJoin('absensiguru', 'absensiguru.sesi_kelas_guru_id', '=', 'sesi_kelas_guru.id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', '=', 'absensiguru.daftar_jadwal_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')

            ->select(
            'sesi_kelas_guru.id',
            'sesi_kelas_guru.tanggal',
            'sesi_kelas_guru.kelasmi_id',
            'periode.periode',
            'semester.ket_semester',
            'kelasmi.nama_kelas',

            DB::raw("GROUP_CONCAT(DISTINCT guru.nama_guru SEPARATOR ', ') as nama_guru"),

            DB::raw('COUNT(absensiguru.id) as total_absen'),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan = 'hadir' THEN 1 ELSE 0 END) as hadir"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan = 'izin' THEN 1 ELSE 0 END) as izin"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan = 'sakit' THEN 1 ELSE 0 END) as sakit"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan = 'alfa' THEN 1 ELSE 0 END) as alfa")
            )

            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
            ->where('sesi_kelas_guru.tanggal', $tanggal->toDateString())

            ->groupBy(
                'sesi_kelas_guru.id',
                'sesi_kelas_guru.tanggal',
                'sesi_kelas_guru.kelasmi_id',
                'periode.periode',
                'semester.ket_semester',
                'kelasmi.nama_kelas'
            )
            ->get();

        // ✅ REKAP GLOBAL HARI INI
        $absensiHariIni = Absensiguru::query()
            ->join('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', '=', 'sesi_kelas_guru.id')
            ->where('sesi_kelas_guru.tanggal', $tanggal->toDateString())
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
            ->get();

        $totalAbsen = $absensiHariIni->count();

        $rekap = $absensiHariIni->groupBy('keterangan')->map->count();

        $hadir = $rekap->get('hadir', 0);
        $izin  = $rekap->get('izin', 0);
        $sakit = $rekap->get('sakit', 0);
        $alfa  = $rekap->get('alfa', 0);

        $totalSesi = $sesikelas->count();

        $belumAbsen = max($totalSesi - $totalAbsen, 0);

        return view('presensi.guru.sesikelas', [
            'sesikelas' => $sesikelas,
            'tanggal' => $tanggal,
            'summary' => [
                'total_sesi' => $totalSesi,
                'total_absen' => $totalAbsen,
                'belum_absen' => $belumAbsen,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alfa' => $alfa,
            ]
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
        ]);
        $daftarPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->orderbY('periode.id', 'desc')->first();
        $dataKelasMi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();
        // dd($dataKelasMi);

        $sesikelas = Sesi_Kelas_Guru::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')
            ->select('sesi_kelas_guru.*', 'kelasmi.nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
            ->where('sesi_kelas_guru.tanggal', $request->tanggal)
            ->get();
        // dd($sesikelas);

        foreach ($dataKelasMi as $kelasmi) {
            if ($sesikelas->doesntContain('nama_kelas', $kelasmi->nama_kelas)) {
                $sesi = new Sesi_Kelas_Guru();
                $sesi->tanggal = $request->tanggal;
                $sesi->periode_id = $daftarPeriode->id;
                $sesi->kelasmi_id = $kelasmi->id;
                $sesi->save();
            }
        }
        return redirect()->back()->with('status', 'Sesi Berhasil ditambahkan');
    }
    public function DaftarGuru(Sesi_Kelas_Guru $sesi_Kelas_Guru, Request $request)
    {

        // dd($sesi_Kelas_Guru);
        $title = $sesi_Kelas_Guru->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')->find($sesi_Kelas_Guru->id);
        $datetime = DateTime::createFromFormat('Y-m-d', $sesi_Kelas_Guru->tanggal);
        if ($datetime !== false) {
            $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $formatter->setPattern('EEEE');
            $hari = strtolower($formatter->format($datetime));
            // dd($hari);
        } else {
            // handle error here
        }
        // dd($hari);
        $dataGuru = Daftar_Jadwal::query()
            ->join('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->join('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftjoin('absensiguru', function ($join) use ($sesi_Kelas_Guru) {
            $join->on('absensiguru.daftar_jadwal_id', '=', 'daftar_jadwal.id')
            ->where('absensiguru.sesi_kelas_guru_id', '=', $sesi_Kelas_Guru->id);
        })
            ->select(
                'daftar_jadwal.id',
                'sesi_kelas_guru_id',
                'kelasmi_id',
                'nama_guru',
                'hari',
                'absensiguru.keterangan',
                'absensiguru.alasan'
            )
            ->where('jadwal.kelasmi_id', $sesi_Kelas_Guru->kelasmi_id)
            ->where('jadwal.hari', $hari)
        ->get();
        return view(
            'presensi.guru.DaftarHadirGuru',
            compact(
                [
                    'dataGuru',
                    'sesi_Kelas_Guru',
                    'title'

                ]
            )
        );
    }
    public function AbsenGuru(Request $request)
    {
        foreach ($request->daftar_jadwal_id ?? [] as $jadwal_id) {
            $ket = $request->keterangan[$jadwal_id] ?? null;

            if ($ket) {
                Absensiguru::updateOrCreate(
                    [
                        'sesi_kelas_guru_id' => $request->sesi_kelas_guru_id,
                        'daftar_jadwal_id' => $jadwal_id,
                    ],
                    [
                        'keterangan' => $ket,
                        'alasan' => $request->alasan[$jadwal_id] ?? null,
                    ]
                );
            }
        }

        return redirect()->back()->with('status', 'Presensi berhasil disimpan');
    }
    public function LaporanHarian(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }

        $laporanGuru = Absensiguru::query()
            ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', 'sesi_kelas_guru.id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', 'absensiguru.daftar_jadwal_id')
            ->leftJoin('kelasmi', 'kelasmi.id', 'sesi_kelas_guru.kelasmi_id')
            ->leftJoin('guru', 'guru.id', 'daftar_jadwal.guru_id')
            ->select('guru.nama_guru', 'sesi_kelas_guru.tanggal', 'absensiguru.keterangan', 'absensiguru.alasan', 'kelasmi.nama_kelas')
            ->groupBy('guru.nama_guru', 'sesi_kelas_guru.tanggal', 'absensiguru.keterangan', 'absensiguru.alasan', 'kelasmi.nama_kelas')
            ->where('sesi_kelas_guru.tanggal', $tanggal->toDateString())
            ->orderby('nama_kelas')
            ->get();

        $laporanGuru->collect(); // Isi dengan data laporan guru Anda

        // Menghitung jumlah laporan guru dengan keterangan tertentu
        $jmlKet = $laporanGuru->groupBy('keterangan')->map(function ($item) {
                return $item->count();
            });
        // dd($jmlKet);
        // Menambahkan presentasi dalam keterangan
        $totalLaporan = $jmlKet->sum();
        $Sakit = $jmlKet->get('sakit', 0);
        $Hadir = $jmlKet->get('hadir', 0);
        $Izin = $jmlKet->get('izin', 0);
        $Alfa = $jmlKet->get('alfa', 0);
        $presentasiSakit = $totalLaporan > 0 ? $Sakit / $totalLaporan * 100 : 0;
        $presentasiHadir = $totalLaporan > 0 ? $Hadir / $totalLaporan * 100 : 0;
        $presentasiIzin = $totalLaporan > 0 ? $Izin / $totalLaporan * 100 : 0;
        $presentasiAlfa = $totalLaporan > 0 ? $Alfa / $totalLaporan * 100 : 0;

        // Menampilkan hasil

        return view('presensi.guru.laporan.laporan', compact(
            'laporanGuru',
            'tanggal',
            'presentasiSakit',
            'presentasiHadir',
            'presentasiIzin',
            'presentasiAlfa',
            'Sakit',
            'Hadir',
            'Izin',
            'Alfa',
        ));
    }
    public function bulkDelete(Request $request)
    {
        Sesi_Kelas_Guru::whereIn('id', $request->ids)->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
    public function laporanSemester(Request $request)
    {
        $mode = $request->mode ?? 'bulanan';

        $tanggal = $request->tanggal
            ? Carbon::parse($request->tanggal)
            : now();

        $periodeId = $request->periode_id ?? session('periode_id');

        $periode = Periode::with('semester')->find($periodeId);

        if ($mode == 'harian') {
            $start = $tanggal->copy()->startOfDay();
            $end = $tanggal->copy()->endOfDay();
        } elseif ($mode == 'semester') {
            $start = null;
            $end = null;
        } else {
            $start = $tanggal->copy()->startOfMonth();
            $end = $tanggal->copy()->endOfMonth();
        }

        $laporan = Absensiguru::query()
            ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', '=', 'sesi_kelas_guru.id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', '=', 'absensiguru.daftar_jadwal_id')
            ->leftJoin('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')

            ->select(
                DB::raw("COALESCE(guru.nama_guru,'-') as nama_guru"),
                DB::raw("GROUP_CONCAT(DISTINCT kelasmi.nama_kelas ORDER BY kelasmi.nama_kelas SEPARATOR ', ') as kelas"),

            DB::raw('COUNT(*) as total'),
            DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) as sesi'),

            DB::raw("SUM(CASE WHEN absensiguru.keterangan='hadir' THEN 1 ELSE 0 END) as hadir"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan='izin' THEN 1 ELSE 0 END) as izin"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan='sakit' THEN 1 ELSE 0 END) as sakit"),
            DB::raw("SUM(CASE WHEN absensiguru.keterangan='alfa' THEN 1 ELSE 0 END) as alfa"),

                // 🔥 HARI DARI DATABASE JADWAL
                DB::raw("SUM(CASE WHEN jadwal.hari='jumat' THEN 1 ELSE 0 END) as jumat"),
                DB::raw("SUM(CASE WHEN jadwal.hari='sabtu' THEN 1 ELSE 0 END) as sabtu"),
                DB::raw("SUM(CASE WHEN jadwal.hari='minggu' THEN 1 ELSE 0 END) as minggu"),
                DB::raw("SUM(CASE WHEN jadwal.hari='senin' THEN 1 ELSE 0 END) as senin"),
                DB::raw("SUM(CASE WHEN jadwal.hari='selasa' THEN 1 ELSE 0 END) as selasa"),
                DB::raw("SUM(CASE WHEN jadwal.hari='rabu' THEN 1 ELSE 0 END) as rabu"),
                DB::raw("SUM(CASE WHEN jadwal.hari='kamis' THEN 1 ELSE 0 END) as kamis"),
            )
            // 🔥 FILTER MODE
            ->when($mode == 'semester', function ($q) use ($periodeId) {
                return $q->where('sesi_kelas_guru.periode_id', $periodeId);
            })

            ->when($mode != 'semester', function ($q) use ($start, $end) {
                return $q->whereBetween('sesi_kelas_guru.tanggal', [$start, $end]);
            })

            // 🔥 IMPORTANT: GROUP ONLY BY GURU (NOT KELAS, NOT HARI)
            ->groupBy('guru.nama_guru')

            // 🔥 NULL ALWAYS BOTTOM
            ->orderByRaw("CASE WHEN guru.nama_guru IS NULL OR guru.nama_guru = '' THEN 1 ELSE 0 END")
            ->orderBy('guru.nama_guru')

            ->get();

        return view('presensi.guru.laporan.laporanSemester', [
            'laporan' => $laporan,
            'mode' => $mode,
            'tanggal' => $tanggal,
            'periode' => $periode,
        ]);
    }
    public function laporanSemesterPdf(Request $request)
    {
        $mode = $request->mode ?? 'bulanan';

        $tanggal = $request->tanggal
            ? Carbon::parse($request->tanggal)
            : now();

        $periodeId = $request->periode_id ?? session('periode_id');

        $periode = Periode::with('semester')->find($periodeId);

        if ($mode == 'harian') {
            $start = $tanggal->copy()->startOfDay();
            $end = $tanggal->copy()->endOfDay();
        } elseif ($mode == 'semester') {
            $start = null;
            $end = null;
        } else {
            $start = $tanggal->copy()->startOfMonth();
            $end = $tanggal->copy()->endOfMonth();
        }

        $laporan = Absensiguru::query()
            ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', '=', 'sesi_kelas_guru.id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', '=', 'absensiguru.daftar_jadwal_id')
            ->leftJoin('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->select(
                DB::raw("COALESCE(guru.nama_guru,'') as nama_guru"),
                'kelasmi.nama_kelas',
                'jadwal.hari as hari',
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) as sesi'),
                DB::raw("SUM(CASE WHEN absensiguru.keterangan='hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN absensiguru.keterangan='izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN absensiguru.keterangan='sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN absensiguru.keterangan='alfa' THEN 1 ELSE 0 END) as alfa"),
            )
            ->when($mode == 'semester', function ($q) use ($periodeId) {
                return $q->where('sesi_kelas_guru.periode_id', $periodeId);
            })
            ->when($mode != 'semester', function ($q) use ($start, $end) {
                return $q->whereBetween('sesi_kelas_guru.tanggal', [$start, $end]);
            })
            ->groupBy(
                'kelasmi.nama_kelas',
                'jadwal.hari',
                DB::raw("COALESCE(guru.nama_guru,'')")
            )
            ->orderByRaw("CASE WHEN guru.nama_guru = '' THEN 1 ELSE 0 END")
            ->orderBy('guru.nama_guru')
            ->get();

        $pdf = Pdf::loadView('presensi.guru.laporan.laporanSemesterPdf', [
            'laporan' => $laporan,
            'mode' => $mode,
            'tanggal' => $tanggal,
            'periode' => $periode,
        ])->setPaper('F4', 'landscape');

        return $pdf->stream('laporan-presensi-guru.pdf');
    }
    public function DeleteSesi(Sesi_Kelas_Guru $sesi_Kelas_Guru)

    {
        Sesi_Kelas_Guru::destroy($sesi_Kelas_Guru->id);
        Absensiguru::where('sesi_kelas_guru_id', $sesi_Kelas_Guru->id)->delete();
        return redirect()->back();
    }

    public function rekapSesi(Request $request)
    {
        $bulan = $request->bulan
            ? Carbon::parse($request->bulan)
            : now();

        $startBulan = $bulan->copy()->startOfMonth();
        $endBulan   = $bulan->copy()->endOfMonth();
        $periodeBulan = $startBulan->daysUntil($endBulan->copy()->addDay());

        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->first();

        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select(
                'kelasmi.id',
                'kelasmi.nama_kelas',
                'periode.periode',
                'semester.ket_semester'
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $dataSesikelasguru = Sesi_Kelas_Guru::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')
            ->leftJoin('absensiguru', 'absensiguru.sesi_kelas_guru_id', '=', 'sesi_kelas_guru.id')
            ->select(
                'sesi_kelas_guru.*',
                'kelasmi.nama_kelas',
                'absensiguru.keterangan'
            )
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesi_kelas_guru.tanggal', [
                $startBulan->toDateString(),
                $endBulan->toDateString()
            ])
            ->get()
            ->groupBy('kelasmi_id');

        $dataRekapSesi = $datakelasmi
            ->keyBy('id')
            ->map(function ($kelasmi, $kelasmi_id) use ($dataSesikelasguru, $periodeBulan) {

            $sesiPerBulan = []; // reset setiap kelas

            foreach ($periodeBulan as $hari) {
                $dataKelas = $dataSesikelasguru->get($kelasmi_id, collect());

                $sesiPerBulan[] = [
                        'hari' => $hari,
                    'data' => $dataKelas->firstWhere(
                        'tanggal',
                        $hari->toDateString()
                    ),
                    ];
                }

            return [
                    'sesiPerBulan' => $sesiPerBulan,
                    'kelasmi' => $kelasmi,
                ];
            });

        return view('presensi.guru.rekapSesi', [
            'dataRekapSesi' => $dataRekapSesi,
            'periodeBulan'  => $periodeBulan,
            'periode'       => $periode,
            'bulan'         => $bulan,
        ]);
    }
}
