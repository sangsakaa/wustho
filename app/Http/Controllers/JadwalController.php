<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Kelasmi;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\Daftar_Jadwal;
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
            return redirect()->back()->with('error', 'Jadwal untuk kelas dan hari ini sudah ada!');
        }

        $jadwal->save();
        return redirect()->back();
    }
    // Daftar_jadwal
    public function DaftarJadwal(Jadwal $jadwal)
    {
        // dd($jadwal);
        $jadwal = Jadwal::find($jadwal->id);
        $daftarGuru = Guru::orderby('nama_guru')->get();
        $daftarMapel = Mapel::query()
            ->join('kelas', 'kelas.id', '=', 'mapel.kelas_id')
            ->join('kelasmi', 'kelasmi.kelas_id', '=', 'kelas.id')
            ->join('periode', 'periode.id', '=', 'mapel.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('mapel.id', 'kelas.kelas', 'mapel', 'nama_kitab', 'periode', 'ket_semester', 'kelasmi.periode_id')
            ->where('kelasmi.id', $jadwal->kelasmi_id)
            ->whereNotExists(function ($query) use ($jadwal) {
                $query->select(DB::raw(1))
                    ->from('daftar_jadwal')
                    ->join('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
                    ->whereColumn('daftar_jadwal.mapel_id', '=', 'mapel.id')
            ->where('mapel.periode_id', session('periode_id'))
            ->where('jadwal.kelasmi_id', $jadwal->kelasmi_id);
            })
            ->where('mapel.periode_id', session('periode_id'))
            ->orderBy('kelas.kelas')
            ->orderBy('mapel')
            ->get();
        // dd($daftarMapel);
        $daftarJadwal = Daftar_Jadwal::query()
            ->join('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->join('guru', 'guru.id', '=', 'daftar_jadwal.guru_id')
            ->join('jadwal', 'jadwal.id', '=', 'daftar_jadwal.jadwal_id')
            ->select('daftar_jadwal.id', 'nama_guru', 'mapel', 'nama_kitab', 'jadwal.periode_id')
            ->where('daftar_jadwal.jadwal_id', $jadwal->id)
            
            ->get();
        // dd($daftarJadwal);
        return view('jadwal.jadwal_guru', compact(
            [
                'daftarGuru',
                'daftarMapel',
                'jadwal',
                'daftarJadwal'
            ]
        ));
    }
    public function CetakJadwal1(Request $request)
    {

        $kelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('kelas', 'kelas.id', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'kelas.kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->where('kelasmi.id', $request->kelasmi_id)
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
            ->where('kelas.kelas', 1)
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
    public function CetakJadwal2(Request $request)
    {
        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->join('kelas', 'kelas.id', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'kelas.kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();
        $jadwalByDay2 = Jadwal::query()
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
                    'jadwal.periode_id'
                ]
            )
            ->where('kelas.kelas', 2)
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('jadwal.id')
        ->groupBy('hari', 'jadwal.id', 'kelasmi.nama_kelas', 'jadwal.periode_id', 'kelas.kelas', 'mapel.mapel', 'guru.nama_guru', 'guru.jenis_kelamin');

        $jadwalByDayMap2 = [];

        // Loop untuk mapping jadwal bedasarkan hari
        foreach ($jadwalByDay2->get() as $jadwal) {
            $jadwalByDayMap2[$jadwal->hari][] = $jadwal;
        }

        if (request('kelasmi_id')) {
            $jadwalByDay2->where('kelas', 'like', '%' . request('kelasmi_id') . '%')->get();
        }
        return view(
            'jadwal.jadwal2',
            [
                'jadwalByDayMap2' => $jadwalByDayMap2,
                'datakelasmi' => $datakelasmi,
            ]
        );
    }
    public function CetakJadwal3(Request $request)
    {

        $datakelasmi = Kelasmi::query()
            ->join('periode', 'periode.id', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', 'periode.semester_id')
            ->join('kelas', 'kelas.id', 'kelasmi.kelas_id')
            ->select('kelasmi.id', 'kelasmi.nama_kelas', 'periode.periode', 'semester.ket_semester', 'kelas.kelas')
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->first();
        $jadwalByDay3 = Jadwal::query()
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
                    'jadwal.periode_id'
                ]
            )
            ->where('kelas.kelas', 3)
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->orderBy('jadwal.id')
        ->groupBy('hari', 'jadwal.id', 'kelasmi.nama_kelas', 'jadwal.periode_id', 'kelas.kelas', 'mapel.mapel', 'guru.nama_guru', 'guru.jenis_kelamin');

        $jadwalByDayMap3 = [];

        // Loop untuk mapping jadwal bedasarkan hari
        foreach ($jadwalByDay3->get() as $jadwal) {
            $jadwalByDayMap3[$jadwal->hari][] = $jadwal;
        }
        return view(
            'jadwal.jadwal3',
            [
                'jadwalByDayMap3' => $jadwalByDayMap3,
                'datakelasmi' => $datakelasmi,
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
            return redirect()->back()->with('error', 'Jadwal untuk kelas dan hari ini sudah ada!');
        }
        $daftarJadwal->save();
        return redirect()->back();
    }
    public function JadwalKolektif()
    {

        $daftarPeriode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'periode.periode', 'semester.semester', 'semester.ket_semester')
            ->select('periode.id')
            ->where('periode.id', session('periode_id'))
            ->first();
        // dd($daftarPeriode);

        $jadwal = Jadwal::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'jadwal.kelasmi_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->join('periode', 'periode.id', '=', 'jadwal.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('daftar_jadwal', 'daftar_jadwal.jadwal_id', '=', 'jadwal.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'daftar_jadwal.mapel_id')
            ->select('jadwal.*', 'kelasmi.nama_kelas')
            ->get();

        $dataKelasMi = Kelasmi::query()
            ->where('kelasmi.periode_id', session('periode_id'))
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        foreach ($dataKelasMi as $kelasmi) {
            $nama_kelas = $kelasmi->nama_kelas;
            $hari_array = ['jumat', 'sabtu', 'minggu', 'senin', 'selasa', 'rabu',];
            foreach ($hari_array as $hari) {
                if (!$jadwal->contains(function ($jadwal) use ($nama_kelas, $hari, $daftarPeriode) {
                    return $jadwal->nama_kelas == $nama_kelas && $jadwal->hari == $hari && $jadwal->periode_id == $daftarPeriode->id;
                })) {
                    $sesi = new Jadwal();
                    $sesi->periode_id = $daftarPeriode->id;
                    $sesi->kelasmi_id = $kelasmi->id;
                    $sesi->hari = $hari;
                    $sesi->save();
                }
            }
        }

        return redirect()->back();
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
            ->select('guru.nama_guru', 'nama_kelas', DB::raw('count(distinct mapel.id) as jumlah_mapel'), DB::raw('count(distinct kelasmi.id) as jumlah_kelas'))
            ->groupBy('guru.id', 'guru.nama_guru', 'nama_kelas')
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
    public function destroyGuru(Daftar_Jadwal $daftar_Jadwal)
    {
        Daftar_Jadwal::destroy('id', $daftar_Jadwal->id);
        return redirect()->back();
    }
    public function destroy(Jadwal $jadwal)
    {
        Jadwal::destroy('id', $jadwal->id);
        Daftar_Jadwal::where('jadwal_id', $jadwal->id);
        return redirect()->back();
    }
}
