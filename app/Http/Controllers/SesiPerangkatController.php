<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use App\Models\SesiPerangkat;
use Illuminate\Support\Carbon;
use App\Models\AbsensiPerangkat;
use App\Models\Kelasmi;
use Illuminate\Support\Facades\DB;
use Carbon\Exceptions\InvalidFormatException;

class SesiPerangkatController
{
    public function sesiPerangkat(Request $request)
    {
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
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
            ->where('sesi_perangkat.tanggal', $tanggal->toDateString())
            ->get();
        
        return view('perangkat.absensi.sesi', compact(
            [
               
                'hariIni',
                'dataSesiPerangkat',
                'tanggal'
            ]
        ));
    }
    public function buatSesi(Request $request)
    {
        
        $dataPeriode = Periode::latest('id')->first();
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
        $sesi = SesiPerangkat::where('tanggal', $tanggal)
            ->where('periode_id', $dataPeriode->id)
            // ->where('status', 'Aktif')
            ->where('sesi_perangkat.tanggal', $request->tanggal)
            ->first();
        if (!$sesi) {
            try {
                $sesi = new SesiPerangkat();
                $sesi->tanggal = $tanggal;
                

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
            ->leftJoin('absensi_perangkat', function ($join) use ($sesiPerangkat) {
                $join->on('absensi_perangkat.perangkat_id', '=', 'perangkat.id')
                ->where('absensi_perangkat.sesi_perangkat_id', $sesiPerangkat->id);
            })
            ->select(
                'perangkat.id',
                'perangkat.nama_perangkat',
                'absensi_perangkat.keterangan as status_presensi',
                'absensi_perangkat.alasan as alasan_presensi'
            )
            ->where('perangkat.status', 'Aktif')
            ->orderBy('perangkat.nama_perangkat')
            ->get();

        return view('perangkat.absensi.daftarsesi', compact(
            'dataPerangkat',
            'sesiPerangkat'
        ));
    }

    public function StoredaftarSesi(Request $request)
    {
        foreach ($request->perangkat_id as $id) {
            AbsensiPerangkat::updateOrCreate(
                [
                    'perangkat_id' => $id,
                    'sesi_perangkat_id' => $request->sesi_perangkat_id
                ],
                [
                    'keterangan' => $request->keterangan[$id] ?? 'hadir',
                    'alasan' => $request->alasan[$id] ?? null,
                ]
            );
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
        $kelasmi = Kelasmi::first();
        // dd($kelasmi);
        try {
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();
        } catch (InvalidFormatException $ex) {
            $tanggal = now();
        }
        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->where('periode.id', session('periode_id'))
            ->first();


        $laporanBulanan = AbsensiPerangkat::query()
            ->leftJoin('perangkat', 'absensi_perangkat.perangkat_id', '=', 'perangkat.id')

            ->leftJoin('jabatan_perangkat', 'jabatan_perangkat.perangkat_id', '=', 'perangkat.id') // ✅ pivot benar

            ->leftJoin('jabatan', 'jabatan.id', '=', 'jabatan_perangkat.jabatan_id') // ✅ ambil jabatan

            ->leftJoin('sesi_perangkat', 'absensi_perangkat.sesi_perangkat_id', '=', 'sesi_perangkat.id')
            ->select(
            'sesi_perangkat.tanggal',
            'perangkat.nama_perangkat',
            'jabatan.nama_jabatan', // ✅ ambil jabatan

            DB::raw('COUNT(*) as total'),

            DB::raw('SUM(CASE WHEN absensi_perangkat.keterangan = "alfa" THEN 1 ELSE 0 END) as jumlah_alfa'),
            DB::raw('SUM(CASE WHEN absensi_perangkat.keterangan = "hadir" THEN 1 ELSE 0 END) as jumlah_hadir'),
            DB::raw('SUM(CASE WHEN absensi_perangkat.keterangan = "izin" THEN 1 ELSE 0 END) as jumlah_izin'),
            DB::raw('SUM(CASE WHEN absensi_perangkat.keterangan = "sakit" THEN 1 ELSE 0 END) as jumlah_sakit')
            )
            ->whereBetween('sesi_perangkat.tanggal', [
                $periodeBulan->first()->toDateString(),
                $periodeBulan->last()->toDateString()
            ])
            ->groupBy(
                'sesi_perangkat.tanggal',
                'perangkat.nama_perangkat',
                'jabatan.nama_jabatan' // ✅ WAJIB masuk groupBy
            )
            ->orderBy('jabatan.nama_jabatan') // opsional: urut berdasarkan jabatan
            ->orderBy('perangkat.nama_perangkat')
            ->get();
        $kepalaSekolah = $laporanBulanan
            ->where('nama_jabatan', 'Kepala Sekolah')
            ->first();
        return view('perangkat.absensi.laporanBulanan', compact('laporanBulanan', 'tanggal', 'bulan', 'periodeBulan', 'periode', 'kelasmi', 'kepalaSekolah'));
    }
    public function rekapSesiPerangkat(Request $request)
    {
        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();

        // Ambil range tanggal 1 bulan
        $start = $bulan->copy()->startOfMonth();
        $end   = $bulan->copy()->endOfMonth();
        $periodeBulan = $start->daysUntil($end);

        // Ambil semua perangkat
        $datakelasmi = Perangkat::query()
            ->where('status', 'Aktif')
            ->get();

        // Ambil data sesi + absensi
        $dataSesikelasguru = SesiPerangkat::query()
            ->leftJoin('absensi_perangkat', 'absensi_perangkat.sesi_perangkat_id', '=', 'sesi_perangkat.id')
            ->leftJoin('perangkat', 'perangkat.id', '=', 'absensi_perangkat.perangkat_id') // 🔥 ubah jadi leftJoin
            ->select(
                'sesi_perangkat.tanggal',
                'absensi_perangkat.perangkat_id',
                'absensi_perangkat.keterangan'
            )
            ->where('sesi_perangkat.periode_id', session('periode_id'))
            ->whereBetween('sesi_perangkat.tanggal', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy('perangkat_id')
            ->map(function ($items) {
                return $items->keyBy('tanggal'); // 🔥 biar cepat lookup
            });

        // Mapping rekap
        $dataRekapSesi = $datakelasmi
            ->keyBy('id')
            ->map(function ($perangkat, $perangkat_id) use ($dataSesikelasguru, $periodeBulan) {

            $sesiPerBulan = []; // ✅ reset tiap perangkat

            foreach ($periodeBulan as $hari) {
                $tanggal = $hari->toDateString();

                $data = $dataSesikelasguru
                    ->get($perangkat_id) // aman
                    ?->get($tanggal);      // cepat (tanpa firstWhere)

                $sesiPerBulan[] = [
                    'hari' => $hari,
                    'data' => $data
                ];
            }

            return [
                'perangkat' => $perangkat,
                'sesiPerBulan' => $sesiPerBulan,
                ];
            });

        return view('perangkat.absensi.rekap-sesi', [
            'dataRekapSesi' => $dataRekapSesi,
            'periodeBulan'  => $periodeBulan,
            'bulan'         => $bulan,
        ]);
    }
}
