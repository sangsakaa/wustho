<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nis;
use App\Models\Siswa;
use App\Models\Pesertaasrama;
use App\Models\Statusanak;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use App\Models\Statuspengamal;
use Illuminate\Routing\Controller;
use DataTables;

class SiswaController extends Controller
{
    
    
    public function index()
    {
        
        $data = Siswa::latest();
        
        if (request('cari')) {
            $data->where('nama_siswa', 'like', '%' . request('cari') . '%');
           
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
        $validated = $request->validate([
            'nama_siswa' => 'required|min:5|max:50',
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

        $bulan = $request->bulan ? Carbon::parse($request->bulan) : now();
        $periodeBulan = $bulan->startOfMonth()->daysUntil($bulan->copy()->endOfMonth());
        $nilai = Pesertakelas::query()
            ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
            ->join('periode', 'periode.id', '=', 'kelasmi.periode_id')
            ->join('semester', 'semester.id', '=', 'periode.semester_id')
            ->where('pesertakelas.siswa_id', $siswa->id)->get();
        $historiAsrama = Pesertaasrama::query()
        ->join('asramasiswa', 'asramasiswa.id', '=', 'pesertaasrama.asramasiswa_id')
        ->join('asrama', 'asrama.id', '=', 'asramasiswa.asrama_id')
        ->join('periode', 'periode.id', '=', 'asramasiswa.periode_id')
        ->join('semester', 'semester.id', '=', 'periode.semester_id')
        ->where('siswa_id', $siswa->id)->get();
        $PresensiAsrama = Pesertaasrama::query()
        ->join('presensiasrama', 'pesertaasrama.id', '=', 'presensiasrama.pesertaasrama_id')
        ->join('sesiasrama', 'sesiasrama.id', '=', 'presensiasrama.sesiasrama_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sesiasrama.kegiatan_id')
            ->whereBetween('sesiasrama.tanggal', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
        ->where('siswa_id', $siswa->id)
        ->orderBy('tanggal')
        ->orderBy('kegiatan');
        if (request('bulan')) {
            $PresensiAsrama->where('tanggal', 'like', '%' . request('bulan') . '%');
        };
        $PresensiKelas = Pesertakelas::query()
        ->join('absensikelas', 'pesertakelas.id', '=', 'absensikelas.pesertakelas_id')
        ->join('sesikelas', 'sesikelas.id', '=', 'absensikelas.sesikelas_id')
        ->join('kelasmi', 'kelasmi.id', '=', 'pesertakelas.kelasmi_id')
        ->join('kelas', 'kelas.id', '=', 'kelasmi.kelas_id')
        ->where('kelasmi.periode_id', session('periode_id'))
        ->whereBetween('sesikelas.tgl', [$periodeBulan->first()->toDateString(), $periodeBulan->last()->toDateString()])
        ->where('siswa_id', $siswa->id);
        if (request('bulan')) {
            $PresensiKelas->where('tgl', 'like', '%' . request('bulan') . '%');
        }

        return view(
            'siswa/detailSiswa',
            [
                'siswa' => $siswa,
                'pesertakelas' => $nilai,
                'historiAsrama' => $historiAsrama,
                'PresensiAsrama' => $PresensiAsrama->get(),
                'PresensiKelas' => $PresensiKelas->get(),
                'bulan' => $bulan,
                'periodeBulan' => $periodeBulan,
                
            ]
        );
    }
    public function biodata(Siswa $siswa)
    {
        $biodata = $siswa->query()
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftjoin('statusanak', 'statusanak.siswa_id', '=', 'siswa.id')
            ->where('nis.siswa_id', $siswa->id)
            ->first();
        return view(
            'siswa/biodata',

            [

                'siswa' => $siswa,
                'biodata' => $biodata
            ]
        );
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
        return redirect('/nis/' . $nis->siswa_id);
        
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

    public function transkip(Request $request, Siswa $siswa)
    {

        $nilai = Pesertakelas::query()
            ->where('pesertakelas.siswa_id', $siswa->id);
        
        if (request('cari')) {
            $nilai->where('ket_semester', 'like', '%' . request('cari') . '%');
        }
        $title = $siswa;
        return view(
            'siswa/transkip',
            [
                'siswa' => $siswa,
                'title' => $title,
                'nilai' => $nilai->get(),
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
            'nama_lembaga' => $request->agama,
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
