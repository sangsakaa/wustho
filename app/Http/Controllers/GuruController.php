<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Nig;
use App\Models\Nilaimapel;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class GuruController extends Controller
{
    /**
     * Daftar guru
     */
    public function index()
    {
        $tab = request('tab', 'aktif');
        $cari = request('cari');

        $query = Guru::with('NigTerakhir')
            ->orderBy('nama_guru');

        // Filter status
        match ($tab) {
            'aktif' => $query->where('status', 'Aktif'),
            'nonaktif' => $query->where('status', 'Non Aktif'),
            'cuti' => $query->where('status', 'Cuti'),
            default => null,
        };

        // Pencarian
        if ($cari) {
            $query->where('nama_guru', 'like', '%' . $cari . '%');
        }

        $dataGuru = $query
            ->paginate(10)
            ->withQueryString();

        return view('guru.guru', [
            'dataGuru' => $dataGuru,
            'totalGuru' => Guru::count(),
            'aktif' => Guru::where('status', 'Aktif')->count(),
            'nonaktif' => Guru::where('status', 'Non Aktif')->count(),
            'cuti' => Guru::where('status', 'Cuti')->count(),
            'tab' => $tab,
        ]);
    }


    /**
     * Form tambah guru
     */
    public function create()
    {
        return view('guru.addGuru');
    }


    /**
     * Simpan guru baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:Aktif,Non Aktif,Cuti',
            'jenjang' => 'required|in:Ula,Wustho,Ulya',
        ]);

        Guru::create($validated);

        return redirect('/guru')
            ->with('success', 'Data guru berhasil ditambahkan');
    }


    /**
     * Detail guru
     */
    public function show(Request $request, Guru $guru)
    {
        $periodeId = $request->periode_id ?? session('periode_id');

        // Jika session menyimpan model Periode
        if (is_object($periodeId)) {
            $periodeId = $periodeId->id ?? null;
        }

        $daftarPeriode = Periode::orderBy('periode', 'desc')->get();

        $riwayatMengajar = Nilaimapel::query()
            ->leftJoin(
                'kelasmi',
                'kelasmi.id',
                '=',
                'nilaimapel.kelasmi_id'
            )
            ->leftJoin(
                'periode',
                'periode.id',
                '=',
                'kelasmi.periode_id'
            )
            ->leftJoin(
                'semester',
                'semester.id',
                '=',
                'periode.semester_id'
            )
            ->leftJoin(
                'kelas',
                'kelas.id',
                '=',
                'kelasmi.kelas_id'
            )
            ->leftJoin(
                'mapel',
                'mapel.id',
                '=',
                'nilaimapel.mapel_id'
            )
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
            'periodeAktif' => $periodeId,
        ]);
    }


    /**
     * Form edit guru
     */
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }


    /**
     * Update guru
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:Aktif,Non Aktif,Cuti',
            'jenjang' => 'required|in:Ula,Wustho,Ulya',
        ]);

        $guru->update($validated);

        return redirect('/guru')
            ->with('update', 'Data guru berhasil diperbarui');
    }


    /**
     * Hapus guru
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()
            ->back()
            ->with('delete', 'Data guru berhasil dihapus');
    }


    /**
     * Daftar NIG guru
     */
    public function NIS(Guru $guru)
    {
        $dataNIG = Nig::where('guru_id', $guru->id)
            ->latest()
            ->get();

        return view('guru.nig.index', [
            'guru' => $guru,
            'dataGuru' => $guru,
            'dataNIG' => $dataNIG,
        ]);
    }


    /**
     * Simpan NIG
     */
    public function storeNig(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'jenjang_id' => 'required',
        ]);

        $guru = Guru::findOrFail($validated['guru_id']);

        $nig = Nig::create([
            'nig' => $this->generateNig($validated['jenjang_id']),
            'guru_id' => $guru->id,
            'jenjang_id' => $validated['jenjang_id'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'NIG ' . $nig->nig . ' berhasil dibuat');
    }


    /**
     * Hapus NIG
     */
    public function destroyNig(Nig $nig)
    {
        $nig->delete();

        return redirect()
            ->back()
            ->with('delete', 'NIG berhasil dihapus');
    }


    /**
     * Generate NIG berdasarkan ID jenjang
     *
     * Format:
     * YYYYMM + KODE JENJANG + NOMOR URUT
     *
     * Contoh:
     * 2026092001
     */
    private function generateNig($jenjangId)
    {
        $tahun = date('Y');
        $bulan = date('m');

        $kodeJenjang = match ((int) $jenjangId) {
            1 => '10', // Ula
            2 => '20', // Wustho
            3 => '30', // Ulya
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

        return $prefix . str_pad(
            $newNumber,
            2,
            '0',
            STR_PAD_LEFT
        );
    }


    /**
     * Generate NIG untuk semua guru
     * yang belum memiliki NIG.
     */
    public function generateKolektifNig()
    {
        $gurus = Guru::whereDoesntHave('nig')
            ->whereNotNull('jenjang')
            ->whereIn('jenjang', [
                'Ula',
                'Wustho',
                'Ulya',
            ])
            ->get();

        $jumlah = 0;

        DB::transaction(function () use ($gurus, &$jumlah) {

            foreach ($gurus as $guru) {

                // Konversi jenjang guru menjadi ID jenjang
                $jenjangId = match ($guru->jenjang) {
                    'Ula' => 1,
                    'Wustho' => 2,
                    'Ulya' => 3,
                    default => null,
                };

                if (!$jenjangId) {
                    continue;
                }

                Nig::create([
                    'nig' => $this->generateNig($jenjangId),
                    'guru_id' => $guru->id,
                    'jenjang_id' => $jenjangId,
                ]);

                $jumlah++;
            }
        });

        return redirect()
            ->back()
            ->with(
                'success',
                $jumlah . ' NIG berhasil digenerate'
            );
    }
}
