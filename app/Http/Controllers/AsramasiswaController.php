<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Models\Asramasiswa;
use App\Models\Nis;
use App\Models\Periode;
use App\Models\Pesertaasrama;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AsramasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJumlahPeserta = Asramasiswa::query()
            ->select(['asramasiswa.id', DB::raw('count(pesertaasrama.id) as jumlah_peserta_asrama')])
            ->join('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->groupBy('asramasiswa.id');
        $asrama = Asrama::all();
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->get();
        $dataasrama = Asramasiswa::query()
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('periode', 'periode.id', '=', 'asramasiswa.periode_id')
            ->leftjoin('semester', 'semester.id', '=', 'periode.semester_id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.asramasiswa_id', '=', 'asramasiswa.id')
            ->leftjoinSub(
                $dataJumlahPeserta,
                'datajumlahpeserta',
                function ($join) {
                    $join->on('asramasiswa.id', '=', 'datajumlahpeserta.id');
                }
            )
            ->selectRaw('asramasiswa.id,nama_asrama,ket_semester,periode,type_asrama,kuota,count(pesertaasrama.siswa_id) as jumlah_nilai_ujian, jumlah_peserta_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->groupBy(
                'asramasiswa.id',
                'periode',
                'ket_semester',
                'nama_asrama',
                'type_asrama',
                'kuota',
                'jumlah_peserta_asrama'
            )
            ->orderBy('type_asrama')
            ->orderBy('nama_asrama')
            ->get();
        // dd($data);
        return view(
            'asrama/asramasiswa',
            [
                'data' => $dataasrama,
                'datasrama' => $asrama,
                'periode' => $periode
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('periode.id', 'ket_semester', 'periode.periode')
            ->get();
        $dataasrama = Asrama::query()
            ->orderby('type_asrama')
            ->orderby('nama_asrama')
            ->get();
        return view(
            'asrama/addasramasiswa',
            [
                'datasrama' => $dataasrama,
                'periode' => $periode
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asramasiswa = new Asramasiswa();
        $asramasiswa->asrama_id = $request->asrama_id;
        $asramasiswa->kuota = $request->kuota;
        $asramasiswa->periode_id = session('periode_id');
        $asramasiswa->save();
        return redirect('asramasiswa')->with('update');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Asramasiswa $asramasiswa)
    {
        $tittle = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.kuota', 'asramasiswa.id')
            ->where('asramasiswa.id', $asramasiswa->id)
            ->first();

        $datapeserta = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id') // 🔥 INI PENTING
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->where('pesertaasrama.asramasiswa_id', $asramasiswa->id)
            ->select(
                'pesertaasrama.id',
                'siswa.nama_siswa',
                'nis.nis as nis', // 🔥 ambil dari tabel nis
                'siswa.kota_asal',
                'siswa.jenis_kelamin',
                'asrama.nama_asrama'
            )
            ->when(request('search'), function ($q) {
                $q->where(function ($q) {
                    $q->where('siswa.nama_siswa', 'like', '%' . request('search') . '%')
                        ->orWhere('nis.nis', 'like', '%' . request('search') . '%') // 🔥 fix search
                        ->orWhere('siswa.kota_asal', 'like', '%' . request('search') . '%');
                });
            })
            ->orderBy('siswa.nama_siswa')
            ->paginate(10);

        return view('asrama/pesertaasrama', [
            'asramasiswa' => $asramasiswa,
            'tittle' => $tittle,
            'datapeserta' => $datapeserta,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Asramasiswa $asramasiswa)
    {
        // ambil type asrama lama
        $typeAsrama = $asramasiswa->asrama->type_asrama;

        $dataasrama = Asrama::query()
            ->where('type_asrama', $typeAsrama)
            ->orderBy('nama_asrama')
            ->get();

        return view(
            'asrama/editasramasiswa',
            [
                'asramasiswa' => $asramasiswa,
                'dataasrama' => $dataasrama,
                'typeAsrama' => $typeAsrama
            ]
        );
    }
    public function editpeserta(Pesertaasrama $pesertaasrama, Asramasiswa $asramasiswa)
    {
        $anggota = Pesertaasrama::query()
            ->join('siswa', 'siswa.id', '=', 'pesertaasrama.siswa_id')
            ->where('pesertaasrama.id', $pesertaasrama->id)
            ->select('pesertaasrama.*', 'siswa.*') // penting!
            ->first();

        // tentukan tipe asrama
        $type = $anggota->jenis_kelamin == 'L' ? 'putra' : 'putri';

        $dataasrama = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->where('asrama.type_asrama', $type) // 🔥 filter utama
            ->orderBy('asrama.type_asrama')
            ->orderBy('asrama.nama_asrama')
            ->get();

        return view('asrama/editpeserta', [
            'anggota' => $anggota,
            'pesertaasrama' => $pesertaasrama,
            'asramasiswa' => $asramasiswa,
            'dataasrama' => $dataasrama,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asramasiswa $asramasiswa)
    {
        Asramasiswa::where('id', $asramasiswa->id)
            ->update([
                'asrama_id' => $request->asrama_id,
                'kuota' => $request->kuota,

            ]);
        return redirect('/asramasiswa')->with('update', 'pembaharuan data berhasil');
    }
    public function updatepeserta(Request $request, Pesertaasrama $pesertaasrama)
    {
        Pesertaasrama::where('id', $pesertaasrama->id)
            ->update([
                'siswa_id' => $request->siswa_id,
                'asramasiswa_id' => $request->asramasiswa_id,

            ]);
        if (auth()->user()->hasRole('super admin')) {
            return redirect('/pesertaasrama/' . $pesertaasrama->asramasiswa_id);
        } elseif (auth()->user()->hasRole('siswa')) {
            return redirect('/user');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asramasiswa  $asramasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asramasiswa $asramasiswa)
    {
        try {
            DB::transaction(function () use ($asramasiswa) {

                // hapus peserta dulu
                Pesertaasrama::where('asramasiswa_id', $asramasiswa->id)->delete();

                // hapus asrama siswa
                $asramasiswa->delete();
            });

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroyPesertaAsrama(Pesertaasrama $pesertaasrama)
    {
        try {
            $pesertaasrama->delete();

            return redirect()->back()->with('success', 'Data peserta asrama berhasil dihapus.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal menghapus data peserta.');
        }
    }
    public function bulkDelete(Request $request)
    {
        try {

            $ids = $request->input('ids', []);

            // validasi data kosong
            if (!is_array($ids) || count($ids) === 0) {
                return redirect()->back()->with(
                    'error',
                    'Tidak ada peserta asrama yang dipilih.'
                );
            }

            DB::transaction(function () use ($ids) {

                // hapus peserta asrama
                Pesertaasrama::whereIn('id', $ids)->delete();
            });

            return redirect()->back()->with(
                'success',
                count($ids) . ' data peserta asrama berhasil dihapus.'
            );
        } catch (\Throwable $e) {

            return redirect()->back()->with(
                'error',
                'Terjadi kesalahan saat menghapus peserta asrama. ' . $e->getMessage()
            );
        }
    }

    public function bulkDeleteasrama(Request $request)
    {
        try {

            $ids = $request->ids ?? [];

            if (count($ids) === 0) {

                return back()->with(
                    'error',
                    'Tidak ada data yang dipilih.'
                );
            }

            DB::transaction(function () use ($ids) {

                AsramaSiswa::whereIn('id', $ids)->delete();
            });

            return back()->with(
                'success',
                count($ids) . ' data berhasil dihapus.'
            );
        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
    public function kolelktifasrama(Asramasiswa $asramasiswa)
    {
        $kelas = Asramasiswa::query()
            ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->select('asrama.nama_asrama', 'asramasiswa.id', 'type_asrama')
            ->where('asramasiswa.periode_id', session('periode_id'))
            ->orderby('type_asrama')
            ->get();

        $pesertaAsramaPeriodeTerpilih = Pesertaasrama::query()
            ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->where('asramasiswa.periode_id', $asramasiswa->periode_id)
            ->select('pesertaasrama.siswa_id');
        $Datasiswa = Siswa::query()
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoinSub($pesertaAsramaPeriodeTerpilih, 'peserta_asrama_periode_terpilih', function ($join) {
                $join->on('peserta_asrama_periode_terpilih.siswa_id', '=', 'siswa.id');
            })
            ->where('peserta_asrama_periode_terpilih.siswa_id', null)
            // ->whereNot('madrasah_diniyah', 'ula')
            ->select(
                [
                'nis.madrasah_diniyah',
                'siswa.jenis_kelamin',
                'siswa.nama_siswa',
                'siswa.id',
                'nis.nis',
                    'nis.tanggal_masuk'
                ]
        )
            ->orderBy('nis.madrasah_diniyah')
            ->orderBy('nis.nis')
            ->orderBy('siswa.jenis_kelamin')
        ->orderBy('siswa.nama_siswa');
        if (request('cari')) {
            $Datasiswa->where(function ($query) {
                $query->where('nis', 'like', '%' . request('cari') . '%')
                    ->orWhere('nama_siswa', 'like', '%' . request('cari') . '%');
            });
            // ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            // ->orWhere('nis', 'like', '%' . request('cari') . '%')
            // ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')
        }
        $a = $Datasiswa->count();

        // dd($Datasiswa->toSql());
        return view(
            'asrama/kolektifasrama',
            [
                'Datasiswa' => $Datasiswa->get(),
                'kelas' => $kelas,
                'a' => $a,
                'asramasiswa' => $asramasiswa
            ]
        );
    }
    public function StoreKolektifasrama(Request $request)
    {
        foreach ($request->siswa as $siswa) {
            $peserta = new Pesertaasrama();
            $peserta->siswa_id = $siswa;
            $peserta->asramasiswa_id = $request->asramasiswa_id;
            $peserta->save();
        }
        return redirect()->back();
    }

    public function pindahPeriode(Request $request)
    {
        DB::beginTransaction();

        try {

            // periode sekarang
            $periodeSekarang = session('periode_id');

            // periode tujuan
            $periodeTujuan = $request->periode_tujuan;

            // ambil semua asrama siswa periode sekarang
            $dataAsrama = Asramasiswa::query()
                ->where('periode_id', $periodeSekarang)
                ->get();

            foreach ($dataAsrama as $asramaLama) {

                /*
            |--------------------------------------------------------------------------
            | Cek apakah asrama di periode tujuan sudah ada
            |--------------------------------------------------------------------------
            */
                $asramaBaru = Asramasiswa::query()
                    ->where('periode_id', $periodeTujuan)
                    ->where('asrama_id', $asramaLama->asrama_id)
                    ->first();

                /*
            |--------------------------------------------------------------------------
            | Jika belum ada -> buat baru
            |--------------------------------------------------------------------------
            */
                if (!$asramaBaru) {

                    $asramaBaru = new Asramasiswa();
                    $asramaBaru->asrama_id = $asramaLama->asrama_id;
                    $asramaBaru->kuota = $asramaLama->kuota;
                    $asramaBaru->periode_id = $periodeTujuan;
                    $asramaBaru->save();
                }

                /*
            |--------------------------------------------------------------------------
            | Ambil peserta asrama lama
            |--------------------------------------------------------------------------
            */
                $pesertaLama = Pesertaasrama::query()
                    ->where('asramasiswa_id', $asramaLama->id)
                    ->get();

                foreach ($pesertaLama as $peserta) {

                    // cek apakah siswa sudah ada di periode tujuan
                    $cekSudahAda = Pesertaasrama::query()
                        ->join(
                            'asramasiswa',
                            'asramasiswa.id',
                            '=',
                            'pesertaasrama.asramasiswa_id'
                        )
                        ->where('pesertaasrama.siswa_id', $peserta->siswa_id)
                        ->where('asramasiswa.periode_id', $periodeTujuan)
                        ->exists();

                    // jika belum ada -> insert
                    if (!$cekSudahAda) {

                        $insert = new Pesertaasrama();
                        $insert->siswa_id = $peserta->siswa_id;
                        $insert->asramasiswa_id = $asramaBaru->id;
                        $insert->save();
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with(
                'success',
                'Data peserta asrama berhasil dipindahkan!'
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
    public function generatePeriodeBerikutnya(Request $request)
    {
        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Periode aktif
        |--------------------------------------------------------------------------
        */
            $periodeAktif = Periode::query()
                ->where('is_active', 1)
                ->first();

            if (!$periodeAktif) {
                return redirect()->back()->with(
                    'error',
                    'Periode aktif tidak ditemukan!'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | MODE GENERATE
        |--------------------------------------------------------------------------
        */
            $mode = $request->mode ?? 'auto';
            $periodeTujuan = null;

            /*
        |--------------------------------------------------------------------------
        | MODE CUSTOM
        |--------------------------------------------------------------------------
        */
            if ($mode == 'custom') {

                $periodeTujuan = Periode::query()
                    ->find($request->periode_tujuan);

                if (!$periodeTujuan) {
                    return redirect()->back()->with(
                        'error',
                        'Periode tujuan tidak ditemukan!'
                    );
                }
            }

            /*
        |--------------------------------------------------------------------------
        | MODE AUTO
        |--------------------------------------------------------------------------
        */ else {

                if ($periodeAktif->semester_id == 1) {

                    $periodeTujuan = Periode::query()
                        ->where('periode', $periodeAktif->periode)
                        ->where('semester_id', 2)
                        ->first();
                } elseif ($periodeAktif->semester_id == 2) {

                    [$tahunAwal, $tahunAkhir] = explode('/', $periodeAktif->periode);

                    $periodeBaru = ((int)$tahunAwal + 1) . '/' . ((int)$tahunAkhir + 1);

                    $periodeTujuan = Periode::query()
                        ->where('periode', $periodeBaru)
                        ->where('semester_id', 1)
                        ->first();
                }
            }

            /*
        |--------------------------------------------------------------------------
        | Validasi periode tujuan
        |--------------------------------------------------------------------------
        */
            if (!$periodeTujuan) {
                return redirect()->back()->with(
                    'error',
                    'Periode tujuan belum tersedia!'
                );
            }

            if ($periodeAktif->id == $periodeTujuan->id) {
                return redirect()->back()->with(
                    'error',
                    'Periode tujuan tidak boleh sama dengan periode aktif!'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Cek data sudah ada
        |--------------------------------------------------------------------------
        */
            $cekData = Asramasiswa::query()
                ->where('periode_id', $periodeTujuan->id)
                ->exists();

            if ($cekData) {
                return redirect()->back()->with(
                    'info',
                    'Data asrama periode ' . $periodeTujuan->periode . ' sudah tersedia.'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Ambil data asrama periode aktif
        |--------------------------------------------------------------------------
        */
            $dataAsrama = Asramasiswa::query()
                ->where('periode_id', $periodeAktif->id)
                ->get();

            if ($dataAsrama->isEmpty()) {
                return redirect()->back()->with(
                    'error',
                    'Data asrama periode aktif kosong!'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | GENERATE
        |--------------------------------------------------------------------------
        */
            foreach ($dataAsrama as $item) {

                $pesertaLama = Pesertaasrama::query()
                    ->where('asramasiswa_id', $item->id)
                    ->get();

                $asramaBaru = Asramasiswa::create([
                    'asrama_id'   => $item->asrama_id,
                    'periode_id'  => $periodeTujuan->id,
                    'kuota'       => 0, // sementara, akan di-update
                ]);

                $jumlahMasuk = 0;

                foreach ($pesertaLama as $peserta) {

                    $cekSiswa = Pesertaasrama::query()
                        ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
                        ->where('pesertaasrama.siswa_id', $peserta->siswa_id)
                        ->where('asramasiswa.periode_id', $periodeTujuan->id)
                        ->exists();

                    if (!$cekSiswa) {

                        Pesertaasrama::create([
                            'siswa_id' => $peserta->siswa_id,
                            'asramasiswa_id' => $asramaBaru->id,
                        ]);

                        $jumlahMasuk++;
                    }
                }

                /*
            |--------------------------------------------------------------------------
            | update kuota sesuai jumlah peserta yang benar-benar masuk
            |--------------------------------------------------------------------------
            */
                $asramaBaru->update([
                    'kuota' => $jumlahMasuk
                ]);
            }

            DB::commit();

            return redirect()->back()->with(
                'success',
                'Data asrama & peserta berhasil digenerate dari periode '
                    . $periodeAktif->periode .
                    ' ke periode '
                    . $periodeTujuan->periode
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
    public function transferAsrama()
    {
        DB::beginTransaction();

        try {

            $periodeAktif = Periode::where('is_active', 1)->first();

            if (!$periodeAktif) {
                return back()->with('error', 'Periode aktif tidak ditemukan');
            }

            $periodeLama = Periode::where('id', '<', $periodeAktif->id)
                ->orderByDesc('id')
                ->first();

            if (!$periodeLama) {
                return back()->with('error', 'Periode sebelumnya tidak ditemukan');
            }

            $dataAsramaLama = Asramasiswa::where(
                'periode_id',
                $periodeLama->id
            )->get();

            $jumlahAsrama = 0;
            $jumlahSiswa = 0;

            foreach ($dataAsramaLama as $asramaLama) {

                /*
            |--------------------------------------------------------------------------
            | Buat / Ambil Asrama Periode Baru
            |--------------------------------------------------------------------------
            */
                $asramaBaru = Asramasiswa::firstOrCreate(
                    [
                        'periode_id' => $periodeAktif->id,
                        'asrama_id'  => $asramaLama->asrama_id,
                    ],
                    [
                        'kuota' => $asramaLama->kuota,
                    ]
                );

                $jumlahAsrama++;

                /*
            |--------------------------------------------------------------------------
            | Ambil Seluruh Peserta Asrama Lama
            |--------------------------------------------------------------------------
            */
                $pesertaLama = Pesertaasrama::where(
                    'asramasiswa_id',
                    $asramaLama->id
                )->get();

                foreach ($pesertaLama as $peserta) {

                    $bolehTransfer = true;

                    /*
                |--------------------------------------------------------------------------
                | GENAP -> GANJIL (TAHUN AJARAN BARU)
                |--------------------------------------------------------------------------
                */
                    if (
                        $periodeLama->semester_id == 2 &&
                        $periodeAktif->semester_id == 1
                    ) {

                        $nis = Nis::where('siswa_id', $peserta->siswa_id)
                            ->latest('id')
                            ->first();

                        if (!$nis) {

                            $bolehTransfer = false;
                        } else {

                            $tahunMasuk = (int) substr($nis->nis, 0, 4);

                            [$tahunAwalAktif] = explode(
                                '/',
                                $periodeAktif->periode
                            );

                            $tahunAwalAktif = (int) $tahunAwalAktif;

                            $masaBelajar = $tahunAwalAktif - $tahunMasuk;

                            /*
                        |--------------------------------------------------------------------------
                        | ULA = 6 TAHUN
                        |--------------------------------------------------------------------------
                        */
                            if (
                                $nis->madrasah_diniyah == 'Ula' &&
                                $masaBelajar >= 6
                            ) {
                                $bolehTransfer = false;
                            }

                            /*
                        |--------------------------------------------------------------------------
                        | WUSTHO = 3 TAHUN
                        |--------------------------------------------------------------------------
                        */
                            if (
                                $nis->madrasah_diniyah == 'Wustho' &&
                                $masaBelajar >= 3
                            ) {
                                $bolehTransfer = false;
                            }

                            /*
                        |--------------------------------------------------------------------------
                        | ULYA = 3 TAHUN
                        |--------------------------------------------------------------------------
                        */
                            if (
                                $nis->madrasah_diniyah == 'Ulya' &&
                                $masaBelajar >= 3
                            ) {
                                $bolehTransfer = false;
                            }
                        }
                    }

                    if (!$bolehTransfer) {
                        continue;
                    }

                    /*
                |--------------------------------------------------------------------------
                | Cek apakah siswa sudah ada di periode baru
                |--------------------------------------------------------------------------
                */
                    $exists = Pesertaasrama::query()
                        ->join(
                            'asramasiswa',
                            'asramasiswa.id',
                            '=',
                            'pesertaasrama.asramasiswa_id'
                        )
                        ->where(
                            'pesertaasrama.siswa_id',
                            $peserta->siswa_id
                        )
                        ->where(
                            'asramasiswa.periode_id',
                            $periodeAktif->id
                        )
                        ->exists();

                    if (!$exists) {

                        Pesertaasrama::create([
                            'siswa_id'       => $peserta->siswa_id,
                            'asramasiswa_id' => $asramaBaru->id,
                        ]);

                        $jumlahSiswa++;
                    }
                }

                /*
            |--------------------------------------------------------------------------
            | Update Kuota Sesuai Jumlah Penghuni
            |--------------------------------------------------------------------------
            */
                $asramaBaru->update([
                    'kuota' => Pesertaasrama::where(
                        'asramasiswa_id',
                        $asramaBaru->id
                    )->count()
                ]);
            }

            DB::commit();

            return back()->with(
                'success',
                "{$jumlahAsrama} asrama dan {$jumlahSiswa} peserta berhasil ditransfer dari {$periodeLama->periode} ke {$periodeAktif->periode}"
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
