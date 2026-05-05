<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Nig;
use App\Models\Nilaimapel;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GuruController extends Controller
{
    public function index()
    {
        $tab = request('tab', 'aktif');

        $query = Guru::with(['NigTerakhir'])
            ->orderBy('nama_guru');

        // filter status
        match ($tab) {
            'aktif' => $query->where('status', 'Aktif'),
            'nonaktif' => $query->where('status', 'Non Aktif'),
            'cuti' => $query->where('status', 'Cuti'),
            default => null
        };

        // search
        if (request('cari')) {
            $query->where('nama_guru', 'like', '%' . request('cari') . '%');
        }

        $dataGuru = $query->paginate(10)->withQueryString();

        return view('guru.guru', [
            'dataGuru' => $dataGuru,
            'totalGuru' => Guru::count(),
            'aktif' => Guru::where('status', 'Aktif')->count(),
            'nonaktif' => Guru::where('status', 'Non Aktif')->count(),
            'cuti' => Guru::where('status', 'Cuti')->count(),
            'tab' => $tab,
        ]);
    }

    public function create()
    {
        return view('guru.addGuru');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'tanggal_masuk' => 'required',
            'status' => 'required',
        ]);

        Guru::create([
            'nama_guru' => $request->nama_guru,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => $request->status,
        ]);

        return redirect('/guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function show(Request $request, Guru $guru)
    {
        $periodeId = $request->get('periode_id') ?? session('periode_id');

        $daftarPeriode = Periode::orderBy('periode', 'desc')->get();

        $riwayatMengajar = Nilaimapel::query()
            ->leftJoin('kelasmi', 'kelasmi.id', '=', 'nilaimapel.kelasmi_id')
            ->leftJoin('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->leftJoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
            ->leftJoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->select([
                'nilaimapel.id',
                'kelasmi.nama_kelas',
                'periode.periode',
            'semester.ket_semester',
                'mapel.mapel',
                'mapel.nama_kitab',
            ])
            ->where('nilaimapel.guru_id', $guru->id)
            ->when($periodeId, function ($q) use ($periodeId) {
                $q->where('kelasmi.periode_id', $periodeId);
            })
            ->orderBy('periode.periode', 'desc')
            ->orderBy('kelasmi.nama_kelas')
            ->get();

        return view('guru.detail', [
            'guru' => $guru,
            'riwayatMengajar' => $riwayatMengajar,
            'daftarPeriode' => $daftarPeriode,
            'periodeAktif' => $periodeId
        ]);
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $guru->update([
            'nama_guru' => $request->nama_guru,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => $request->status,
        ]);

        return redirect('/guru')->with('update', 'Data berhasil diperbarui');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->back()->with('delete', 'Data guru berhasil dihapus');
    }

    /**
     * halaman daftar NIG guru
     */
    public function NIS(Guru $guru)
    {
        $dataNIG = Nig::where('guru_id', $guru->id)->latest()->get();

        return view('guru.nig.index', [
            'guru' => $guru,
            'dataGuru' => $guru,
            'dataNIG' => $dataNIG,
        ]);
    }

    /**
     * simpan NIG otomatis
     */
    public function storeNig(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'jenjang_id' => 'required',
        ]);

        Nig::create([
            'nig' => $this->generateNig($request->jenjang_id),
            'guru_id' => $request->guru_id,
            'jenjang_id' => $request->jenjang_id,
        ]);

        return redirect()->back()->with('success', 'NIG berhasil dibuat');
    }

    public function destroyNig(Nig $nig)
    {
        $nig->delete();

        return redirect()->back()->with('delete', 'NIG berhasil dihapus');
    }

    /**
     * generate otomatis NIG
     * format: YYYYMM + kodeJenjang + urut
     * contoh: 2026052001
     */
    private function generateNig($jenjangId)
    {
        $tahun = date('Y');
        $bulan = date('m');

        $kodeJenjang = match ((int) $jenjangId) {
            1 => '10',
            2 => '20',
            3 => '30',
            default => '00',
        };

        $prefix = $tahun . $bulan . $kodeJenjang;

        $lastNig = Nig::where('nig', 'like', $prefix . '%')
            ->orderBy('nig', 'desc')
            ->first();

        if ($lastNig) {
            $lastNumber = (int) substr($lastNig->nig, -2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }
    public function generateKolektifNig()
    {
        // ambil semua guru yang belum punya NIG
        $gurus = Guru::doesntHave('nig')
            ->whereNotNull('jenjang')
            ->get();

        foreach ($gurus as $guru) {
            Nig::create([
                'nig' => $this->generateNig($guru->jenjang_id),
                'guru_id' => $guru->id,
                'jenjang_id' => $guru->jenjang_id,
            ]);
        }

        return redirect()->back()->with(
            'success',
            $gurus->count() . ' NIG berhasil digenerate'
        );
    }
}
