<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\KalenderPendidikan;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderPendidikanController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('is_active', 1)->first();

        if (!$periodeAktif) {
            return view(
                'kalender-pendidikan.index',
                [
                    'data' => collect(),
                    'pesan' => 'Periode aktif belum tersedia'
                ]
            );
        }

        $data = KalenderPendidikan::with('periode')
            ->where('periode_id', $periodeAktif->id)
            ->latest()
            ->paginate(10);

        return view(
            'kalender-pendidikan.index',
            compact('data', 'periodeAktif')
        );
    }

    public function create()
    {
        $periodeAktif = Periode::where('is_active', 1)->first();

        if (!$periodeAktif) {
            return redirect()
                ->route('kalender-pendidikan.index')
                ->with('error', 'Periode aktif belum tersedia');
        }

        $tahunMulai = \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->year;
        $tahunSelesai = \Carbon\Carbon::parse($periodeAktif->tanggal_selesai ?? $periodeAktif->tanggal_mulai)->year;

        return view('kalender-pendidikan.create', [
            'periodeAktif' => $periodeAktif,
            'tahunMulai' => $tahunMulai,
            'tahunSelesai' => $tahunSelesai,
        ]);
    }

    public function store(Request $request)
    {
        $periodeAktif = Periode::where('is_active', 1)->first();

        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori'        => 'required|string',
            'keterangan'      => 'nullable|string',
        ]);

        $validated['periode_id'] = $periodeAktif->id;

        KalenderPendidikan::create($validated);

        return redirect()
            ->route('kalender-pendidikan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(
        KalenderPendidikan $kalenderPendidikan
    ) {
        return view(
            'kalender-pendidikan.show',
            compact('kalenderPendidikan')
        );
    }

    public function edit(KalenderPendidikan $kalenderPendidikan)
    {
        return view('kalender-pendidikan.edit', [
            'kalender' => $kalenderPendidikan
        ]);
    }

    public function update(Request $request, KalenderPendidikan $kalenderPendidikan)
    {
        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori'        => 'required|string|max:100',
            'keterangan'      => 'nullable|string',
        ]);

        $kalenderPendidikan->update($validated);

        return redirect()
            ->route('kalender-pendidikan.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(
        KalenderPendidikan $kalenderPendidikan
    ) {
        $kalenderPendidikan->delete();

        return redirect()
            ->route('kalender-pendidikan.index')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }


    public function pdf()
    {
        $periodeAktif = Periode::where('is_active', true)->first();
        

        if (!$periodeAktif) {
            return redirect()
                ->route('kalender-pendidikan.index')
                ->with('error', 'Periode aktif belum tersedia.');
        }

        Carbon::setLocale('id');

        $tahun = Carbon::parse($periodeAktif->tanggal_mulai)->year;

        $events = KalenderPendidikan::where('periode_id', $periodeAktif->id)
            ->where('aktif', true)
            ->orderBy('tanggal_mulai')
            ->get()
            ->map(function ($event) {

                $event->start = Carbon::parse($event->tanggal_mulai);

                $event->end = Carbon::parse(
                    $event->tanggal_selesai ?? $event->tanggal_mulai
                );

                $event->kode_kategori = match ($event->kategori) {
                    'Pembelajaran' => 'P',
                    'Ujian' => 'U',
                    'Libur' => 'L',
                    'Hari Besar Nasional' => 'HN',
                    'Hari Besar Keagamaan' => 'HK',
                    'Peringatan Internasional' => 'PI',
                    'Rapat' => 'R',
                    'Kegiatan Sekolah' => 'K',
                    'Ekstrakurikuler' => 'E',
                    'PPDB' => 'PPDB',
                    'Kelulusan' => 'KL',
                    'Asesmen' => 'A',
                    default => 'X',
                };

                $event->kode_kegiatan = strtoupper(
                    substr(
                        preg_replace('/[^A-Za-z]/', '', $event->nama_kegiatan),
                        0,
                        1
                    )
                );

                return $event;
            });

        return Pdf::loadView(
            'kalender-pendidikan.pdf',
            compact(
                'periodeAktif',
                'events',
                'tahun',
                
            )
        )
            ->setPaper('f4', 'landscape')
            ->stream(
                'Kalender Pendidikan ' .
                    str_replace('/', '-', $periodeAktif->periode) .
                    '.pdf'
            );
    }
    
}
