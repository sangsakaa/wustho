<?php

namespace App\Http\Controllers;

use App\Models\Nis;
use App\Models\Kelas;
use App\Models\Kelasmi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\Pesertakelas;
use App\Models\Statusanak;
use App\Models\Statuspengamal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::query()
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftjoin('pesertaasrama', 'pesertaasrama.siswa_id', '=', 'siswa.id')
            ->leftjoin('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
            ->leftjoin('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
            ->leftjoin('pesertakelas', 'pesertakelas.siswa_id', '=', 'siswa.id')
            ->leftjoin('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->orderBy('nis')
            ->orderBy('nama_siswa')
            // ->orderBy('nama_siswa')

            ->select(
                [
                    'nis.nis',
                    'nis.tanggal_masuk',
                    'siswa.id',
                    'siswa.nama_siswa',
                    'siswa.jenis_kelamin',
                    'siswa.tempat_lahir',
                    'siswa.tanggal_lahir',
                    'kelasmi.nama_kelas',
                    'asrama.nama_asrama'
                ]
            );
            // ->latest()->orderBy('nama_siswa');
        if (request('cari')) {
            $data->where('nama_siswa', 'like', '%' . request('cari') . '%')
                ->orWhere('Kota_asal', 'like', '%' . request('cari') . '%')
            ->orWhere('nama_kelas', 'like', '%' . request('cari') . '%')
            ->orWhere('nis', 'like', '%' . request('cari') . '%')
            ->orWhere('tanggal_masuk', 'like', '%' . request('cari') . '%')
            ->orderBy('nis', 'asc');
        }
        return view('siswa/siswa', ['dataSiswa' => $data->paginate(10)]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa/addsiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['nama_siswa' => 'required|min:5|max:50',

        ], [
            'nama_siswa.min' => 'tidak boleh kurang dari 5 karakter',
            'nama_siswa.max' => 'tidak boleh lebih dari 60 karakter'
        ]);
        $siswa = new Siswa();
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->agama = $request->agama;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->kota_asal = $request->kota_asal;
        $siswa->save();
        
        return redirect('siswa')->with('success', 'data berhasil ditambahkan');
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
        return redirect('siswa');
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
        $statusanak->save();
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa, Pesertakelas $pesertakelas)
    {
        $pes = Pesertakelas::query()
            ->join('siswa', 'siswa.id', 'pesertakelas.siswa_id')
            ->select('pesertakelas.siswa_id', 'siswa.nama_siswa')
            ->where('siswa_id', $siswa->id)
            ->first();
        return view(
            'siswa/detailSiswa',
            [
                'siswa' => $siswa,
                'pesertakelas' => $pes
            ]
        );
    }
    public function biodata(Siswa $siswa)
    {
        $data = Siswa::where('siswa.id', $siswa->id)
            ->leftjoin('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->join('statuspengamal', 'siswa.id', '=', 'statuspengamal.siswa_id')
            ->join('statusanak', 'siswa.id', '=', 'statusanak.siswa_id')
            ->first();
        return view('siswa/biodata', ['siswa' => $data]);
    }
    public function nis(Siswa $siswa)
    {
        $nisSiswa = Nis::where('siswa_id', $siswa->id)->get();
        return view('siswa/nisSiswa', ['siswa' => $siswa, 'nis' => $nisSiswa]);
    }
    public function statuspengamal(Siswa $siswa,)
    {
        $sp = Statuspengamal::query()
            // ->join('siswa', 'siswa.id', '=', 'statuspengamal.siswa_id')
            // ->select(
            //     [
            //         'siswa.id',
            //         'siswa.nama_siswa',
            //         'statuspengamal.status_pengamal',
            //     ]
            // )
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
            'siswa/statusanak',
            [
                'siswa' => $siswa,
                
                'sp' => $sp,
            ]
        );
    }
    public function DetailKelas(Siswa $siswa, Kelas $kelas)
    {

        $data = siswa::query()
            ->get();
        $dataKelas = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelas_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('kelas', 'kelas.id', '=', 'pesertakelas.kelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            // ->where('Pesertakelas.siswa_id', $siswa->id)
            ->get();
        return view('siswa/detailSiswa', ['detailKelas' => $data, 'siswa' => $siswa, 'dataKelas' => $dataKelas]);
    }
    public function transkip(Pesertakelas $pesertakelas, Siswa $siswa)
    {
        
        $transkip = Nilai::query()
            ->join('pesertakelas', 'pesertakelas.id', '=', 'nilai.pesertakelas_id')
            ->join('siswa', 'siswa.id', '=', 'pesertakelas.siswa_id')
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
        ->join('mapel', 'mapel.id', '=', 'nilaimapel.mapel_id')
        ->join('guru', 'guru.id', '=', 'nilaimapel.guru_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->select(
            [

                'siswa.nama_siswa',
                'guru.nama_guru',
                'nilai.nilai_ujian',
                'nilai.nilai_harian',
                'kelasmi.nama_kelas',
                'kelasmi.periode_id',
                'periode.periode',
                // 'periode.id',
                'semester.id',
                'semester.ket_semester',
                'mapel.mapel',
            ]
        )
            ->where('pesertakelas.siswa_id', $siswa->id);
        if (request('cari')) {
            $transkip->where(function ($query) {
                $query->where('semester', 'like', '%' . request('cari') . '%');
            });
        }
        $jmlujian = $transkip->sum('nilai_ujian');
        $countujian = $transkip->count('nilaimapel_id');
        $jmlharian = $transkip->sum('nilai_harian');
        $rata1 = $jmlharian / $countujian;
        $rata2 = $jmlujian / $countujian;
        $periode = Periode::query()
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->select('semester.id', 'periode.periode', 'semester.ket_semester')
            ->get();
        $tittle = Siswa::join('nis', 'siswa.id', '=', 'nis.siswa_id')
            ->select('nis.nis', 'siswa.nama_siswa')
            ->find($siswa->id);
        $harini = $transkip->get();
        return view(
            'siswa/transkip',
            [

                'tittle' => $tittle,
                'siswa' => $siswa,
                'periode' => $periode,
                'jmlujian' => $jmlujian,
                'jmlharian' => $jmlharian,
                'countujian' => $countujian,
                'rata2' => $rata2,
                'rata1' => $rata1,
                'transkip' => $transkip->get(),
                'harini' => $harini
            ]
        );
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {

        return view(
            'siswa/editsiswa',
            [
                'siswa' => $siswa,

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        Siswa::where('id', $siswa->id)
            ->update([
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kota_asal' => $request->kota_asal,
            ]);
        
        return redirect('/siswa')->with('update', 'pembaharuan data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        Siswa::destroy($siswa->id);
        return redirect()->back()->with('delete', 'data berhasil dihapus');
    }
    public function destroyNis(Nis $nis)
    {
        // dd($nis);
        Nis::destroy($nis->id);
        return redirect()->back();
    }
    public function destroySP(Statuspengamal $siswa)

    {

        Statuspengamal::destroy($siswa->id);
        return redirect()->back();
    }
}
