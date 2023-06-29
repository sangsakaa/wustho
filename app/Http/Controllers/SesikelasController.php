<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Sesikelas;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;


class SesikelasController
{
    public function index(Request $request, Sesikelas $sesikelas)
    {
        try {
            $tgl = $request->tgl ? Carbon::parse($request->tgl) : now();
        } catch (InvalidFormatException $ex) {
            $tgl = now();
        }

        $dataKelasMi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $Datasesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester')
            ->orderBy('kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('sesikelas.tgl', $tgl->toDateString())
            ->get();

        return view('presensi.kelas.sesikelas', [
            'dataKelasMi' => $dataKelasMi,
            'Datasesikelas' => $Datasesikelas,
            'sesikelas' => $sesikelas,
            'tgl' => $tgl,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
        ]);

        $dataKelasMi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        $sesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas')
            ->orderBy('kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('sesikelas.tgl', $request->tgl)
            ->get();

        foreach ($dataKelasMi as $kelasmi) {
            if ($sesikelas->doesntContain('nama_kelas', $kelasmi->nama_kelas)) {
                $sesi = new Sesikelas();
                $sesi->tgl = $request->tgl;
                $sesi->kelasmi_id = $kelasmi->id;
                $sesi->save();
            }
        }

        return redirect()->back()->with('success', 'Sesi Berhasil ditambahkan');
    }

    public function destroy(Sesikelas $sesikelas)
    {
        
        Sesikelas::destroy($sesikelas->id);
        Absensikelas::where('sesikelas_id', $sesikelas->id)->delete();
        return redirect()->back()->with('delete', 'Sesi Ini sudah berhasil di hapus');
    }

    public function rekapSesi(Request $request)
    {
        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());

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

        $dataSesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
            ->get()
            ->groupBy('kelasmi_id');

        $dataRekapSesi = $datakelasmi
            ->keyBy('id')
            ->map(function ($kelasmi, $kelasmi_id) use ($dataSesikelas, $periodeBulan) {
            dd($kelasmi);
                foreach ($periodeBulan as $hari) {
                    $sesiPerBulan[] = [
                        'hari' => $hari,
                        'data' => $dataSesikelas->count() ? $dataSesikelas[$kelasmi_id]->firstWhere('tgl', $hari->toDateString()) : null
                    ];
                }
                return [
                    'sesiPerBulan' => $sesiPerBulan,
                    'kelasmi' => $kelasmi,
                ];
            });

        return view('presensi.kelas.rekapSesi', [
            'dataRekapSesi' => $dataRekapSesi,
            'periodeBulan' => $periodeBulan,
            'periode' => $periode,
            'bulan' => $bulan,
        ]);
    }
}
