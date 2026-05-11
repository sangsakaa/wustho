<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nis;
use App\Models\Perangkat;
use App\Models\Siswa;
use App\Models\Statusanak;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Pesertaasrama;
use App\Models\Statuspengamal;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.siswa');
    }

    public function create()
    {
        return view('siswa/addsiswa');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|min:3|max:100',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        Siswa::create($request->only([
            'nama_siswa',
            'jenis_kelamin',
            'agama',
            'tempat_lahir',
            'tanggal_lahir',
            'kota_asal',
        ]));

        return redirect('siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }
    public function storeNis(Request $request)
    { 
        $nis = new nis();
        $nis->siswa_id = $request->siswa_id;
        $nis->nis = $request->nis;
        $nis->nama_lembaga = $request->nama_lembaga;
        $nis->madrasah_diniyah = $request->madrasah_diniyah;
        $nis->tanggal_masuk = $request->tanggal_masuk;
        $nis->save();
        return redirect()->back();
    }
    public function storeSP(Request $request)
    {
        $status_pengamal = new Statuspengamal();
        $status_pengamal->siswa_id = $request->siswa_id;
        $status_pengamal->status_pengamal = $request->status_pengamal;
        $status_pengamal->save();
        return redirect()->back();
    }
    public function storeSA(Request $request)
    {
        $statusanak = new Statusanak();
        $statusanak->siswa_id = $request->siswa_id;
        $statusanak->status_anak = $request->status_anak;
        $statusanak->anak_ke = $request->anak_ke;
        $statusanak->jumlah_saudara = $request->jumlah_saudara;
        $statusanak->nama_ayah = $request->nama_ayah;
        $statusanak->nama_ibu = $request->nama_ibu;
        $statusanak->pekerjaan_ayah = $request->pekerjaan_ayah;
        $statusanak->pekerjaan_ibu = $request->pekerjaan_ibu;
        $statusanak->nomor_hp_ayah = $request->nomor_hp_ayah;
        $statusanak->nomor_hp_ibu = $request->nomor_hp_ibu;
        $statusanak->save();
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa, Request $request)
    {
        $pesertakelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('pesertakelas.siswa_id', $siswa->id)
            ->orderby('periode')
            ->orderby('semester')
            ->get();
        $historiAsrama = Pesertaasrama::query()
        ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
        ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
        ->join('periode', 'periode.id', '=', 'asramasiswa.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('siswa_id', $siswa->id)->get();

        $PresensiKelas = Pesertakelas::query()
        ->join('absensikelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
        ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->select(
            'periode.periode',
            'semester.ket_semester',
            DB::raw('count(case when keterangan = "alfa" then 1 else null end) as alfa'),
            DB::raw('count(case when keterangan = "hadir" then 1 else null end) as hadir'),
            DB::raw('count(case when keterangan = "izin" then 1 else null end) as izin'),
            DB::raw('count(case when keterangan = "sakit" then 1 else null end) as sakit'),
            DB::raw('count(distinct sesikelas.id) as count_sesikelas_id'),
            DB::raw('COUNT(CASE WHEN keterangan = "hadir" THEN 1 END)/(COUNT(DISTINCT sesikelas.id)) * 100 as presentase_kehadiran')
        )
            ->where('siswa_id', $siswa->id);

        if ($request->filled('filter_periode')) {
            $PresensiKelas->where('periode.periode', $request->filter_periode);
        }

        $PresensiKelas = $PresensiKelas->groupBy('periode.periode', 'semester.ket_semester')->get();

        $daftarPeriode = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->where('pesertakelas.siswa_id', $siswa->id)
            ->distinct()
            ->pluck('periode.periode');

        return view(
            'siswa/detailSiswa',
            [
                'siswa' => $siswa,
                'pesertakelas' => $pesertakelas,
                'historiAsrama' => $historiAsrama,
                'PresensiKelas' => $PresensiKelas,
                'daftarPeriode' => $daftarPeriode,
            ]
        );
    }
    public function biodata(Siswa $siswa)
    {
        // $perangkat = Perangkat::with('jabatanPerangkat.jabatan')
        //     ->where('status', 'Aktif')
        //     ->whereHas('jabatanPerangkat.jabatan', function ($q) {
        //         $q->where('nama_jabatan', 'Kepala Sekolah');
        //     })
        //     ->get();

        $biodata = Siswa::query()
            ->leftJoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoin('statusanak', 'statusanak.siswa_id', '=', 'siswa.id')
            ->leftJoin('statuspengamal', 'statuspengamal.siswa_id', '=', 'siswa.id')
            ->where('siswa.id', $siswa->id)
            ->select(
                'siswa.*',
                'nis.nis',
                'nis.madrasah_diniyah',
                'nis.tanggal_masuk',
                'statusanak.status_anak',
                'statusanak.anak_ke',
                'statusanak.jumlah_saudara',
                'statusanak.nama_ayah',
                'statusanak.nama_ibu',
                'statusanak.pekerjaan_ayah',
                'statusanak.pekerjaan_ibu',
                'statusanak.nomor_hp_ayah',
                'statusanak.nomor_hp_ibu',
                'statuspengamal.status_pengamal'
            )
            ->first();

        return view('siswa/biodata', [
            'siswa' => $siswa,
            'biodata' => $biodata,

        ]);
    }
    public function nis(Siswa $siswa)
    {
        $nisSiswa = Nis::where('siswa_id', $siswa->id)->get();
        return view('siswa/nisSiswa', ['siswa' => $siswa, 'nis' => $nisSiswa]);
    }
    public function EditNis(Siswa $siswa, Nis $nis)
    {
        $nisSiswa = $nis->join(
            'siswa',
            'siswa.id',
            '=',
            'nis.siswa_id'
        )
        ->find($nis)->first();
        return view(
            'siswa.editnis',
            [
                'siswa' => $siswa,
                'nis' => $nis,
                'nisSiswa' => $nisSiswa
            ]
        );
    }
    public function UpdateNis(Nis $nis, Request $request)
    {
        Nis::where('id', $nis->id)
            ->update([
                'siswa_id' => $request->siswa_id,
                'nis' => $request->nis,
                'nama_lembaga' => $request->nama_lembaga,
                'madrasah_diniyah' => $request->madrasah_diniyah,
            'tanggal_masuk' => $request->tanggal_masuk,
            ]);
        return redirect('/nis/' . $nis->siswa_id)->with('update', 'pembaharuan data NIM berhasil');
        
    }
    public function statuspengamal(Siswa $siswa,)
    {
        $sp = Statuspengamal::query()
            ->join('siswa', 'siswa.id', '=', 'statuspengamal.siswa_id')
            ->select(
                [
                    'siswa.id',
                    'siswa.nama_siswa',
                    'statuspengamal.status_pengamal',
                ]
            )
            ->where('statuspengamal.siswa_id', $siswa->id)->get();
        $nisSiswa = Nis::where('siswa_id', $siswa->id)->get();
        return view(
            'siswa/statuspengamal',
            [
                'siswa' => $siswa,
                'nis' => $nisSiswa,
                'sp' => $sp,
            ]
        );
    }
    public function statusanak(Siswa $siswa)
    {
        $sp = Statusanak::query()
            ->where('statusanak.siswa_id', $siswa->id)->get();

        return view(
            'siswa/statusanak/index',
            [
                'siswa' => $siswa,
                
                'sp' => $sp,
            ]
        );
    }
    public function HapusStatusAnaka(Statusanak $statusanak)
    {
        Statusanak::destroy($statusanak->id);
        return redirect()->back();
    }
    public function transkip(Request $request, Siswa $siswa)
    {
        $nilai = DB::table('pesertakelas')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('nilaimapel', 'nilaimapel.kelasmi_id', '=', 'kelasmi.id')
            ->leftJoin('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
            ->leftJoin('guru', 'guru.id', '=', 'nilaimapel.guru_id')
            ->leftJoin('nilai', function ($join) {
                $join->on('nilai.pesertakelas_id', '=', 'pesertakelas.id')
                    ->on('nilai.nilaimapel_id', '=', 'nilaimapel.id');
            })
            ->where('pesertakelas.siswa_id', $siswa->id)
            ->select(
                'pesertakelas.id',
                'kelasmi.nama_kelas',
                'periode.periode',
                'semester.ket_semester',
                'guru.nama_guru',
                'mapel.mapel',
                'nilai.nilai_harian',
                'nilai.nilai_ujian'
            );

        if (request('cari')) {
            $nilai->where('semester.ket_semester', 'like', '%' . request('cari') . '%');
        }

        return view('siswa/transkip', [
            'siswa' => $siswa,
            'title' => $siswa,
            'nilai' => $nilai->get(),
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        $status_pengamal = Statuspengamal::where('siswa_id', $siswa->id)->first();
        $statusAnak = Statusanak::where('siswa_id', $siswa->id)->first();

        return view('siswa/editsiswa', [
            'siswa' => $siswa,
            'status_pengamal' => $status_pengamal,
            'statusAnak' => $statusAnak,
        ]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_siswa' => 'required|min:3|max:100',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        $siswa->update($request->only([
            'nama_siswa',
            'jenis_kelamin',
            'agama',
            'tempat_lahir',
            'tanggal_lahir',
            'kota_asal',
        ]));

        if ($request->filled('status_pengamal')) {
            Statuspengamal::updateOrCreate(
                ['siswa_id' => $siswa->id],
                ['status_pengamal' => $request->status_pengamal]
            );
        }

        $saData = array_filter($request->only([
            'status_anak',
            'anak_ke',
            'jumlah_saudara',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'nomor_hp_ayah',
            'nomor_hp_ibu',
        ]), fn($v) => $v !== null && $v !== '');

        if (!empty($saData)) {
            Statusanak::updateOrCreate(
                ['siswa_id' => $siswa->id],
                $saData
            );
        }

        return redirect()->back()->with('update', 'Pembaharuan data berhasil');
    }

    public function destroy(Siswa $siswa)
    {
        Siswa::destroy($siswa->id);
        return redirect()->back()->with('delete', 'data berhasil dihapus');
    }
    public function destroyNis(Nis $nis)
    {
        Nis::destroy($nis->id);
        return redirect()->back();
    }
    public function destroySP(Statuspengamal $statuspengamal)
    {
        try {
            $statuspengamal->delete();

            return back()->with('success', 'Status pengamal berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Status pengamal gagal dihapus.');
        }
    }
}
