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
        } catch (\Throwable $th) {
            $tgl = now();
        }

        $Datasesikelas = Sesikelas::query()

            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')

            ->select([
                'sesikelas.id',
                'sesikelas.tgl',
            'sesikelas.status',
                'sesikelas.kelasmi_id',

            'kelasmi.nama_kelas',

            'periode.periode',

                'semester.ket_semester',
            ])

            // jumlah hadir
            ->selectSub(function ($query) {

                $query->from('absensikelas')
                ->selectRaw('COUNT(DISTINCT absensikelas.pesertakelas_id)')
                ->whereColumn(
                    'absensikelas.sesikelas_id',
                    'sesikelas.id'
                );
        }, 'hadir_count')

            // jumlah peserta
            ->selectSub(function ($query) {

                $query->from('pesertakelas')
                    ->selectRaw('COUNT(*)')
                ->whereColumn(
                    'pesertakelas.kelasmi_id',
                    'sesikelas.kelasmi_id'
                );
            }, 'peserta_count')

            ->where('kelasmi.periode_id', session('periode_id'))

            ->whereDate(
                'sesikelas.tgl',
                $tgl->toDateString()
            )

            ->orderBy('kelasmi.nama_kelas')

            ->get()

            ->map(function ($item) {

            $hadir   = (int) $item->hadir_count;
                $peserta = (int) $item->peserta_count;

            $item->progress = $peserta > 0
                    ? round(($hadir / $peserta) * 100)
                    : 0;

            $status = match (true) {

                $item->status === 'close' => [
                    'status_ui' => 'close',
                    'note'      => 'Close',
                ],

                $hadir === 0 => [
                    'status_ui' => 'belum',
                    'note'      => 'Belum Mulai',
                ],

                $hadir < $peserta => [
                    'status_ui' => 'proses',
                    'note'      => 'Proses',
                ],

                default => [
                    'status_ui' => 'selesai',
                    'note'      => 'Selesai',
                ],
            };

            $item->status_ui = $status['status_ui'];
            $item->note      = $status['note'];

                return $item;
            });

        return view('presensi.kelas.sesikelas', [
            'Datasesikelas' => $Datasesikelas,
            'sesikelas'     => $sesikelas,
            'tgl'           => $tgl,
        ]);
    }
    public function toggle($id)
    {
        $sesi = Sesikelas::findOrFail($id);

        $sesi->update([
            'status' => $sesi->status === 'open'
                ? 'close'
                : 'open'
        ]);

        return back()->with(
            'success',
            'Status sesi berhasil diperbarui'
        );
    }
    public function bulkToggleSession(Request $request)
    {
        $validated = $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:sesikelas,id'],
        ]);

        $sessions = Sesikelas::whereIn('id', $validated['ids'])->get();

        if ($sessions->isEmpty()) {
            return back()->with('error', 'Data sesi tidak ditemukan');
        }

        foreach ($sessions as $session) {

            $session->update([
                'status' => $session->status === 'open'
                    ? 'close'
                    : 'open'
            ]);
        }

        return back()->with(
            'success',
            $sessions->count() . ' sesi berhasil diperbarui'
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'tgl' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $periodeId = session('periode_id');

        // Semua kelas pada periode aktif
        $dataKelasMi = Kelasmi::where('periode_id', $periodeId)
            ->orderBy('nama_kelas')
            ->get();

        // Kelas yang sudah memiliki sesi pada tanggal tersebut
        $existingKelasIds = Sesikelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'sesikelas.kelasmi_id')
            ->where('kelasmi.periode_id', $periodeId)
            ->whereDate('sesikelas.tgl', $request->tgl)
            ->pluck('sesikelas.kelasmi_id')
            ->toArray();

        $existing = array_flip($existingKelasIds);

        $dataInsert = [];

        foreach ($dataKelasMi as $kelasmi) {

            if (!isset($existing[$kelasmi->id])) {

                $dataInsert[] = [
                    'tgl'        => $request->tgl,
                    'kelasmi_id' => $kelasmi->id,
                    'status'     => 'open', // jika field status ada
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Jumlah sesi yang akan dibuat
        $created = count($dataInsert);

        if ($created > 0) {
            Sesikelas::insert($dataInsert);

            return back()->with(
                'success',
                "{$created} sesi berhasil ditambahkan"
            );
        }

        return back()->with(
            'error',
            'Semua sesi sudah tersedia'
        );
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
