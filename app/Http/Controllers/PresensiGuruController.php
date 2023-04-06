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
            ->orderbY('periode.id', 'desc')->first();
        $dataKelasMi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $sesikelas = Sesi_Kelas_Guru::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesi_kelas_guru.kelasmi_id')
            ->select('sesi_kelas_guru.*', 'kelasmi.nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->where('sesi_kelas_guru.periode_id', session('periode_id'))
            ->where('sesi_kelas_guru.tanggal', $request->tanggal)
            ->get();

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
        $datetime = DateTime::createFromFormat('Y-m-d', $sesi_Kelas_Guru->tanggal);
        if ($datetime !== false) {
            $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $formatter->setPattern('EEEE');
            $hari = $formatter->format($datetime);
        } else {
            // handle error here
        }
        // dd($hari);

        $dataGuru = Daftar_Jadwal::query()
            ->join('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->join('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->leftjoin('absensiguru', 'absensiguru.daftar_jadwal_id', '=', 'daftar_jadwal.id')
            ->select(
                [
                    'nama_guru',
                    'hari',
                    'jadwal.kelasmi_id',
                    'daftar_jadwal.id',
                    'absensiguru.alasan'
                ]
            )
            ->where('hari', $hari)
            ->where('jadwal.kelasmi_id', $sesi_Kelas_Guru->kelasmi_id)
            ->get();
        return view(
            'presensi.guru.DaftarHadirGuru',
            compact(
                [
                    'dataGuru',
                    'sesi_Kelas_Guru',

                ]
            )
        );
    }
    public function AbsenGuru(Request $request)
    {

        $absenGuru = Absensiguru::where('sesi_kelas_guru_id', $request->sesi_kelas_guru_id)->first();

        if (!$absenGuru) {
            $absenGuru = new Absensiguru();
            $absenGuru->sesi_kelas_guru_id = $request->sesi_kelas_guru_id;
            $absenGuru->daftar_jadwal_id = $request->daftar_jadwal_id;
        }

        $absenGuru->keterangan = implode(", ", $request->keterangan); // ubah array menjadi string
        $absenGuru->alasan = implode(", ", $request->alasan); // ubah array menjadi string

        $absenGuru->save();
        return redirect()->back();
    }
    public function LaporanHarian(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
        $laporan = Absensiguru::query()
            ->leftJoin('sesi_kelas_guru', 'absensiguru.sesi_kelas_guru_id', 'sesi_kelas_guru.id')
            ->select(
                'sesi_kelas_guru.tanggal',
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "hadir" THEN 1 END) as hadir'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "izin" THEN 1 END) as izin'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "sakit" THEN 1 END) as sakit'),
                DB::raw('COUNT(CASE WHEN absensiguru.keterangan = "alfa" THEN 1 END) as alfa')
            )
            ->groupBy('sesi_kelas_guru.tanggal')
            ->get();
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
        return view('presensi.guru.laporan.laporan', compact(
            'laporan',
            'laporanGuru',
            'tanggal'

        ));
    }
}
