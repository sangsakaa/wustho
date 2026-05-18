<?php

namespace App\Http\Controllers;

use App\Models\Daftar_Jadwal;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelasmi;
use App\Models\Mapel;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController
{
    public function Jadwal()
    {
        $daftarPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->orderbY('periode.id', 'desc')->get();
        $daftarKelas = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('nama_kelas')
            ->get();
        $daftarJadwal = Jadwal::query()
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftjoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->leftjoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->select('jadwal.id', 'hari', 'kelasmi.nama_kelas', 'periode.periode', 'kelasmi.periode_id', 'semester.semester', 'semester.ket_semester', 'guru.nama_guru', 'guru.jenis_kelamin', 'mapel.mapel')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderby('kelasmi.nama_kelas')
            ->orderby('kelasmi.nama_kelas')
            ->paginate(6);

        return view('jadwal.daftar', compact(
            [
                'daftarPeriode',
                'daftarJadwal',
                'daftarKelas',
            ]
        ));
    }
    public function StoreJadwal(Request $request)
    {
        $jadwal = new Jadwal();
        $jadwal->hari = $request->hari;
        $jadwal->periode_id = $request->periode_id;
        $jadwal->kelasmi_id = $request->kelasmi_id;

        // cek apakah jadwal sudah ada
        $existingJadwal = Jadwal::where('hari', $request->hari)
            ->where('kelasmi_id', $request->kelasmi_id)
            ->count();

        if ($existingJadwal > 0) {
            return redirect()->back()->with('update', 'pembaharuan data berhasil');
        }

        $jadwal->save();
        return redirect()->back()->with('update', 'pembaharuan data berhasil');
    }
    // Daftar_jadwal

    public function DaftarJadwal(Jadwal $jadwal)
    {
        $periodeId = session('periode_id');

        $jadwal->load('kelasmi');

        $kelasId = $jadwal->kelasmi->kelas_id;

        // ambil mapel yang sudah dipakai di jadwal ini
        $usedMapelIds = Daftar_Jadwal::whereHas('jadwal', function ($q) use ($jadwal, $periodeId) {
            $q->where('periode_id', $periodeId)
                ->where('kelasmi_id', $jadwal->kelasmi_id);
        })
            ->pluck('mapel_id')
            ->toArray();

        // MAPEL hanya sesuai kelas & belum dipakai
        $daftarMapel = Mapel::where('periode_id', $periodeId)
            ->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            })
            ->whereNotIn('id', $usedMapelIds)
            ->orderBy('mapel')
            ->get();

        // GURU dikosongkan dulu (akan di-load via AJAX setelah pilih mapel)
        $daftarGuru = [];

        // jadwal existing
        $daftarJadwal = Daftar_Jadwal::with(['guru', 'mapel'])
            ->where('jadwal_id', $jadwal->id)
            ->get();

        return view('jadwal.jadwal_guru', compact(
            'daftarGuru',
            'daftarMapel',
            'jadwal',
            'daftarJadwal'
        ));
    }
    public function getGuruByMapel(Request $request)
    {
        $mapelId = $request->mapel_id;

        $guru = Guru::where('status', 'Aktif')
            ->whereHas('mapel', function ($q) use ($mapelId) {
                $q->where('mapel.id', $mapelId);
            })
            ->orderBy('nama_guru')
            ->get();

        return response()->json($guru);
    }
    public function editJadwal(Daftar_Jadwal $daftar_Jadwal)
    {
        $periodeId = session('periode_id');

        // 🔥 ambil jadwal
        $jadwal = Jadwal::with('kelasmi')->findOrFail($daftar_Jadwal->jadwal_id);

        // =======================
        // 🔥 GURU (HANYA PENGAMPU SESUAI MAPEL + KELAS + PERIODE)
        // =======================
        $dataGuru = Guru::where('status', 'Aktif')
            ->whereHas('mapels', function ($q) use ($periodeId, $jadwal) {
                $q->where('periode_id', $periodeId)
                    ->whereHas('kelas', function ($q2) use ($jadwal) {
                        $q2->where('id', $jadwal->kelasmi->kelas_id);
                    });
            })
            ->orderBy('nama_guru')
            ->get();

        // =======================
        // 🔥 MAPEL (HANYA SESUAI KELAS + PERIODE)
        // =======================
        $daftarMapel = Mapel::where('periode_id', $periodeId)
            ->whereHas('kelas', function ($q) use ($jadwal) {
                $q->where('id', $jadwal->kelasmi->kelas_id);
            })
            ->with(['kelas', 'periode.semester'])
            ->orderBy('mapel')
            ->get();

        return view('jadwal.edit_jadwal_guru', compact(
            'daftar_Jadwal',
            'daftarMapel',
            'dataGuru',
            'jadwal'
        ));
    }
    public function updateJadwal(Daftar_Jadwal $daftar_Jadwal, Request $request)
    {

        Daftar_Jadwal::where('id', $daftar_Jadwal->id)
            ->update([
                'jadwal_id' => $request->jadwal_id,
                'guru_id' => $request->guru_id,
                'mapel_id' => $request->mapel_id,
            ]);
        return redirect()->back();
    }
    public function CetakJadwal1(Request $request)
    {

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'jenjang')
            ->where('kelasmi.periode_id', session('periode_id'))
            // ->where('kelasmi.id', $request->kelasmi_id)
            ->first();
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->join('kelas', 'kelas.id', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'kelas.kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();
        $jadwalByDay = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->groupBy('kelasmi.nama_kelas') // tambahkan ini
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->select(
                [
                    'hari',
                    'jadwal.id',
                    'kelasmi.nama_kelas',
                    'kelas.kelas',
                    'mapel.mapel',
                    'guru.nama_guru',
                'guru.jenis_kelamin',
                    'jadwal.periode_id',
                    'periode.periode'
                ]
            )
            // ->where('kelas.kelas', 1)
            ->where('kelasmi.periode_id', session('periode_id'))

            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('jadwal.id')
        ->groupBy('hari', 'jadwal.id', 'kelasmi.nama_kelas', 'jadwal.periode_id', 'periode.periode', 'kelas.kelas', 'mapel.mapel', 'guru.nama_guru', 'guru.jenis_kelamin');
        $title = $jadwalByDay;
        $jadwalByDayMap = [];

        // Loop untuk mapping jadwal bedasarkan hari
        foreach ($jadwalByDay->get() as $jadwal) {
            $jadwalByDayMap[$jadwal->hari][] = $jadwal;
        }

        if (request('kelasmi_id')) {
            $jadwal->where('kelas', 'like', '%' . request('kelasmi_id') . '%');
        }
        return view(
            'jadwal.jadwal1',
            [
                'jadwalByDayMap' => $jadwalByDayMap,
                'kelasmi' => $kelasmi,
                'datakelasmi' => $datakelasmi,
                'title' => $title,
            ]
        );
    }
    

    public function StoreDaftarJadwal(Jadwal $jadwal, Request $request)
    {
        $daftarJadwal = new Daftar_Jadwal();
        $daftarJadwal->jadwal_id = $request->jadwal_id;
        $daftarJadwal->guru_id = $request->guru_id;
        $daftarJadwal->mapel_id = $request->mapel_id;

        // validasi jadwal_id dan guru_id tidak boleh sama
        $existingJadwal = Daftar_Jadwal::where('jadwal_id', $request->jadwal_id)
            ->where('guru_id', $request->guru_id)
            ->count();
        if ($existingJadwal > 0) {
            return redirect()->back()->with('update', 'Jadwal untuk kelas dan hari ini sudah ada!');
        }
        $daftarJadwal->save();
        return redirect()->back()->with('update', 'Jadwal untuk kelas dan hari ini sudah ada!');
    }
    public function JadwalKolektif()
    {
        $periodeId = session('periode_id');

        // cek session periode
        if (!$periodeId) {
            return back()->with('error', 'Periode belum dipilih.');
        }

        // cek periode tersedia
        $daftarPeriode = Periode::query()
            ->where('id', $periodeId)
            ->first();

        if (!$daftarPeriode) {
            return back()->with('error', 'Periode tidak ditemukan.');
        }

        // ambil kelas pada periode aktif
        $dataKelasMi = Kelasmi::query()
            ->where('periode_id', $periodeId)
            ->orderBy('nama_kelas')
            ->get();

        if ($dataKelasMi->isEmpty()) {
            return back()->with('error', 'Belum ada data kelas pada periode ini.');
        }

        $hari_array = ['jumat', 'sabtu', 'minggu', 'senin', 'selasa', 'rabu'];

        $created = 0;

        foreach ($dataKelasMi as $kelasmi) {
            foreach ($hari_array as $hari) {

                $exists = Jadwal::where('periode_id', $periodeId)
                    ->where('kelasmi_id', $kelasmi->id)
                    ->where('hari', $hari)
                    ->exists();

                if (!$exists) {
                    Jadwal::create([
                        'periode_id' => $periodeId,
                        'kelasmi_id' => $kelasmi->id,
                        'hari'       => $hari,
                    ]);

                    $created++;
                }
            }
        }

        // jika tidak ada data baru
        if ($created == 0) {
            return back()->with('error', 'Semua jadwal kolektif sudah dibuat sebelumnya.');
        }

        return back()->with(
            'success',
            "Jadwal kolektif berhasil dibuat. {$created} jadwal baru ditambahkan."
        );
    }
    public function LaporanPloting()
    {
        $laporan = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereNotNull('guru.nama_guru')
            ->select('guru.nama_guru', 'periode.periode', 'semester.ket_semester', DB::raw('count(distinct mapel.id) as jumlah_mapel'), DB::raw('count(distinct kelasmi.id) as jumlah_kelas'))
            ->groupBy('guru.id', 'periode.periode', 'guru.nama_guru', 'semester.ket_semester')
        ->orderby('nama_guru')->get();



        return view(
            'jadwal.laporan',
            ['laporan' => $laporan]
        );
    }
    public function LaporanPlotingKelas()
    {
        $laporan = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereNotNull('guru.nama_guru')
            ->select('guru.nama_guru', 'nama_kelas', 'mapel.mapel', DB::raw('count(distinct mapel.id) as jumlah_mapel'), DB::raw('count(distinct kelasmi.id) as jumlah_kelas'))
            ->groupBy('guru.id', 'guru.nama_guru', 'nama_kelas', 'mapel.mapel')
            ->orderby('mapel.mapel')
            ->orderby('nama_kelas')
            ->orderby('nama_guru')
            ->get();
        $Periode = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereNotNull('guru.nama_guru')
            ->select('periode.periode', 'semester.ket_semester')
            ->selectRaw('count(distinct mapel.id) as jumlah_mapel')
            ->selectRaw('count(distinct kelasmi.id) as jumlah_kelas')
            ->groupBy('periode.periode', 'semester.ket_semester')
            ->orderBy('periode.periode')
            ->orderBy('semester.ket_semester')
        ->first();
        return view(
            'jadwal.laporankelas',
            [
                'laporan' => $laporan,
                'Periode' => $Periode
            ]
        );
    }
    public function LaporanPlotingKelasPDF()
    {
        $laporan = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereNotNull('guru.nama_guru')
            ->select(
            'guru.nama_guru',
                'nama_kelas',
            'mapel.mapel'
            )
            ->selectRaw('count(distinct mapel.id) as jumlah_mapel')
            ->selectRaw('count(distinct kelasmi.id) as jumlah_kelas')
            ->groupBy(
                'guru.id',
                'guru.nama_guru',
            'nama_kelas',
            'mapel.mapel'
            )
            ->orderBy('mapel.mapel')
            // ->orderBy('nama_kelas')
            ->orderBy('nama_guru')
            ->get();

        $Periode = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->whereNotNull('guru.nama_guru')
            ->select(
                'periode.periode',
                'semester.ket_semester'
            )
            ->selectRaw('count(distinct mapel.id) as jumlah_mapel')
            ->selectRaw('count(distinct kelasmi.id) as jumlah_kelas')
            ->groupBy(
                'periode.periode',
                'semester.ket_semester'
            )
            ->first();

        $pdf = Pdf::loadView('jadwal.laporankelas-pdf', [
            'laporan' => $laporan,
            'Periode' => $Periode
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-ploting-kelas.pdf');
    }
    public function destroyGuru(Daftar_Jadwal $daftar_Jadwal)
    {
        Daftar_Jadwal::destroy('id', $daftar_Jadwal->id);
        return redirect()->back();
    }
    public function destroy(Jadwal $jadwal)
    {
        // hapus relasi daftar jadwal dulu
        Daftar_Jadwal::where('jadwal_id', $jadwal->id)->delete();

        // hapus jadwal
        $jadwal->delete();

        return redirect()->back()->with('delete', 'Jadwal berhasil dihapus.');
    }
}
