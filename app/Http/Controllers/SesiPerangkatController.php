<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use App\Models\SesiPerangkat;
use Illuminate\Support\Carbon;
use App\Models\AbsensiPerangkat;
use Illuminate\Support\Facades\DB;
use Carbon\Exceptions\InvalidFormatException;

class SesiPerangkatController
{
    public function sesiPerangkat()
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->get();

        date_default_timezone_set('Asia/Jakarta'); // set timezone to WIB
        $hariIni = date('l, d F Y', strtotime('now'));
        $dataSesiPerangkat = SesiPerangkat::query()
            ->Join('periode', 'periode.id', '=', 'sesi_perangkat.periode_id')
            ->Join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('sesi_perangkat.periode_id', session('periode_id'))
            ->select(
                'sesi_perangkat.id',
                'tanggal',
                'periode',
                'ket_semester',
            )
            ->get();
        return view('perangkat.absensi.sesi', compact(
            [
                'dataPeriode',
                'hariIni',
                'dataSesiPerangkat'
            ]
        ));
    }
    public function buatSesi()
    {
        $dataPeriode = Periode::latest('id')->first();
        $hariIni = now()->format('Y-m-d');
        $sesi = SesiPerangkat::where('tanggal', $hariIni)
            ->where('periode_id', $dataPeriode->id)
            ->first();

        if (!$sesi) {
            try {
                $sesi = new SesiPerangkat();
                $sesi->tanggal = $hariIni;
                $sesi->periode_id = $dataPeriode->id;
                $sesi->save();
            } catch (\Illuminate\Database\QueryException $e) {
                // Handle error caused by unique constraint violation
            }
        }
        return redirect()->back();
    }
    public function daftarSesi(SesiPerangkat $sesiPerangkat)
    {
        $dataPerangkat = Perangkat::query()
            ->leftjoin('absensi_perangkat', function ($join) use ($sesiPerangkat) {
                $join->on('absensi_perangkat.perangkat_id', '=', 'perangkat.id')
                    ->where('absensi_perangkat.sesi_perangkat_id', '=', $sesiPerangkat->id);
            })
            
            ->select('perangkat.id', 'nama_perangkat', 'keterangan', 'alasan')
            ->get();
        return view('perangkat.absensi.daftarsesi', compact('dataPerangkat', 'sesiPerangkat'));
    }
    public function StoredaftarSesi(Request $request)
    {
        
        foreach ($request->perangkat_id as $item) {
            $presensiasrama = AbsensiPerangkat::updateOrCreate(
                ['perangkat_id' => $item, 'sesi_perangkat_id' => $request->sesi_perangkat_id],
                ['keterangan' => $request->keterangan[$item], 'alasan' => $request->alasan[$item]]
            );
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
        $laporanHarian = AbsensiPerangkat::query()
            ->leftjoin('perangkat', 'absensi_perangkat.perangkat_id', '=', 'perangkat.id')
            ->leftjoin('sesi_perangkat', 'absensi_perangkat.sesi_perangkat_id', '=', 'sesi_perangkat.id')
            ->select('sesi_perangkat.tanggal', 'nama_perangkat', 'keterangan', 'alasan')
            ->groupBy('sesi_perangkat.tanggal', 'nama_perangkat', 'keterangan', 'alasan')
            ->where('sesi_perangkat.tanggal', $tanggal->toDateString())
            ->get();

        return view('perangkat.absensi.laporanHarian', compact('laporanHarian', 'tanggal'));
    }
    public function LaporanBulanan(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
        $laporanBulanan = AbsensiPerangkat::query()
            ->leftJoin('perangkat', 'absensi_perangkat.perangkat_id', '=', 'perangkat.id')
            ->leftJoin('sesi_perangkat', 'absensi_perangkat.sesi_perangkat_id', '=', 'sesi_perangkat.id')
            ->select(
                'tanggal',
                'nama_perangkat',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN keterangan = "alfa" THEN 1 ELSE 0 END) as jumlah_alfa'),
                DB::raw('SUM(CASE WHEN keterangan = "hadir" THEN 1 ELSE 0 END) as jumlah_hadir'),
                DB::raw('SUM(CASE WHEN keterangan = "izin" THEN 1 ELSE 0 END) as jumlah_izin'),
                DB::raw('SUM(CASE WHEN keterangan = "sakit" THEN 1 ELSE 0 END) as jumlah_sakit')
            )
            ->groupBy('nama_perangkat', 'tanggal')
            ->whereMonth('sesi_perangkat.tanggal', $tanggal->month)
            ->get();




        return view('perangkat.absensi.laporanBulanan', compact('laporanBulanan', 'tanggal'));
    }
}
