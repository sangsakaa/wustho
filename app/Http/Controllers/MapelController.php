<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('tab')) {
            session(['active_tab' => $request->tab]);
        }

        $datakelas = Kelas::orderBy('kelas')->get();

        $Pelajara = Mapel::with(['kelas', 'periode.semester'])
            ->withCount('gurus')
            ->where('periode_id', session('periode_id'))
            ->orderBy('kelas_id')
            ->orderBy('mapel')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'mapel' => $item->mapel,
                    'nama_kitab' => $item->nama_kitab,
                    'kelas' => $item->kelas->kelas ?? '-',
                    'periode' => $item->periode->periode ?? '-',
                    'ket_semester' => $item->periode->semester->ket_semester ?? '-',
                    'gurus_count' => $item->gurus_count ?? 0,
                ];
            });

        return view('mapel.mapel', [
            'listmapel' => $Pelajara,
            'datakelas' => $datakelas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester', 'desc')
            ->where('periode.id', session('periode_id'))
            ->get();
        $datakelas = Kelas::all();
        return view('mapel/addmapel', [
            'datakelas' => $datakelas,
            'dataPeriode' => $dataPeriode
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mapel = new Mapel();
        $mapel->mapel = $request->mapel;
        $mapel->nama_kitab = $request->nama_kitab;
        $mapel->kelas_id = $request->kelas_id;
        $mapel->periode_id = $request->periode_id;
        $mapel->save();
        return redirect()->back()->with('success', 'berhasil menambahkan data ini');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mapel $mapel)
    {
        $periode_id = session('periode_id');

        $gurus = Guru::where('status', 'Aktif')
            ->orderBy('nama_guru', 'asc')
            ->get();

        $mapel->load([
            'kelas',
            'periode.semester',
            'gurus',

            'daftar_jadwal' => function ($q) use ($periode_id) {
                $q->whereHas('jadwal', function ($q2) use ($periode_id) {
                    $q2->where('periode_id', $periode_id);
                });
            },
            'daftar_jadwal.guru',
            'daftar_jadwal.jadwal.kelasmi'
        ]);

        return view('mapel.show', compact('mapel', 'gurus'));
    }
    public function generatePengampuFromJadwal(Mapel $mapel)
    {
        $periode_id = session('periode_id');

        // ambil semua guru dari jadwal aktif
        $guruIds = $mapel->daftar_jadwal()
            ->whereHas('jadwal', function ($q) use ($periode_id) {
                $q->where('periode_id', $periode_id);
            })
            ->pluck('guru_id')
            ->unique()
            ->filter()
            ->values();

        // attach tanpa duplikat
        $mapel->gurus()->syncWithoutDetaching($guruIds);

        return back()->with('success', 'Pengampu berhasil digenerate dari jadwal');
    }
    public function generateAllPengampuFromJadwal()
    {
        $periode_id = session('periode_id');

        $mapels = Mapel::all();

        foreach ($mapels as $mapel) {
            $guruIds = $mapel->daftar_jadwal()
                ->whereHas('jadwal', function ($q) use ($periode_id) {
                    $q->where('periode_id', $periode_id);
                })
                ->pluck('guru_id')
                ->unique()
                ->filter()
                ->values()
                ->toArray();

            if (!empty($guruIds)) {
                $mapel->gurus()->syncWithoutDetaching($guruIds);
            }
        }

        return back()->with('success', 'Semua pengampu berhasil digenerate dari jadwal');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mapel $mapel)
    {
        $datakelas = Kelas::all();
        $dataPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.ket_semester')
            ->orderby('ket_semester', 'desc')
            // ->where('periode.id', session('periode_id'))
            ->get();
        return view('mapel.editmapel', compact('datakelas', 'mapel', 'dataPeriode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapel $mapel)
    {
        Mapel::where('id', $mapel->id)
            ->update([
                'mapel' => $request->mapel,
                'nama_kitab' => $request->nama_kitab,
                'kelas_id' => $request->kelas_id,
                'periode_id' => $request->periode_id,
            ]);
        return redirect('/mapel')->with('update', 'berhasil diperbaharui data ini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapel $mapel)
    {
        // cek apakah masih punya pengampu
        if ($mapel->gurus()->count() > 0) {
            return back()->with(
                'delete',
                'Mapel tidak bisa dihapus karena masih memiliki pengampu aktif'
            );
        }

        // cek apakah masih dipakai jadwal
        if ($mapel->daftar_jadwal()->count() > 0) {
            return back()->with(
                'delete',
                'Mapel tidak bisa dihapus karena masih digunakan pada jadwal'
            );
        }

        try {
            // bersihkan relasi pivot kalau ada
            $mapel->gurus()->detach();

            // hapus data
            $mapel->delete();

            return back()->with('success', 'Berhasil menghapus mapel');
        } catch (\Exception $e) {
            return back()->with(
                'delete',
                'Gagal menghapus mapel: data masih berelasi dengan tabel lain'
            );
        }
    }
    public function laporanPdf(Request $request)
    {
        $periode_id = $request->periode_id ?? session('periode_id');

        $mapel = Mapel::with([
            'kelas',
            'periode.semester',
            'daftar_jadwal' => function ($q) use ($periode_id) {
                $q->whereHas('jadwal', function ($q2) use ($periode_id) {
                    $q2->where('periode_id', $periode_id);
                });
            },
            'daftar_jadwal.guru',
            'daftar_jadwal.jadwal.kelasmi'
        ])
            ->where('periode_id', $periode_id)
            ->get();

        // 🔥 GROUP BY KELAS (seperti laporan sebelumnya)
        $grouped = $mapel->groupBy(function ($item) {
            return $item->kelas->kelas ?? 'Tanpa Kelas';
        });

        $periode = Periode::with('semester')->find($periode_id);

        $pdf = Pdf::loadView('mapel.laporan_pdf', [
            'data' => $grouped,
            'periode' => $periode
        ])->setPaper('A4', 'potrait');

        return $pdf->stream('laporan-kurikulum.pdf');
    }
    public function storePengampu(Request $request, Mapel $mapel)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
        ]);

        // attach pengampu (hindari duplikat)
        $mapel->gurus()->syncWithoutDetaching([$request->guru_id]);

        return redirect()->back()->with('success', 'Pengampu berhasil ditambahkan');
    }
    public function destroyPengampu(Mapel $mapel, Guru $guru)
    {
        // detach pengampu
        $mapel->gurus()->detach($guru->id);

        return redirect()->back()->with('success', 'Pengampu berhasil dihapus');
    }
}
