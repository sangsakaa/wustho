<?php

namespace App\Http\Controllers;

use App\Models\Nis;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Pesertakelas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
        return view('siswa/siswa', ['dataSiswa' => $data->paginate(20)]);
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
            'nama_siswa' => 'required|min:5|max:25',

        ], [
            'nama_siswa.min' => 'tidak boleh kurang dari 2 karakter',
            'nama_siswa.max' => 'tidak boleh lebih dari 3 karakter'
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
        // $siswa = $request->validate(
        //     [
        //         'nama_siswa' => 'required',
        //     ]
        // );
        $nis = new nis();
        $nis->siswa_id = $request->siswa_id;
        $nis->nis = $request->nis;
        $nis->nama_lembaga = $request->nama_lembaga;
        $nis->madrasah_diniyah = $request->madrasah_diniyah;
        $nis->tanggal_masuk = $request->tanggal_masuk;
        $nis->save();
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
        $pes = Nilai::Find($pesertakelas)->first();
        return view('siswa/detailSiswa', ['siswa' => $siswa, 'pesertakelas' => $pes]);
    }
    public function biodata(Siswa $siswa)
    {
        $data = Siswa::where('siswa.id', $siswa->id)
            ->leftjoin('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->first();
        return view('siswa/biodata', ['siswa' => $data]);
    }
    public function nis(Siswa $siswa)
    {
        $nisSiswa = Nis::where('siswa_id', $siswa->id)->get();
        return view('siswa/nisSiswa', ['siswa' => $siswa, 'nis' => $nisSiswa]);
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
    public function transkip(Pesertakelas $pesertakelas)
    {
        $transkip = Nilai::query()
            ->join('nilaimapel', 'nilaimapel.id', '=', 'nilai.nilaimapel_id')
            ->join('mapel', 'nilaimapel.mapel_id', '=', 'mapel.id')
            // ->select('nilai.nilaimapel_id')
            ->find($pesertakelas)->first();
        return view('siswa/transkip', ['siswa' => $transkip,]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        return view('siswa/editsiswa', ['siswa' => $siswa]);
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
}
