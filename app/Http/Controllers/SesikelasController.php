<?php

namespace App\Http\Controllers;

use App\Models\Absensikelas;
use App\Models\Kelasmi;
use App\Models\Periode;
use App\Models\Sesikelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SesikelasController
{
    public function index(Request $request, Sesikelas $sesikelas)
    {
        try {
            $tgl = $request->filled('tgl')
                ? Carbon::parse($request->tgl)
                : now();
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            $tgl = now();
        }

        // =========================
        // SUMMARY (PER KELAS)
        // =========================
        $kelasSummary = Kelasmi::query()
            ->withCount(['pesertakelas', 'sesikelas'])
            ->where('periode_id', session('periode_id'))
            ->get();

        // =========================
        // DATA SESI (TABLE DETAIL)
        // =========================
        $Datasesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->select(
                'sesikelas.id',
                'sesikelas.tgl',
                'sesikelas.kelasmi_id',
                'kelasmi.nama_kelas',
                'periode.periode',
                'semester.ket_semester'
            )

            // absensi per sesi
            ->selectSub(function ($q) {
                $q->from('absensikelas')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('absensikelas.sesikelas_id', 'sesikelas.id');
            }, 'absensi_count')

            // peserta per kelas
            ->selectSub(function ($q) {
                $q->from('pesertakelas')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('pesertakelas.kelasmi_id', 'sesikelas.kelasmi_id');
            }, 'peserta_count')

            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereDate('sesikelas.tgl', $tgl->toDateString())
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        return view('presensi.kelas.sesikelas', compact(
            'kelasSummary',
            'Datasesikelas',
            'sesikelas',
            'tgl'
        ));
    }

    public function store(Request $request)
    {
        // dd(1);
        $request->validate([
            'tgl' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $dataKelasMi = Kelasmi::where('periode_id', session('periode_id'))
            ->orderBy('nama_kelas')
            ->get();

        $existingKelasIds = Sesikelas::whereDate('tgl', $request->tgl)
            ->pluck('kelasmi_id')
            ->toArray();

        $created = 0;

        foreach ($dataKelasMi as $kelasmi) {
            if (!in_array($kelasmi->id, $existingKelasIds)) {
                Sesikelas::create([
                    'tgl' => $request->tgl,
                    'kelasmi_id' => $kelasmi->id,
                ]);
                $created++;
            }
        }

        if ($created === 0) {
            return back()->with('error', 'Semua sesi sudah tersedia');
        }

        return back()->with('success', "{$created} sesi berhasil ditambahkan");
    }

    public function destroy(Sesikelas $sesikelas)
    {
        DB::transaction(function () use ($sesikelas) {
            Absensikelas::where('sesikelas_id', $sesikelas->id)->delete();
            $sesikelas->delete();
        });

        return back()->with('success', 'Sesi berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:sesikelas,id'
        ]);

        DB::transaction(function () use ($request) {
            Absensikelas::whereIn('sesikelas_id', $request->ids)->delete();
            Sesikelas::whereIn('id', $request->ids)->delete();
        });

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function rekapSesi(Request $request)
    {
        $bulan = $request->filled('bulan')
            ? Carbon::parse($request->bulan)
            : now();

        $start = $bulan->copy()->startOfMonth();
        $end = $bulan->copy()->endOfMonth();
        $periodeBulan = $start->daysUntil($end);

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

        $dataSesikelas = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->select('sesikelas.*', 'kelasmi.nama_kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereBetween('sesikelas.tgl', [
                $start->toDateString(),
                $end->toDateString()
            ])
            ->get()
            ->groupBy('kelasmi_id');

        $dataRekapSesi = $datakelasmi->keyBy('id')->map(
            function ($kelasmi, $kelasmi_id) use ($dataSesikelas, $periodeBulan) {

                $sesiPerBulan = [];

                foreach ($periodeBulan as $hari) {
                    $sesiPerBulan[] = [
                        'hari' => $hari,
                        'data' => $dataSesikelas->get($kelasmi_id)?->firstWhere(
                            'tgl',
                            $hari->toDateString()
                        ),
                    ];
                }

                return [
                    'sesiPerBulan' => $sesiPerBulan,
                    'kelasmi' => $kelasmi,
                ];
            }
        );

        return view('presensi.kelas.rekapSesi', compact(
            'dataRekapSesi',
            'periodeBulan',
            'periode',
            'bulan'
        ));
    }
}
