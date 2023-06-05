<?php

namespace App\Http\Controllers;

use DateTime;
use IntlDateFormatter;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Absensiguru;
use Illuminate\Http\Request;
use App\Models\Daftar_Jadwal;
use Illuminate\Support\Carbon;
use App\Models\Sesi_Kelas_Guru;
use Illuminate\Support\Facades\DB;
use Carbon\Exceptions\InvalidFormatException;

class PresensiGuruController
{
    public function index(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }

        $sesikelas = Sesi_Kelas_Guru::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')
            ->join('periode', 'periode.id', 'sesi_kelas_guru.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->leftjoin('absensiguru', 'absensiguru.sesi_kelas_guru_id', 'sesi_kelas_guru.id')
            ->leftjoin('daftar_jadwal', 'daftar_jadwal.id', 'absensiguru.daftar_jadwal_id')
            ->leftjoin('guru', 'guru.id', 'daftar_jadwal.guru_id')
            ->select(
                [
                    'sesi_kelas_guru.*', 'periode.periode', 'semester.ket_semester', 'nama_kelas', 'guru_id', 'nama_guru'
                ]
            )
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
            ->where('sesi_kelas_guru.tanggal', $tanggal->toDateString())
            ->get();
        return view('presensi.guru.sesikelas', [

            'sesikelas' => $sesikelas,
            'tanggal' => $tanggal,
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
            ->join('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftJoin('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->leftJoin('absensiguru', 'absensiguru.daftar_jadwal_id', '=', 'daftar_jadwal.id')
            ->select([
                'nama_guru',
                'hari',
                'jadwal.kelasmi_id',
            'daftar_jadwal.id',
                'absensiguru.alasan',
            'absensiguru.keterangan',
            // 'sesi_kelas_guru_id'
            ])

            ->where('hari', $hari)
            ->where('jadwal.kelasmi_id', $sesi_Kelas_Guru->kelasmi_id)
        ->get();
        // dd($dataGuru);
        
        if ($dataGuru->count() > 1) {
            $dataGuru = $dataGuru
                ->where('sesi_kelas_guru_id', $sesi_Kelas_Guru->id);
        }

        //dd($dataGuru)->toJson();
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
        $absenGuru = Absensiguru::where('sesi_kelas_guru_id', $request->sesi_kelas_guru_id)->first();

        if ($absenGuru) {
            $absenGuru->keterangan = implode(", ", $request->keterangan);
            $absenGuru->alasan = implode(", ", $request->alasan);
            $absenGuru->save();
        } else {
            $absenGuru = new Absensiguru();
            $absenGuru->sesi_kelas_guru_id = $request->sesi_kelas_guru_id;
            $absenGuru->daftar_jadwal_id = $request->daftar_jadwal_id;
            $absenGuru->keterangan = implode(", ", $request->keterangan);
            $absenGuru->alasan = implode(", ", $request->alasan);
            $absenGuru->save();
        }


        return redirect()->back();
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
    public function laporanSemester(Request $request)
    {
        $tanggal = $request->bulan ? Carbon::parse($request->bulan): now();
        $startOfMonth = $tanggal->startOfMonth()->toDateString();
        $endOfMonth = $tanggal->endOfMonth()->toDateString();

        $kelasmi = Kelasmi::query()
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('periode.id', session('periode_id'))
        ->select('kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'periode.id')
        ->first();
        $laporanQuery = Absensiguru::query()
            ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', 'sesi_kelas_guru.id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', 'absensiguru.daftar_jadwal_id')
            ->leftJoin('jadwal', 'jadwal.id', 'daftar_jadwal.jadwal_id')
            ->leftJoin('kelasmi', 'kelasmi.id', 'jadwal.kelasmi_id')
            ->leftJoin('guru', 'guru.id', 'daftar_jadwal.guru_id')
            ->select(
            DB::raw("DATE_FORMAT(sesi_kelas_guru.tanggal, '%M') as bulan"),
            'guru.nama_guru',
            DB::raw('COUNT(*) as total'),
            DB::raw('COUNT(DISTINCT sesi_kelas_guru.id) as jumlah_sesi_kelas_guru'),
            DB::raw("COUNT(CASE WHEN absensiguru.keterangan = 'hadir' THEN 1 END) as jumlah_hadir"),
            DB::raw("COUNT(CASE WHEN absensiguru.keterangan = 'izin' THEN 1 END) as jumlah_izin"),
            DB::raw("COUNT(CASE WHEN absensiguru.keterangan = 'sakit' THEN 1 END) as jumlah_sakit"),
            DB::raw("COUNT(CASE WHEN absensiguru.keterangan = 'alfa' THEN 1 END) as jumlah_alfa"),
            'hari',
            'nama_kelas'
        )
            ->groupBy(DB::raw("DATE_FORMAT(sesi_kelas_guru.tanggal, '%M')"), 'absensiguru.keterangan', 'guru.nama_guru', 'hari', 'nama_kelas')
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
        
        ->orderBy('nama_guru');

        $laporan = $laporanQuery->clone()->whereBetween('sesi_kelas_guru.tanggal', [$startOfMonth, $endOfMonth])->get();
        $periodeBulan = $tanggal->startOfMonth()->daysUntil($tanggal->copy()->endOfMonth());
        $jumlahHari = ['jumat' => 0, 'sabtu' => 0, 'minggu' => 0, 'senin' => 0, 'selasa' => 0, 'rabu' => 0, 'kamis' => 0];
        foreach ($periodeBulan as $hari) {
            $dayOfWeek = $hari->dayOfWeek;
            switch($dayOfWeek) {
                case 0:
                    $jumlahHari['minggu']++;
                    break;
                case 1:
                    $jumlahHari['senin']++;
                    break;
                case 2:
                    $jumlahHari['selasa']++;
                    break;
                case 3:
                    $jumlahHari['rabu']++;
                    break;
                case 4:
                    $jumlahHari['kamis']++;
                    break;
                case 5:
                    $jumlahHari['jumat']++;
                    break;
                case 6:
                    $jumlahHari['sabtu']++;
                    break;
            }
        }
        $laporan->append('jumlahHari');
        foreach ($laporan as $absensiGuru) {
            if (isset($jumlahHari[$absensiGuru->hari])) {
                $absensiGuru->jumlahHari = $jumlahHari[$absensiGuru->hari];
            } else {
                // Tindakan jika kunci tidak ditemukan dalam array $jumlahHari
                // Misalnya, Anda dapat memberikan nilai default ke $absensiGuru->jumlahHari
            }
        }


        $laporanSemester = $laporanQuery->get();

        $laporan_per_bulan = null;
        foreach ($laporanSemester as $data) {
            if (isset($data->bulan) && isset($data->nama_guru)) {
                $bulan = $data->bulan;
                $nama_guru = $data->nama_guru;

                if (!isset($laporan_per_bulan[$bulan][$nama_guru])) {
                    $laporan_per_bulan[$bulan][$nama_guru] = [
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alfa' => 0,
                    ];
                }

                switch ($data->keterangan) {
                    case 'hadir':
                        $laporan_per_bulan[$bulan][$nama_guru]['hadir'] += $data->total;
                        break;
                    case 'izin':
                        $laporan_per_bulan[$bulan][$nama_guru]['izin'] += $data->total;
                        break;
                    case 'sakit':
                        $laporan_per_bulan[$bulan][$nama_guru]['sakit'] += $data->total;
                        break;
                    case 'alfa':
                        $laporan_per_bulan[$bulan][$nama_guru]['alfa'] += $data->total;
                        break;
                }
            }
        }
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
            $tanggal = $tanggal->format('Y-m');
        } catch (InvalidFormatException $ex) {
            $tanggal = now()->format('Y-m');
        }

        $laporanDetail = Absensiguru::query()
        ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', 'sesi_kelas_guru.id')
        ->leftJoin('daftar_jadwal', 'daftar_jadwal.id', 'absensiguru.daftar_jadwal_id')

        ->leftJoin('kelasmi', 'kelasmi.id', 'sesi_kelas_guru.kelasmi_id')
        ->leftJoin('guru', 'guru.id', 'daftar_jadwal.guru_id')
        ->select(
            DB::raw("DATE_FORMAT(sesi_kelas_guru.tanggal,'%M') as bulan"),
            'guru.nama_guru',
            'kelasmi.nama_kelas',
            'keterangan',

            DB::raw('count(*) as total'),
            DB::raw('count(DISTINCT sesi_kelas_guru.id) as jumlah_sesi_kelas_guru'),
        )
            ->groupBy(DB::raw("DATE_FORMAT(sesi_kelas_guru.tanggal,'%M')"),  'guru.nama_guru', 'nama_kelas', 'keterangan')
        ->whereBetween('sesi_kelas_guru.tanggal', [$startOfMonth, $endOfMonth])
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))

            ->orderBy('nama_kelas')
            ->orderBy('nama_guru')
        ->get();
        return view(
            'presensi.guru.laporan.laporanSemester',
            [
                'laporan' => $laporan,
                'tanggal' => $tanggal,
                'laporan_per_bulan' => $laporan_per_bulan,
                'kelasmi' => $kelasmi,
                'laporanDetail' => $laporanDetail,




            ]
        );
    }
    public function DeleteSesi(Sesi_Kelas_Guru $sesi_Kelas_Guru)

    {


        Sesi_Kelas_Guru::destroy($sesi_Kelas_Guru->id);
        Absensiguru::where('sesi_kelas_guru_id', $sesi_Kelas_Guru->id)->delete();
        return redirect()->back();
    }

}
